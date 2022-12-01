moment.locale();
moment().format("L");

$(document).ready(function () {
    bsCustomFileInput.init();
});

async function dataChart() {
    let data;
    const res = await fetch('/chart')
    data = await res.json();
    console.log(data)

    length = data.length
    // console.log(length)

    labels = [];
    values = [];

    for (var i = 0; i < length; i++) {
        // console.log(labels)
        labels.push(data[i].nama_produk);
        values.push(data[i].qty);
    }

    const maxValue = Math.max.apply(Math, values)

    var colors = [];
    var borderColors = [];

    for (var i = 0; i < values.length; i++) {
        var color;
        var borderColor;
        if (values[i] <= 5) {
            color = "rgba(255, 99, 132, 0.2)";
            borderColor = "rgb(255, 99, 132)";
        } else if (values[i] <= 10) {
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
                    suggestedMax: maxValue + 5
                },
            },
            layout: {
                padding: 25
            }
        },
    });
}

dataChart();

function getAlertData() {
    var content = "";
    $.ajax({
        url: '/chart',
        dataType: 'json',
        success: function(response) {
            data = response

            length = data.length

            for (var i = 0; i < length; i++) {
                if (data[i].qty <= 5) {
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
                } else if (data[i].qty <= 10) {
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

            $('#alertstock').html(content);
        }
    })
}

getAlertData();
