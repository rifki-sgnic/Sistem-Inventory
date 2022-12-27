moment.locale("id");

$(document).ready(function () {
    bsCustomFileInput.init();
});

async function dataChart() {
    let data;
    const res = await fetch("/chart");
    data = await res.json();
    console.log(data);

    length = data.length;
    // console.log(length)

    labels = [];
    values = [];

    for (var i = 0; i < length; i++) {
        // console.log(labels)
        labels.push(data[i].nama_produk);
        values.push(data[i].qty);
    }

    const maxValue = Math.max.apply(Math, values);

    var colors = [];
    var borderColors = [];

    for (var i = 0; i < values.length; i++) {
        var color;
        var borderColor;
        if (values[i] <= 3) {
            color = "rgba(255, 99, 132, 0.2)";
            borderColor = "rgb(255, 99, 132)";
        } else if (values[i] <= 7) {
            color = "rgba(255, 205, 86, 0.2)";
            borderColor = "rgb(255, 205, 86)";
        } else {
            color = "rgba(75, 192, 192, 0.2)";
            borderColor = "rgb(75, 192, 192)";
        }
        colors[i] = color;
        borderColors[i] = borderColor;
    }

    new Chart(document.getElementById("myChart"), {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Data Stock Barang",
                    data: values,
                    backgroundColor: colors,
                    borderColor: borderColors,
                    borderWidth: 1,
                },
            ],
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: maxValue + 5,
                },
            },
            layout: {
                padding: 25,
            },
        },
    });
}

dataChart();

function getAlertData() {
    var content = "";
    $.ajax({
        url: "/chart",
        dataType: "json",
        success: function (response) {
            data = response;

            length = data.length;

            for (var i = 0; i < length; i++) {
                if (data[i].qty == 0) {
                    content +=
                        `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"> Stok ` +
                        data[i].nama_produk +
                        ` Habis` +
                        `<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        `;
                } else if (data[i].qty <= 3) {
                    content +=
                        `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"> Stok ` +
                        data[i].nama_produk +
                        ` tersisa ` +
                        data[i].qty +
                        `<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;
                } else if (data[i].qty <= 7) {
                    content +=
                        `
                        <div class="alert alert-warning alert-dismissible fade show" role="alert"> Stok ` +
                        data[i].nama_produk +
                        ` Menipis
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    `;
                }
            }

            $("#alertstock").html(content);
        },
    });
}

getAlertData();

var list_barang = [];

var tambah_request = $("#tambah_request");
tambah_request.on("click", function () {
    var no_purchase_request = $("#no_purchase_request").val();
    var tanggal = $("#tanggal").val();

    if (no_purchase_request && tanggal) {
        if (list_barang.length > 0) {
            data = JSON.stringify({
                no_purchase_request: no_purchase_request,
                tanggal: tanggal,
                list_barang: list_barang,
            });

            $.ajax({
                url: "/request-barang/store",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                contentType: "application/json",
                dataType: "json",
                data: data,
            }).then(function (response) {
                tambah_request.disabled = true;
                alert(response.message);
                window.location.href = "/request-barang";
            });
        } else {
            $("#inputRequest .invalid-feedback").show();
        }
    } else {
        $("#inputRequest .invalid-tooltip").show();
    }
});

var tableRequest = $("#tableRequest tbody");
var tambah_barang = $("#tambah_barang");

tambah_barang.on("click", function () {
    var products_id = $("#products_id").find(":selected").val();
    var product = $("#products_id").find(":selected").text();
    var jumlah = $("#jumlah").val();
    var harga = $("#harga").val();
    var remarks = $("#remarks").val();

    console.log(product);

    if (products_id && jumlah && harga && remarks) {
        barang = {
            products_id: products_id,
            qty: jumlah,
            harga: harga,
            remarks: remarks,
        };

        list_barang.push(barang);
        console.log(list_barang);

        barang = {};

        var markup = `<tr>
        <td>${list_barang.length}</td>
        <td>${product}</td>
        <td>${jumlah}</td>
        <td>${harga}</td>
        <td>${remarks}</td>
        <td><button id="btn_delete" value="${list_barang.length}" class="btn btn-sm btn-danger"><i class="fa fa-times text-white"></i></button></td>
    </tr>`;

        tableRequest.append(markup);
    } else {
        $("#inputBarang .invalid-tooltip").show();
    }
});

tableRequest.on("click", "button", function () {
    var data = $(this).closest("tr");

    if ($(this).prop("id") == "btn_delete") {
        list_barang.splice(
            list_barang.findIndex(
                ({ product }) => product == data.find("td:eq(1)").text()
            ),
            1
        );
        data.remove();
    }
});

var tableDetailRequest = $("#tableDetailRequest");
var listDetailRequest = [];
var barangDetailRequest = {};
tableDetailRequest.find("tbody").on("click", "button", function () {
    var row = $(this).closest("tr");
    var data = row.find("td");

    console.log(data)

    var produk = data[1].innerHTML;
    var jumlah = data[2].innerHTML;
    var harga = data[3].innerHTML;
    var remarks = data[4].innerHTML;
    var id = data[5].innerHTML;
    var note = data[6].text;

    // barangDetailRequest = {
    //     products_id: produk,
    //     qty: jumlah,
    //     harga: harga,
    //     remarks: remarks,
    // };
    // console.log(barangDetailRequest.products_id);

    // listDetailRequest.push(barangDetailRequest)
    // console.log(listDetailRequest);

    // console.log(data.find)

    if ($(this).prop("value") == "update") {
        // var produk = data.find("#produk").text();
        // var qty = data.find("#qty").text();
        // console.log(qty);

        $("#modalUpdateData").find('input[name="produk"]').val(produk);
        $("#modalUpdateData").find('input[name="qty"]').val(jumlah);
        $("#modalUpdateData").find('input[name="harga"]').val(harga);
        $("#modalUpdateData").find('input[name="remarks"]').val(remarks);
        $("#modalUpdateData").find('input[name="id"]').val(id);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(produk);

        $("#modalHapusData").find("input[name='id']").val(id);
        $("#modalHapusData").modal("show");
    } else if ($(this).prop("value") == "add-note") {
        $("#modalAddNote").find("textarea[name='note']").val(note);
        $("#modalAddNote").find("input[name='id']").val(id);
        $("#modalAddNote").modal("show");
    }
});
