// Fix DataTable on Nav Tabs (Dashboard)
$('button[data-toggle="tab"]').on("shown.tab", function (event) {
    $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
});

/* DataTable Master Barang [START] */
var tableMasterBarang = $("#tableMasterBarang").DataTable({
    deferRender: true,
    ajax: "/master",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "kd_produk" },
        { data: "nama_produk" },
        { data: "type" },
        { data: "merk" },
        { data: "qty" },
        {
            data: null,
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
            `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableMasterBarang tbody").on("click", "button", function () {
    var data = tableMasterBarang.row($(this).parents("tr")).data();
    if ($(this).prop("value") == "update") {
        $("#modalUpdateData")
            .find("input[name='kd_produk']")
            .val(data["kd_produk"]);
        $("#modalUpdateData")
            .find("input[name='nama']")
            .val(data["nama_produk"]);
        $("#modalUpdateData").find("input[name='type']").val(data["type"]);
        $("#modalUpdateData").find("input[name='merk']").val(data["merk"]);
        $("#modalUpdateData").find("input[name='qty']").val(data["qty"]);
        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
        // alert('clicked');
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["kd_produk"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData").modal("show");
    }
});
/* DataTable Master Barang [END] */

/* DataTable Supplier [START] */
var tableSupplier = $("#tableSupplier").DataTable({
    deferRender: true,
    ajax: "/supplier",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "kd_supplier" },
        { data: "nama_supplier" },
        { data: "no_tlp" },
        { data: "alamat" },
        {
            data: null,
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableSupplier tbody").on("click", "button", function () {
    var data = tableSupplier.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "update") {
        $("#modalUpdateData")
            .find("input[name='kd_supplier']")
            .val(data["kd_supplier"]);
        $("#modalUpdateData")
            .find("input[name='nama_supplier']")
            .val(data["nama_supplier"]);
        $("#modalUpdateData").find("input[name='no_tlp']").val(data["no_tlp"]);
        $("#modalUpdateData").find("input[name='alamat']").val(data["alamat"]);
        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["nama_supplier"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData").modal("show");
    }
});

/* DataTable Supplier [END] */

/* DataTable List Product [START] */

var tableListBarang = $("#tableListBarang").DataTable({
    deferRender: true,
    ajax: "/list-barang",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "invoice_number" },
        {
            data: null,
            render: function (data) {
                return moment(data.created_at).format("DD MMMM YYYY");
            },
        },
        { data: "no_request_product" },
        { data: "no_pre_order" },
        {
            data: null,
            render: function (data, type, full, meta) {
                return (
                    '<a href="storage/post-pdf/' +
                    data.file +
                    '">' +
                    data.file +
                    "</a>"
                );
            },
        },
        {
            data: null,
            render: function (data, type, full, meta) {
                if (data.status == "receive") {
                    return '<span class="btn btn-sm btn-success disabled">Receive</span>';
                } else if (data.status == "indend") {
                    return '<span class="btn btn-sm btn-primary disabled">Indend</span>';
                } else {
                    return `<div id="add">
                    <button type="button" id="add_status" value="add_status" class="btn btn-sm btn-primary"><i class="fa fa-plus text-white"></i></button>
                    </div>`;
                }
            },
        },
        {
            data: null,
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableListBarang tbody").on("click", "button", function () {
    var data = tableListBarang.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "update") {
        $("#modalUpdateData")
            .find("input[name='no_request_product']")
            .val(data["no_request_product"]);
        $("#modalUpdateData")
            .find("input[name='no_pre_order']")
            .val(data["no_pre_order"]);
        $("#modalUpdateData").find("select[name='status']").val(data["status"]);
        $("#modalUpdateData")
            .find("input[name='created_at']")
            .val(moment(data["created_at"]).format("yyyy-MM-DD"));

        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["no_request_product"]);

        $("#modalHapusData")
            .find("input[name='id']")
            .val(data["invoice_number"]);
        $("#modalHapusData").modal("show");
    } else if ($(this).prop("value") == "add_status") {
        $("#add_status").remove();

        var value = ["", "Receive", "Indend"];
        var parent = $("#tableListBarang tbody tr td #add");

        const select = document.createElement("select");
        select.id = "status";
        select.name = "status";
        select.className = "custom-select";

        const options = value.map((status) => {
            const val = status.toLocaleLowerCase();
            return `<option value="${val}">${status}</option>`;
        });
        select.innerHTML = options;
        parent.append(select);
    }
});

/* Aksi Update Status dengan Selected Option */
$("#tableListBarang tbody").on("change", 'select[name="status"]', function () {
    var data = tableListBarang.row($(this).parents("tr")).data();
    id = data["id"];
    value = $(this).find(":selected").val();
    console.log(value);

    $.ajax({
        url: "/list-barang",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: { id: id, status: value },
        type: "POST",
        success: function (response) {
            console.log(response);
        },
        error: function (x) {
            console.log(x.responseText);
        },
    });
});

/* DataTable List Product [END] */

/* DataTable Receive [START] */
var tableReceive = $("#tableReceive").DataTable({
    deferRender: true,
    ajax: "/receive",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "invoice_number" },
        {
            data: null,
            render: function (data) {
                return moment(data.created_at).format("DD MMMM YYYY");
            },
        },
        {
            data: null,
            render: function (data, type, full, meta) {
                return (
                    data.products.kd_produk +
                    " - " +
                    data.products.nama_produk +
                    " - " +
                    data.products.type
                );
            },
        },
        { data: "qty" },
        {
            data: null,
            render: function (data) {
                return (
                    data.suppliers.kd_supplier +
                    " - " +
                    data.suppliers.nama_supplier
                );
            },
        },
        { data: "note" },
        {
            data: null,
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableReceive tbody").on("click", "button", function () {
    var data = tableReceive.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "update") {
        $("#modalUpdateData")
            .find("select[name='products_id']")
            .val(data["products_id"]);
        $("#modalUpdateData").find("input[name='qty']").val(data["qty"]);
        $("#modalUpdateData")
            .find("select[name='suppliers_id']")
            .val(data["suppliers_id"]);
        $("#modalUpdateData")
            .find("input[name='created_at']")
            .val(moment(data["created_at"]).format("yyyy-MM-DD"));
        $("#modalUpdateData").find("textarea[name='note']").val(data["note"]);

        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["invoice_number"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData")
            .find("input[name='products_id']")
            .val(data["products_id"]);
        $("#modalHapusData")
            .find("input[name='invoice_number']")
            .val(data["invoice_number"]);
        $("#modalHapusData").modal("show");
    }
});

/* DataTable Receive [END] */

/* DataTable Transaction [START] */
var tableTransaction = $("#tableTransaction").DataTable({
    deferRender: true,
    ajax: "/transaction",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "invoice_number" },
        {
            data: null,
            render: function (data) {
                return moment(data.created_at).format("DD MMMM YYYY");
            },
        },
        {
            data: null,
            render: function (data, type, full, meta) {
                return (
                    data.products.kd_produk +
                    " - " +
                    data.products.nama_produk +
                    " - " +
                    data.products.type
                );
            },
        },
        { data: "qty" },
        { data: "pic" },
        { data: "note" },
        {
            data: null,
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableTransaction tbody").on("click", "button", function () {
    var data = tableTransaction.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "update") {
        $("#modalUpdateData")
            .find("select[name='products_id']")
            .val(data["products_id"]);
        $("#modalUpdateData").find("input[name='qty']").val(data["qty"]);
        $("#modalUpdateData").find("input[name='pic']").val(data["pic"]);
        $("#modalUpdateData")
            .find("input[name='created_at']")
            .val(moment(data["created_at"]).format("yyyy-MM-DD"));
        $("#modalUpdateData").find("textarea[name='note']").val(data["note"]);

        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["invoice_number"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData")
            .find("input[name='products_id']")
            .val(data["products_id"]);
        $("#modalHapusData")
            .find("input[name='invoice_number']")
            .val(data["invoice_number"]);
        $("#modalHapusData").modal("show");
    }
});

/* DataTable Transaction [END] */

/* DataTable Return [START] */

var tableBarangReturn = $("#tableBarangReturn").DataTable({
    deferRender: true,
    ajax: "/return",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "invoice_number" },
        {
            data: null,
            render: function (data) {
                return moment(data.created_at).format("DD MMMM YYYY");
            },
        },
        {
            data: null,
            render: function (data) {
                console.log(data);
                return data.list_products.no_pre_order;
            },
        },
        {
            data: null,
            render: function (data, type, full, meta) {
                return (
                    data.products.kd_produk +
                    " - " +
                    data.products.nama_produk +
                    " - " +
                    data.products.type
                );
            },
        },
        { data: "qty" },
        { data: "note" },
        {
            data: null,
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableBarangReturn tbody").on("click", "button", function () {
    var data = tableBarangReturn.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "update") {
        $("#modalUpdateData")
            .find("select[name='products_id']")
            .val(data["products_id"]);
        $("#modalUpdateData").find("input[name='qty']").val(data["qty"]);
        $("#modalUpdateData")
            .find("select[name='suppliers_id']")
            .val(data["suppliers_id"]);
        $("#modalUpdateData")
            .find("input[name='created_at']")
            .val(moment(data["created_at"]).format("yyyy-MM-DD"));
        $("#modalUpdateData").find("textarea[name='note']").val(data["note"]);

        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["invoice_number"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData")
            .find("input[name='products_id']")
            .val(data["products_id"]);
        $("#modalHapusData")
            .find("input[name='invoice_number']")
            .val(data["invoice_number"]);
        $("#modalHapusData").modal("show");
    }
});

/* DataTable Return [END] */

/* DataTable User Management [START] */
var tableUserData = $("#tableUserData").DataTable({
    deferRender: true,
    ajax: "/user-management",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "name" },
        { data: "username" },
        {
            data: null,
            render: function (data) {
                return data.roles[0].name;
            },
        },
        {
            data: null,
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning"><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableUserData tbody").on("click", "button", function () {
    var data = tableUserData.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "update") {
        $("#modalUpdateData").find("input[name='name']").val(data["name"]);
        $("#modalUpdateData")
            .find("input[name='username']")
            .val(data["username"]);
        $("#modalUpdateData")
            .find("select[name='role']")
            .val(data.roles[0].name);
        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["name"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData").modal("show");
    }
});

/* DataTable User Management [END] */
