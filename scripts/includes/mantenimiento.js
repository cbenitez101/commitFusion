$(document).ready(function(){
    $('[id*=msg]').hide();
    // Manejador de la tabla, se le pone que al hacer lick en una fila llame al modal y guarda los datos de la tabla
    // en data.
    
    table = $('#table-search').DataTable({
        "preDrawCallback" : function() {
                var api = this.api();
                if (/*$('#modal_dispositivo').length !== 0 || $('#modal_servicio').length !== 0 ||*/ $('#modal_dispositivo').length !== 0) { // Solo entra aqui si existe el modal_dispositivo
                    $('#table-search:not(.server) tbody td').click(function() {
                        if (!$(this).hasClass('sorting_1')) {
                            row = api.row($(this).parent());
                            data = api.row($(this).parent()).data();
                            //$('.modal').modal();
                            if (!data[0].includes("span")) {
                                //Condición para que sólo cargue cuando estamos en la lista de hotspot y no cuando hay un dispositivo
                                // CAMBIAR EL SPLIT POR "dispositivos"
                              
                                // Añado If como prueba, en caso en que no haga falta, quitar el if
                                if (window.location.href.split("/").length < 6) window.location.href = "/mantenimiento/"+window.location.href.split("/")[4]+"/" + data[0];
                            }
                        }
                    });
                }
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        "responsive" : true,
        "pageLength" : 20
    });
    // Pone los datos de la variable modal en la tabla
    $('.modal').on('show.bs.modal', function(){
        if (data != null) {
            var i = 0;
            $('.modal-body [id^="modal_gasto"]').each(function(elem) {
                $(this).val(data[i]);
                i++;
            });
        }
        //Cambiar ya que el modal no tiene ese ID
        if (window.location.href.split("/")[5] !== undefined) $('select[id*="modal_dispositivo"] option[value="'+window.location.href.split("/")[5]+'"]').attr("selected", "selected");
    });
    // Resetea los campos del formulario
    $('.modal').on('hidden.bs.modal', function(){
        data = null;
        $('.modal input:not([type="radio"])').val('');
        $('.modal select').val('');
        $('#historico input[type="radio"]:checked').removeAttr('checked');

    });
    // Acciones de los botones
    $('.modal button.action').click(function(){
        if ($(this).text() == 'Guardar') {

            // Guardo los valores en dataok para actualizar la tabla
            if ($('#modal_dispositivoid').val() !== "") {
                $('.modal-body [id^="modal_dispositivo"]').each(function(elem) {
                    dataok.push($(this).val());
                });
            }

            if ( $(this).parent().parent().parent().parent().attr("id") == 'modal_dispositivo') guardar_dispositivo(0);

        } else if ($(this).text() == 'Eliminar') {
            if (($('#modal_gastoid').val()!== "")) {
                //Si estamos creando no hay id asignado y no se llama a la función
                guardar_gasto(1);
            }
        } else if ($(this).text() == 'Abrir') {
            window.open('/informepdf?id='+data[0]+'&modo='+$('#historico input[type="radio"]:checked').val(), '_blank','menubar=no,status=no,titlebar=no,toolbar=no,scrollbars=yes,location=no');
        }
    });
    $('.checkhabilitado').change(function(){
        habilitar_dispositivo($(this).attr('id').split('-').pop(), ($(this).prop('checked'))? 1 : 0);
    });
    
    
    
    
    /**
     *
     * PARTE DE ACCIONES PARA REPARAR TABLAS 
     * 
     */
     
    // Nuevo evento para reparar la tabla radacct de base de datos cuando se quee pillada
    if ($('[id*="reparar_"]').length > 0){
        $('[id*="reparar_"]').click(function(){
            if($("#"+$(this).attr('id').split("_")[1]+"tables option:selected").val() !== '') table_actions($("#"+$(this).attr('id').split("_")[1]+"tables option:selected").val(), 'reparar');
            
        });
    }
    
    if ($('[id*="optimizar_"]').length > 0){
        $('[id*="optimizar_"]').click(function(){
            if ($("#"+$(this).attr('id').split("_")[1]+"tables option:selected").val() !== '') table_actions($("#"+$(this).attr('id').split("_")[1]+"tables option:selected").val(), 'optimizar');
        });
    }
    
    
});
var table;
var data;
var row;
var dataok = [];

function guardar_dispositivo(action) {
    var guardar = [];
    $('input[id^="modal_dispositivo"]').each(function(){
        guardar.push($(this).val());
    });
    $('select[id^="modal_dispositivo"]').each(function(){
        guardar.push($(this).val());
    });
     $.ajax({
        url: '/guardar_dispositivo',
        type: 'POST',
        data: {id: guardar[0], descripcion: guardar[1], notas: guardar[2],  tipo: (($('#modal_dispositivolocal').length > 0)?guardar[4]:guardar[3]), idlocal:  (($('#modal_dispositivolocal').length > 0)?guardar[3]:window.location.href.split("/")[5]), action: action, api: '943756eb7841efcc43b7cd37d7254c76'}
    }).done(function(){
        if (action === 0) {
            if (guardar[0] === '') {
                window.location = document.URL;
            } else {
                row.data(dataok);
                dataok = [];
            }
            mensajealert('ok');
        } else {
            row.remove().draw();
            mensajealert('delete');
        }
    });
}

function habilitar_dispositivo(id, valor) {
    $.ajax({
        url: '/habilitar_dispositivo',
        type: 'POST',
        data: {id: id, estado: valor}
    }).done(function(){
        if (valor == 0) {
            mensajealert('delete');
        } else {
            mensajealert('ok');
        }
    });
}

//Funcion para reparar tabla radius.radacct
function table_actions(table, action){
    $.ajax({
        url: '/reparar_radacct',
        type: 'POST',
        data:{tabla:table, accion:action, api:'943756eb7841efcc43b7cd37d7254c76'}
    }).done(function(data){
        if(data) $('#msgexito').fadeIn().delay(3000).fadeOut();
        else  $('#msgerror').fadeIn().delay(3000).fadeOut();
    });
}