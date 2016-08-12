$(document).ready(function(){
    // Manejador de la tabla, se le pone que al hacer lick en una fila llame al modal y guarda los datos de la tabla
    // en data.
    table = $('#table-search').DataTable({
        "preDrawCallback" : function() {
                var api = this.api();
                if ($('#modal_dispositivo').length !== 0) { // Solo entra aqui si existe el modal_dispositivo
                    $('#table-search tbody td').click(function() {
                        if (!$(this).hasClass('sorting_1')) {
                            row = api.row($(this).parent());
                            data = api.row($(this).parent()).data();
                            //$('.modal').modal();
                            console.log(data);
                            window.location.href = "/mantenimiento/dispositivos/" + data[0];
                        }
                    });
                }
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        "responsive" : true
    });
    // Pone los datos de la variable modal en la tabla
    $('.modal').on('show.bs.modal', function(){
        //console.log(data);
        if (data != null) {
            var i = 0;
            $('.modal-body [id^="modal_gasto"]').each(function(elem) {
                $(this).val(data[i]);
                i++;
            });
        }
    });
    // Resetea los campos del formulario
    $('.modal').on('hidden.bs.modal', function(){
        data = null;
        $('.modal input:not([type="radio"])').val('');
        $('.modal select').val('');
        $('#historico input[type="radio"]:checked').removeAttr('checked')
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
            //console.log(dataok);
            guardar_dispositivo(0);
        } else if ($(this).text() == 'Eliminar') {
            if (($('#modal_gastoid').val()!== "")) {
                //Si estamos creando no hay id asignado y no se llama a la función
                guardar_gasto(1);
            }
        } else if ($(this).text() == 'Abrir') {
            window.open('/informepdf?id='+data[0]+'&modo='+$('#historico input[type="radio"]:checked').val(), '_blank','menubar=no,status=no,titlebar=no,toolbar=no,scrollbars=yes,location=no');
        }
    });
});
var table;
var data;
var row;
var dataok = [];
function guardar_dispositivo(action) {
    console.log()
    var guardar = [];
    $('input[id^="modal_dispositivo"]').each(function(){
        guardar.push($(this).val());
    });
    $('select[id^="modal_dispositivo"]').each(function(){
        guardar.push($(this).val());
    });
    console.log(guardar);
    $.ajax({
        url: '/guardar_dispositivo',
        type: 'POST',
        data: {id: guardar[0], descripcion: guardar[1], notas: guardar[2], hotspot: guardar[3], tipo: guardar[4], action: action}
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