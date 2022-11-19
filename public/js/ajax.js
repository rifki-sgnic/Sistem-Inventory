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
        { data: "role" },
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
        $("#modalUpdateData").find("select[name='role']").val(data["role"]);
        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["name"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData").modal("show");
    }
});

/* DataTable User Management [END] */

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
        { data: "id" },
        { data: null,
        render: function(data) {
            return moment(data.created_at).format("DD MMMM YYYY");
        } },
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
        // $("#modalUpdateData").find("input[name='name']").val(data["name"]);
        // $("#modalUpdateData")
        //     .find("input[name='username']")
        //     .val(data["username"]);
        // $("#modalUpdateData").find("select[name='role']").val(data["role"]);
        // $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData").find("p strong").html(data["id"]);
        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData").modal("show");
    }
});

/* DataTable Receive [END] */
