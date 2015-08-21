$(document).ready(function(){
    $('.ticket-crear .btnPrint').printPage({
        attr: 'data-url',
        message:'Se esta imprimiendo el ticket.'
    });
    $('.ticket').on('click', function() {
        ticket = $(this).data();
        creaticket.dialog("open");
    });
    $('#table-search').filterTable({ // apply filterTable to all tables on this page
        inputSelector: '#input-filter', // use the existing input instead of creating a new one
        minRows: 1
    });
    $('#datepicker1').datepicker({firstDay: 1, maxDate: 0, minDate: -30, dateFormat: 'yy-mm-dd',onClose: function( selectedDate ) {$( "#datepicker2" ).datepicker( "option", "minDate", selectedDate );}});
    $('#datepicker2').datepicker({firstDay: 1, maxDate: 0, minDate: -30, dateFormat: 'yy-mm-dd',onClose: function( selectedDate ) {$( "#datepicker1" ).datepicker( "option", "maxDate", selectedDate );}});
    $('#table-search tr').on('click', function(){
        window.location = "/tickets/buscar/"+$(this).children().first('td').next().text()+'_'+$(this).children().first('td').text();
    });
    $('#anularticket').on('click', function(){
        eliminaticket.dialog("open");
    });
    var eliminaticket = $(".modal_ticket").dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Anular": function() {anularticket(); eliminaticket.dialog("close");},
            "Cancelar": function() {eliminaticket.dialog("close");}
        }
    });
    var creaticket = $(".modal_creaticket").dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Crear": function() {creatickets(); creaticket.dialog("close");},
            "Cancelar": function() {creaticket.dialog("close");}
        }
    });
    $('#desanularticket').on('click', function(){
        $.ajax({
                url: 'http://servibyte.net/desanular_ticket',
                method: 'POST',
                data: {usuario: window.location['pathname'].split('/').pop(), motivo: $('#modal_ticketcancel').val(), anuluser: anula_user}
            }).done(function(){
                mensajealert('Se ha cancelado el ticket');
                //setTimeout(function(){ window.location = document.URL; }, 2000);
                window.location = document.URL;
            }).fail(function(){
                mensajealert('No se ha podido cancelar el ticket');
            });
    });
    $('#borrarticket').on('click', function(){
        var check = confirm("Seguro que quiere borrar?");
        if (check == true) {
            $.ajax({
                    url: 'http://servibyte.net/borrar_ticket',
                    method: 'POST',
                    data: {usuario: window.location['pathname'].split('/').pop()}
                }).done(function(){
                    mensajealert('Se ha cancelado el ticket');
                    //setTimeout(function(){ window.location = document.URL; }, 2000);
                    
                    window.location = document.URL.slice(0,document.URL.lastIndexOf('/'));
                }).fail(function(){
                    mensajealert('No se ha podido borrar el ticket');
                });
        }
    });
    $('#table-search-fb tr').on('click', function(){
        window.location = "/tickets/buscar/"+$(this).children().first('td').text()+'_'+$(this).children().last('td').text();
    });
    
    $('#table-search-fb').filterTable({ // apply filterTable to all tables on this page
        inputSelector: '#input-filter', // use the existing input instead of creating a new one
        minRows: 1
    });
    
    $('#table-search-bloc').filterTable({ // apply filterTable to all tables on this page
        inputSelector: '#input-filter', // use the existing input instead of creating a new one
        minRows: 1
    });
    var bloc;
    $('.bloctable tbody tr td:not(:last-child)').on('click', function() {
        bloc = $(this).parent();
        modalbloc.dialog("open");
    });
    var modalbloc = $('.modal_bloc').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Guardar": function() {guardar_bloc(); modalbloc.dialog("close");},
            "Cancelar": function() {modalbloc.dialog("close");}
        },
        open: function() {
            $(bloc).children().each(function(index, element){
                switch (index) {
                    case 0:
                        $('#modal_blocid').val($(element).text().trim());
                        break;
                    case 1:
                        $('#modal_blocnombre').val($(element).text().trim());
                        break;
                    case 2:
                        $('#modal_bloctiempo').text($(element).text().trim());
                        break;
                    case 3:
                        $('#modal_blocdescripcion').val($(element).text().trim());
                        break;
                }
            });
        }
    });
    $("#excel_button").click(function(){
        console.log('clicked');
        window.location='http://servibyte.net/bloc_excel?bloc='+$('#modal_blocid').val();
    });
    var importar;
    $(".import_bloc").click(function(){
        importar = this;
        modalimport.dialog("open");
    });
    var modalimport = $('.modal_import').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Importar": function() {
                importar_bloc();
                modalimport.dialog("close");
            },
            "Cancelar": function() {modalimport.dialog("close");}
        },
        open: function() {
            $('#modal_importid').val($(importar).data('id'));
            $.ajax({
                url: 'http://servibyte.net/importbloc_hotspot',
                method: 'POST',
                data: {duracion: $(importar).data('tiempo')}
            }).done(function(data){
                // Se crea el contenido de los options
                $('#modal_importhotspot').append(data);
            });
            $(".ui-dialog-buttonpane button:contains('Importar')").button("disable");
        },
        beforeClose: function() {
            $('#modal_importperfil option:not(:first-of-type)').remove();
            $('#modal_importhotspot option:not(:first-of-type)').remove();
        }
    });
    $('#modal_importhotspot').change(function(){
        $.ajax({
            url: 'http://servibyte.net/importbloc_perfil',
            method: 'POST',
            data: {hotspot: $(this).val(), tiempo: $(importar).data('tiempo')}
        }).done(function(data){
            $('#modal_importperfil').removeAttr('disabled');
            $('#modal_importperfil option:not(:first-of-type)').remove();
            $('#modal_importperfil').append(data);
        });
    });
    $('#modal_importperfil').change(function(){
        if ($('#modal_importperfil').val() !== 'Selecciona un Perfil') $(".ui-dialog-buttonpane button:contains('Importar')").button("enable");
        else $(".ui-dialog-buttonpane button:contains('Importar')").button("disable");
    });
});
var ticket;
function anularticket(){
    $.ajax({
            url: 'http://servibyte.net/cancela_ticket',
            method: 'POST',
            data: {usuario: window.location['pathname'].split('/').pop(), motivo: $('#modal_ticketcancel').val(), anuluser: anula_user}
        }).done(function(){
            mensajealert('Se ha cancelado el ticket');
            //setTimeout(function(){ window.location = document.URL; }, 2000);
            window.location = document.URL;
        }).fail(function(){
            mensajealert('No se ha podido cancelar el ticket');
        });
}
function creatickets(){
    ticket['identificador']=$('#modal_ticketid').val();
    $.ajax({
        url: "/crea_ticket",
        method: "POST",
        data: ticket
    }).done(function(data){
        $('.btnPrint').attr('data-url', '/scripts/imprimeticket.php?'+data.trim());
        $('.btnPrint').click();
        $('#modal_ticketid').val("");
    });
}
function guardar_bloc(){
    $.ajax({
        url: 'http://servibyte.net/guardar_bloc',
        type: 'POST',
        data: {id: $('#modal_blocid').val(), nombre: $('#modal_blocnombre').val(), descripcion: $('#modal_blocdescripcion').val()}
    }).done(function(){
        window.location = document.URL;
    });
}
function importar_bloc(){
    $.ajax({
        url: 'http://servibyte.net/importar_bloc',
        type: 'POST',
        data: {id: $('#modal_importid').val(), perfil: $('#modal_importperfil').val()}
    }).done(function(){
        window.location = document.URL;
    });
}