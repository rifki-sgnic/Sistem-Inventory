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
            .find("input[name='nama_produk']")
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
            data: "action",
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning" disabled><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
    columnDefs: [
        {
            targets: [5],
            render: function (data, type, row, meta) {
                if (row.action != undefined) {
                    return row.action;
                } else {
                    tableSupplier.columns([5]).visible(false);
                }
            },
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
        {
            data: null,
            render: function (data) {
                return `<a href="/request-barang/detail/${data.request_products.no_purchase_request}">${data.request_products.no_purchase_request}</a>`;
            },
        },
        { data: "no_pre_order" },
        {
            data: null,
            render: function (data, type, full, meta) {
                return `<a href="storage/post-pdf/${data.file}">${data.file}</a>`;
            },
        },
        { data: "supplier" },
        { data: "status" },
        {
            data: "action",
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning" disabled><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
    columnDefs: [
        {
            targets: [8],
            render: function (data, type, row, meta) {
                if (row.action != undefined) {
                    return row.action;
                } else {
                    tableListBarang.columns([8]).visible(false);
                }
            },
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableListBarang tbody").on("click", "button", function () {
    var data = tableListBarang.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "update") {
        $("#modalUpdateData")
            .find("input[name='no_purchase_request']")
            .val(data.request_products.no_purchase_request);
        $("#modalUpdateData")
            .find("input[name='no_pre_order']")
            .val(data["no_pre_order"]);
        $("#modalUpdateData")
            .find("select[name='suppliers_id']")
            .val(data["suppliers_id"]);
        $("#modalUpdateData")
            .find("select[name='status']")
            .val($(data["status"]).text().toLowerCase().trim());
        $("#modalUpdateData")
            .find("input[name='created_at']")
            .val(moment(data["created_at"]).format("yyyy-MM-DD"));

        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData")
            .find("input[name='request_products_id']")
            .val(data.request_products_id);
        $("#modalUpdateData").modal("show");
    } else if ($(this).prop("value") == "delete") {
        $("#modalHapusData")
            .find("p strong")
            .html(data.request_products.no_purchase_request);

        $("#modalHapusData").find("input[name='id']").val(data["id"]);
        $("#modalHapusData").modal("show");
    } else if ($(this).prop("value") == "add_status") {
        var value = ["", "Receive", "Indent"];
        var parent = $(this).closest("tr").find("#add-status");

        $.each(parent, function () {
            $(this).find("#add_status").hide();

            const select = document.createElement("select");
            select.id = "status";
            select.name = "status";
            select.className = "custom-select custom-select-sm mx-1";

            const options = value.map((status) => {
                const val = status.toLocaleLowerCase();
                return `<option value="${val}">${status}</option>`;
            });
            select.innerHTML = options;
            parent.append(select);

            const closeBtn = document.createElement("button");
            closeBtn.id = "close_btn";
            closeBtn.value = "close_btn";
            closeBtn.className = "btn btn-sm btn-danger mx-1";
            closeBtn.innerHTML = `<i class="fa fa-times text-white"></i>`;

            parent.append(closeBtn);
        });
    } else if ($(this).prop("value") == "edit_status") {
        var value = ["", "Receive", "Indent"];
        var parent = $(this).closest("tr").find("#edit-status");

        $.each(parent, function () {
            $(this).find("#label_status").hide();
            $(this).find("#edit_status").hide();

            const select = document.createElement("select");
            select.id = "status";
            select.name = "status";
            select.className = "custom-select custom-select-sm mx-1";

            const options = value.map((status) => {
                const val = status.toLocaleLowerCase();
                return `<option value="${val}">${status}</option>`;
            });
            select.innerHTML = options;
            parent.append(select);

            const closeBtn = document.createElement("button");
            closeBtn.id = "close_btn";
            closeBtn.value = "close_btn";
            closeBtn.className = "btn btn-sm btn-danger mx-1";
            closeBtn.innerHTML = `<i class="fa fa-times text-white"></i>`;

            parent.append(closeBtn);
            $("#status").val($(data["status"]).text().toLowerCase().trim());
        });
    } else if ($(this).prop("value") == "edit_no_po") {
        var parent = $(this).closest("tr").find("#edit-po");

        $.each(parent, function () {
            $(this).find("#no_po").hide();
            $(this).find("#edit_no_po").hide();

            const input = document.createElement("input");
            input.id = "input";
            input.setAttribute("type", "text");
            input.className = "form-control form-control-sm";
            input.value = $(this).find("#no_po").text();

            parent.append(input);

            const submitBtn = document.createElement("button");
            submitBtn.id = "submit_btn";
            submitBtn.value = "submit_btn";
            submitBtn.className = "btn btn-sm btn-success mx-1";
            submitBtn.innerHTML = `<i class="fa fa-check text-white"></i>`;
            parent.append(submitBtn);

            const closeBtn = document.createElement("button");
            closeBtn.id = "close_btn";
            closeBtn.value = "close_btn";
            closeBtn.className = "btn btn-sm btn-danger mx-1";
            closeBtn.innerHTML = `<i class="fa fa-times text-white"></i>`;

            parent.append(closeBtn);

            $(this)
                .find("#submit_btn")
                .on("click", function () {
                    no_pre_order = $(parent).find("#input").val();
                    console.log(no_pre_order);

                    $.ajax({
                        url: "/list-barang/update-po",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: { id: data["id"], no_pre_order: no_pre_order },
                        type: "POST",
                        success: function (response) {
                            console.log(response);
                            $(parent).find("#input").remove();
                            $(parent).find("#close_btn").remove();
                            $(parent).find("#submit_btn").remove();

                            $(parent).find("#no_po").text(no_pre_order);
                            $(parent).find("#no_po").show();
                            $(parent).find("#edit_no_po").show();
                        },
                        error: function (x) {
                            console.log(x.responseText);
                        },
                    });
                });
        });
    } else if ($(this).prop("value") == "edit_supplier") {
        $("#modalTambahSupplier")
            .find("select[name='suppliers_id']")
            .val(data["suppliers_id"]);

        $("#modalTambahSupplier").find("input[name='id']").val(data["id"]);
        $("#modalTambahSupplier").modal("show");
    } else if ($(this).prop("value") == "close_btn") {
        var parent = $(this).closest("tr");

        $.each(parent, function () {
            $(this).find("#label_status").show();
            $(this).find("#edit_status").show();
            $(this).find("#status").remove();
            $(this).find("#close_btn").remove();
            $(this).find("#input").remove();
            $(this).find("#submit_btn").remove();

            $(this).find("#add_status").show();

            $(this).find("#no_po").show();
            $(this).find("#edit_no_po").show();
        });
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
                return `${data.products.kd_produk} - ${data.products.nama_produk} - ${data.products.type}`;
            },
        },
        { data: "qty" },
        {
            data: null,
            render: function (data) {
                return data.suppliers == null
                    ? "-"
                    : `${data.suppliers.kd_supplier} - ${data.suppliers.nama_supplier}`;
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
        {
            data: null,
            render: function (data, type, full, meta) {
                return `<a href="storage/post-pdf/${data.file}">${data.file}</a>`;
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
        { data: "status" },
        {
            data: "action",
            defaultContent: `
                <button type="button" value="update" class="btn btn-sm btn-warning" disabled><i class="fa fa-pen text-white"></i> Edit</button>
                <button type="button" value="delete" class="btn btn-sm btn-danger" disabled><i class="fa fa-trash"></i> Delete</button>
                `,
        },
    ],
    columnDefs: [
        {
            targets: [8],
            render: function (data, type, row, meta) {
                if (row.action != undefined) {
                    return row.action;
                } else {
                    tableBarangReturn.columns([8]).visible(false);
                }
            },
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
            .find("select[name='status']")
            .val($(data["status"]).text().toLowerCase().trim());
        $("#modalUpdateData")
            .find("input[name='created_at']")
            .val(moment(data["created_at"]).format("yyyy-MM-DD"));
        $("#modalUpdateData").find("textarea[name='note']").val(data["note"]);

        $("#modalUpdateData").find("input[name='id']").val(data["id"]);
        $("#modalUpdateData")
            .find("input[name='list_products_id']")
            .val(data["list_products_id"]);

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
    } else if ($(this).prop("value") == "add_status") {
        var value = ["", "Done Resolved", "Rejected"];
        var parent = $(this).closest("tr").find("#add");

        $.each(parent, function () {
            $(this).find("#add_status").hide();

            const select = document.createElement("select");
            select.id = "status";
            select.name = "status";
            select.className = "custom-select custom-select-sm mx-1";

            const options = value.map((status) => {
                const val = status.toLocaleLowerCase();
                return `<option value="${val}">${status}</option>`;
            });
            select.innerHTML = options;
            parent.append(select);

            const closeBtn = document.createElement("button");
            closeBtn.id = "close_btn";
            closeBtn.value = "close_btn";
            closeBtn.className = "btn btn-sm btn-danger mx-1";
            closeBtn.innerHTML = `<i class="fa fa-times text-white"></i>`;

            parent.append(closeBtn);
        });
    } else if ($(this).prop("value") == "edit_status") {
        var value = ["", "Done Resolved", "Rejected"];

        var parent = $(this).closest("tr").find("#edit");

        $.each(parent, function () {
            $(this).find("#label_status").hide();
            $(this).find("#edit_status").hide();

            const select = document.createElement("select");
            select.id = "status";
            select.name = "status";
            select.className = "custom-select custom-select-sm mx-1";

            const options = value.map((status) => {
                const val = status.toLocaleLowerCase();
                return `<option value="${val}">${status}</option>`;
            });
            select.innerHTML = options;
            parent.append(select);

            const closeBtn = document.createElement("button");
            closeBtn.id = "close_btn";
            closeBtn.value = "close_btn";
            closeBtn.className = "btn btn-sm btn-danger mx-1";
            closeBtn.innerHTML = `<i class="fa fa-times text-white"></i>`;

            parent.append(closeBtn);
        });
    } else if ($(this).prop("value") == "close_btn") {
        var parent = $(this).closest("tr");

        $.each(parent, function () {
            $(this).find("#status").remove();
            $(this).find("#close_btn").remove();
            $(this).find("#add_status").show();

            $(this).find("#label_status").show();
            $(this).find("#edit_status").show();
        });
    }
});

/* Aksi Update Status dengan Selected Option */
$("#tableBarangReturn tbody").on(
    "change",
    'select[name="status"]',
    function () {
        var data = tableBarangReturn.row($(this).parents("tr")).data();
        id = data["id"];
        value = $(this).find(":selected").val();
        console.log(value);

        $.ajax({
            url: "/return",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                id: id,
                status: value,
                invoice_number: data["invoice_number"],
                product_id: data["products_id"],
            },
            type: "POST",
            success: function (response) {
                console.log(response);
            },
            error: function (x) {
                console.log(x.responseText);
            },
        });
    }
);

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

/* DataTable User Management [START] */
var tableBarangRequest = $("#tableBarangRequest").DataTable({
    deferRender: true,
    ajax: "/request-barang",
    columns: [
        {
            data: null,
            render: function (data, type, full, meta) {
                return meta.row + 1;
            },
        },
        { data: "no_purchase_request" },
        {
            data: null,
            render: function (data) {
                return moment(data.created_at).format("DD MMMM YYYY");
            },
        },
        {
            data: null,
            render: function (data) {
                if (data.status == "approved") {
                    return `<span class="btn btn-sm btn-success disabled">Approved</span>`;
                } else if (data.status == "rejected") {
                    return `<span class="btn btn-sm btn-danger disabled">Rejected</span>`;
                } else {
                    return "-";
                }
            },
        },
        {
            data: null,
            defaultContent: `
                <button type="button" value="detail" class="btn btn-sm btn-primary"> Detail</button>
                `,
        },
    ],
});

/* Aksi Update dan Delete dengan Modal */
$("#tableBarangRequest tbody").on("click", "button", function () {
    var data = tableBarangRequest.row($(this).parents("tr")).data();

    if ($(this).prop("value") == "detail") {
        window.location.href = `/request-barang/detail/${data.no_purchase_request}`;
    }
});

/* DataTable User Management [END] */
