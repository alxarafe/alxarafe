/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

var iCanClose = true;

/**
 * TODO: Undocumented
 */
function allowClose() {
    iCanClose = true;
}

/**
 * TODO: Undocumented
 */
function fieldChanged() {
    iCanClose = false;
}

/**
 * TODO: Undocumented
 *
 * @returns {string}
 */
function canIClose() {
    if (!iCanClose) {
        return 'Use the buttons!';
    }
}

/**
 * TODO: Undocumented
 *
 * @param selector
 */
function showDetails(selector) {
    $("." + selector.id).each(function (index) {
        if ($(this).css('display') === 'none') {
            $(this).css('display', '');
        } else {
            $(this).css('display', 'none');
        }
    })
}

/**
 * TODO: Undocumented
 *
 * @param theLine
 * @returns {boolean}
 */
function addLine(theLine) {
    table = document.getElementById("the_table");
    i = table.rows.length;
    row = table.insertRow();
    row.id = "fila" + i;
    row.className = "success";
    row.innerHTML = theLine.replace(/`/g, "'").replace(/#/g, i);
    sp = row.getElementsByClassName('selectpicker');
    for (var i = 0; i < sp.length; i++) {
        $("#" + sp[i].id).selectpicker();
    }
    return false;
}

/**
 * TODO: Undocumented
 *
 * @returns {boolean}
 */
function addusr() {
    table = document.getElementById("the_table");
    i = table.rows.length;
    row = table.insertRow();
    row.id = "fila" + i;
    row.className = "success";
    row.innerHTML =
        '<td><input id="id' + i + '" name="id[' + i + ']" value="' + i + '" hidden />' + i + '</td>' +
        '<td>user' + i + '</td>' +
        '<td><input id="admin' + i + '" type="checkbox" name="admin[' + i + ']" value="0"> Administrador</input></td>' +
        '<td><input id="active' + i + '" type="checkbox" name="active[' + i + ']" value="1" onClick="checkactive(0);" checked> Activo</input>';
    return false;
}

/**
 * TODO: Undocumented
 *
 * @returns {boolean}
 */
function addsec() {
    table = document.getElementById("the_table");
    i = table.rows.length;
    row = table.insertRow();
    row.id = "fila" + i;
    row.className = "success";
    row.innerHTML =
        '<td><input id="id' + i + '" name="id[' + i + ']" value="' + i + '" hidden />' + i + '</td>' +
        '<td><input id="nombre' + i + '" type="text" name="nombre[' + i + ']" value=""></td>' +
        '<td><input id="active' + i + '" type="checkbox" name="active[' + i + ']" value="1" onClick="checkactive(0);" checked> Activo</input>';
    return false;
}

/**
 * Creates a new DataTable
 *
 * @param name
 * @param origData
 */
function newDataTable(name, origData) {
    //console.log(origData);
    var columnsList = JSON.parse(origData.columns);
    var columns = new Array();
    columnsList.forEach(function (element) {
        columns.push({'data': element});
    });
    var rowsPerPage = origData.rowsPerPage;
    var url = origData.url;
    var $opts = {
        destroy: true,
        pageLength: rowsPerPage,
        stateSave: true,
        colReorder: true,
        responsive: true,
        paging: true,
        pagingType: "full_numbers",
        processing: true,
        serverSide: true,
        //deferRender: true,    // Only for large data sources
        ajax: {
            method: "POST",
            url: url,
            error: function () {
                $("." + name + "-error").html("");
                $("#" + name).append('<tbody class="dt-cliente-error-grid-error"><tr><th colspan="' + columns.length + '">No se han recibido datos del servidor</th></tr></tbody>');
                $("#" + name + "_processing").css("display", "none");

            }
        },
        columns: columns,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
        language: $dataTableLanguage,
        columnDefs: [
            {
                "render": function (data, type, row) {
                    // The data on this row is the PK value
                    var pkValue = row[origData.pkField];
                    var readButton = $canRead ? "<a class='btn btn-info btn-sm' type='button' href='" + origData.linkShow + pkValue + "'>"
                        + "<span class='glyphicon glyphicon-zoom-in' aria-hidden='true'></span>"
                        + "<span class='hidden-md'>&nbsp;" + $dataTableLanguage['oButtons']['sShow'] + "</span>"
                        + "</a>" : '';
                    var updateButton = $canUpdate ? "<a class='btn btn-primary btn-sm' type='button' href='" + origData.linkEdit + pkValue + "'>"
                        + "<span class='glyphicon glyphicon-pencil' aria-hidden='true'></span>"
                        + "<span class='hidden-md'>&nbsp;" + $dataTableLanguage['oButtons']['sEdit'] + "</span>"
                        + "</a>" : '';
                    var deleteButton = $canDelete ? "<a class='btn btn-danger btn-sm' type='button' href='" + origData.linkDelete + pkValue + "'>"
                        + "<span class='glyphicon glyphicon-trash' aria-hidden='true'></span>"
                        + "<span class='hidden-md'>&nbsp;" + $dataTableLanguage['oButtons']['sDelete'] + "</span>"
                        + "</a>" : '';
                    return "<div class='btn-group' role='group'>" + readButton + updateButton + deleteButton + "</div>";
                },
                targets: -1,
            }
        ]
    };

    $optsButtons = {
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'csvHtml5', 'excelHtml5', 'pdfHtml5', 'colvis', 'colvisRestore']
    };

    if ($canExport) {
        $opts = Object.assign({}, $opts, $optsButtons)
    }

    var table = $('#' + name).DataTable($opts);
    table.buttons().container().appendTo('#' + name + '_wrapper .col-sm-6:eq(0)');
    //table.buttons().container().appendTo($('#' + name + '_wrapper .col-sm-6:eq(0)', table.table().container()));
}

/**
 * TODO: Undocumented
 *
 * @param code
 * @param page
 * @param pages
 * @param itemsxpage
 * @returns {boolean}
 */
function selectPage(code, page, pages, itemsxpage) {
    $("#" + code + "-first").attr('class', page !== 1 ? "enabled" : "disabled");
    $("#" + code + "-last").attr('class', page !== pages ? "enabled" : "disabled");
    for (i = 1; i <= pages; i++) {
        $("#" + code + "-" + i).attr('class', ((page !== i) ? "enabled" : "active"));
        $("." + code + "p" + i).each(function (index) {
            $(this).css('display', page === i ? '' : 'none');
        });
    }
    return false;
}

/**
 * When document is ready.
 */
$("document").ready(function () {
    if (typeof (tables) == 'object') {
        // If tables is an object, we are receiving and array of datatables
        for (var table in tables) {
            newDataTable(table, tables[table]);
        }
    }
});