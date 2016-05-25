$(document).ready(function(){
    $('.ticket-crear .btnPrint').printPage({
        attr: 'data-url',
        message:'Se esta imprimiendo el ticket.'
    });
    $('.ticket').on('click', function() {
        ticket = $(this).data();
        // creaticket.dialog("open");
    });
    $('#modal_creaticket').click(function(){
        creatickets();
    });
    // Manejador de la tabla, se le pone que al hacer lick en una fila llame al modal y guarda los datos de la tabla
    // en data.
    table = $('#table-search').DataTable({
        "preDrawCallback" : function() {
            if (!$('table').hasClass('tickettable') && !$('table').hasClass('fbtable')) {
                // Caso especial en el que la tabla historial no tiene modal.
                var api = this.api();
                $('#table-search tbody td').click(function() {
                    if (!$(this).hasClass('sorting_1')) {
                        row = api.row($(this).parent());
                        data = api.row($(this).parent()).data();
                        $('.modal:not(#modal_importar)').modal();
                    }
                });
            }
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        responsive: true
    });
    // Pone los datos de la variable modal en la tabla
    $('.modal:not(#modal_importar)').on('show.bs.modal', function(){

        if (data != null) {
            // En el caso de que exista el id de la entrada, se puede importar y generar excel, y no se puede
            // modificar el tiempo
            var i = 0;
            $('.modal-body [id^="modal_bloc"], .modal-body [id^="modal_bono"]').each(function(elem) {
                $(this).val(data[i]);
                i++;
            });
            $('#modal_bloctiempo').attr('disabled', true);
            $('#modal_bloccantidad').parent().hide();
        } else {
            $('#excel').hide();
            $('#importar').hide();
        }
    });
    // Resetea los campos del formulario
    $('.modal').on('hidden.bs.modal', function(){
        data = null;
        $('.modal:not(#modal_importar) input').val('');
        $('.modal select').val('');
        $('#modal_bloctiempo').removeAttr('disabled');
        $('#excel').show();
        $('#importar').show();
        $('#modal_bloccantidad').parent().show();
    });
    // Acciones de los botones
    $('.modal button.action').click(function(){
        if ($(this).text() == 'Guardar') {
            console.log('guardar');
            // Guardo los valores en dataok para actualizar la tabla
            if ($('#modal_gastoid').val() !== "") {
                $('.modal-body [id^="modal_bloc"]').each(function(elem) {
                    dataok.push($(this).val());
                });
                //dataok[5] = data[5];
            }
            //console.log(dataok);
            guardar_bloc(0);
        } else if ($(this).text() == 'Eliminar') {
            if (($('#modal_gastoid').val()!== "")) {
                //Si estamos creando no hay id asignado y no se llama a la función
                $('.modal-body [id^="modal_bloc"]').each(function(elem) {
                    dataok.push($(this).val());
                });
                guardar_bloc(1);
            }
        } else if ($(this).text() == 'Importar') {
            $('#modal_importid').val($('#modal_blocid').val());
            $('#modal_importtime').val($('#modal_bloctiempo').val());
            $.ajax({
                url: '/importbloc_hotspot',
                method: 'POST',
                data: {duracion: $('#modal_bloctiempo').val()}
            }).done(function(data){
                // Se crea el contenido de los options
                $('#modal_importhotspot').append(data);
            });
            $('#modal_button_agregar').attr("disabled", "disabled");
        } else if ($(this).text() == 'Excel') {
            window.location='/bloc_excel?bloc='+$('#modal_blocid').val();
        } else if ($(this).text() == 'Agregar') {
            importar_bloc();
        }
    });
    $('.tickettable tbody td').on('click', function(){
        if (!$(this).hasClass('sorting_1')) {
            var data = table.row($(this).parent()).data();
            window.location = "/tickets/buscar/"+data[1]+'_'+data[0];
        }
    });

    $('.fbtable tbody td').on('click', function(){
        if (!$(this).hasClass('sorting_1')) {
            var data = table.row($(this).parent()).data();
            window.location = "/tickets/buscar/"+data[0]+'_'+data[data.length-1];
        }
    });

    /*-----------------------------------------------------------------------------------------------------------------
                                                Parte para el datepicker de la búsqueda
     ----------------------------------------------------------------------------------------------------------------*/
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    checkin = $('#fecha_inicio').datepicker({
        onRender: function(date) {
            return date.valueOf() > now.valueOf() ? 'disabled' : '';
        },
        format: 'yyyy-mm-dd',
        weekStart: 1
    }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
            checkout.minDate(ev.date);
        }
        checkin.hide();
        //$('#fecha_fin')[0].focus();
        checkout.show();

    }).data('datepicker');
    checkout = $('#fecha_fin').datepicker({
        onRender: function(date) {
            return (date.valueOf() > now.valueOf() ? 'disabled' : '');
        },
        format: 'yyyy-mm-dd',
        weekStart: 1
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');
    //$('#datepicker1').datepicker({firstDay: 1, maxDate: 0, minDate: -30, dateFormat: 'yy-mm-dd',onClose: function( selectedDate ) {$( "#datepicker2" ).datepicker( "option", "minDate", selectedDate );}});
    //$('#datepicker2').datepicker({firstDay: 1, maxDate: 0, minDate: -30, dateFormat: 'yy-mm-dd',onClose: function( selectedDate ) {$( "#datepicker1" ).datepicker( "option", "maxDate", selectedDate );}});
    /*-----------------------------------------------------------------------------------------------------------------
                                                            Fin
     ----------------------------------------------------------------------------------------------------------------*/
    $('#anularticket').on('click', function(){
        //eliminaticket.dialog("open");
        $('#modal_anula').modal();
    });
    $('#anularbutton').click(function(){anularticket()});
    $('#desanularticket').on('click', function(){
        $.ajax({
                url: '/desanular_ticket',
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
        $('#modal_borra').modal();
    });
    $('#borrarbutton').click(function(){borrarticket();});

    var bloc;
    $('.bloctable tbody tr td:not(:last-child)').on('click', function() {
        bloc = $(this).parent();
        modalbloc.dialog("open");
    });
});
var table;
var data;
var ticket;
var checkin;
var checkout;
var row;
var dataok = [];
function anularticket(){
    $.ajax({
            url: '/cancela_ticket',
            method: 'POST',
            data: {usuario: window.location['pathname'].split('/').pop(), motivo: $('#modal_ticketcancel').val(), anuluser: anula_user}
        }).done(function(){
            //mensajealert('Se ha cancelado el ticket');
            //setTimeout(function(){ window.location = document.URL; }, 2000);
            window.location = document.URL;
        }).fail(function(){
            mensajealert('No se ha podido cancelar el ticket');
        });
}
function borrarticket(){
    $.ajax({
        url: '/borrar_ticket',
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
function creatickets(){
    ticket['identificador']=$('#modal_ticketid').val();
    console.log('creando');
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
function guardar_bloc(action){
    //console.log({id: dataok[0], nombre: dataok[1], descripcion: dataok[3], action: action, tiempo: dataok[2], cantidad: dataok[4]});
    //console.log({id: $('#modal_blocid').val(), nombre: $('#modal_blocnombre').val(), descripcion: $('#modal_blocdescripcion').val(), action: action, tiempo: $('#modal_bloctiempo').val(), cantidad: $('#modal_bloccantidad').val()});
    $.ajax({
        url: '/guardar_bloc',
        type: 'POST',
        data: {id: dataok[0], nombre: dataok[1], descripcion: dataok[3], action: action, tiempo: dataok[2], cantidad: dataok[4]}
    }).done(function(){
        if (action === 0) {
            if (dataok[0] === '') {
                window.location = document.URL;
            } else {
                dataok[3] = dataok[3]+'('+dataok[4]+')';
                row.data(dataok);
                dataok = [];
            }
            mensajealert('ok');
        } else {
            dataok = [];
            row.remove().draw();
            mensajealert('delete');
        }
        //window.location = document.URL;
    });
}

function importar_blocchange(){
    $.ajax({
        url: '/importbloc_perfil',
        method: 'POST',
        data: {hotspot: $('#modal_importhotspot').val(), tiempo: $('#modal_importtime').val()}
    }).done(function(data){
        $('#modal_importperfil').removeAttr('disabled');
        //$('#modal_button_agregar').removeAttr('disabled');
        $('#modal_importperfil option:not(:first-of-type)').remove();
        $('#modal_importperfil').append(data);
    });
}

function importar_blocchange1(){
    if ($('#modal_importperfil').val() !== 'Selecciona un Perfil') $('#modal_button_agregar').removeAttr('disabled');
    else $('#modal_button_agregar').attr('disabled', 'disabled');
}

function importar_bloc(){
    $.ajax({
        url: '/importar_bloc',
        type: 'POST',
        data: {id: $('#modal_importid').val(), perfil: $('#modal_importperfil').val()}
    }).done(function(){
        window.location = document.URL;
    });
}
function crear_server_ticket(name) {
    $('[id^="Server_"]').addClass('serverhidden');
    $('#Server_'+name).removeClass('serverhidden');
}