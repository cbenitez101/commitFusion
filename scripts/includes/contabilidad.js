$(document).ready(function(){
    $('#table-search').filterTable({ // apply filterTable to all tables on this page
        inputSelector: '#input-filter', // use the existing input instead of creating a new one
        minRows: 1
    });
    var gasto;
    $('.gastotable tbody tr').on('click', function() {
        gasto = this;
        modalgasto.dialog("open");
    });
    var modalgasto = $('.modal_gasto').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Guardar": function() {guardar_gasto(0); modalgasto.dialog("close");},
            "Borrar": function() {guardar_gasto(1); modalgasto.dialog("close");},
            "Cancelar": function() {modalgasto.dialog("close");}
        },
        open: function() {
            $(gasto).children().each(function(index, element){
                switch (index) {
                    case 0:
                        $('#modal_gastoid').val($(element).text().trim());
                        break;
                    case 1:
                        $('#modal_gastohotspot').val($(element).text().trim());
                        break;
                    case 2:
                        $('#modal_gastocantidad').val($(element).text().trim());
                        break;
                    case 3:
                        $('#modal_gastodescripcion').val($(element).text().trim());
                        break;
                    case 4:
                        $('#modal_gastoprecio').val($(element).text().trim());
                        break;
                }
            });
        }
    });
    $('.hisorialtable tbody tr').on('click', function(){
        window.open('http://servibyte.net/informepdf?id='+$(this).children().first().text()+'&fecha='+$(this).children().first().next().text(), '_blank','menubar=no,status=no,titlebar=no,toolbar=no,scrollbars=yes,location=no');
    });
});
function guardar_gasto(action) {
    var guardar = [];
    $('.modal_gasto input').each(function(){
        guardar.push($(this).val());
    });
    $('.modal_gasto select').each(function(){
        guardar.push($(this).val());
    });
    console.log(guardar);
    $.ajax({
        url: 'http://servibyte.net/guardar_gasto',
        type: 'POST',
        data: {id: guardar[0], cantidad: guardar[1], Descripcion: guardar[2], precio: guardar[3], hotspot: guardar[4], action: action}
    }).done(function(){
        window.location = document.URL;
    });
}
