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