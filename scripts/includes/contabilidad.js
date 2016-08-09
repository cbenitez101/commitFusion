$(document).ready(function(){
    // Manejador de la tabla, se le pone que al hacer lick en una fila llame al modal y guarda los datos de la tabla
    // en data.
    table = $('#table-search').DataTable({
        "preDrawCallback" : function() {
            if (!$('table').hasClass('historialtable')) {
                // Caso especial en el que la tabla historial no tiene modal.
                var api = this.api();
                $('#table-search tbody td').click(function() {
                    if (!$(this).hasClass('sorting_1')) {
                        row = api.row($(this).parent());
                        data = api.row($(this).parent()).data();
                        $('.modal').modal();
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
            if ($('#modal_gastoid').val() !== "") {
                $('.modal-body [id^="modal_gasto"]').each(function(elem) {
                    dataok.push($(this).val());
                });
                dataok[5] = data[5];
            }
            //console.log(dataok);
            guardar_gasto(0);
        } else if ($(this).text() == 'Eliminar') {
            if (($('#modal_gastoid').val()!== "")) {
                //Si estamos creando no hay id asignado y no se llama a la función
                guardar_gasto(1);
            }
        } else if ($(this).text() == 'Abrir') {
            window.open('/informepdf?id='+data[0]+'&modo='+$('#historico input[type="radio"]:checked').val(), '_blank','menubar=no,status=no,titlebar=no,toolbar=no,scrollbars=yes,location=no');
        }
    });
    /*$('.hisorialtable tbody td').on('click', function(){
        var data = table.row($(this).parent()).data();
        if (!$(this).hasClass('sorting_1')) {
            window.open('/informepdf?id='+data[0]+'&fecha='+data[1], '_blank','menubar=no,status=no,titlebar=no,toolbar=no,scrollbars=yes,location=no');
        }
    })*/
     /*-----------------------------------------------------------------------------------------------------------------
                                                Parte para el datepicker de la búsqueda
     ----------------------------------------------------------------------------------------------------------------*/
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    checkin = $('#fecha_inicio').datepicker({
         format: 'yyyy-mm-dd',
         weekStart: 1,
         autoclose: true,
         endDate: now,
         language: 'es',
         todayHighlight: true
    }).on('changeDate', function(e) {
        //  Calculo de la fecha máxima para sacar ticket   
        var newMaxDate = new Date(e.date);
        newMaxDate.setMonth(e.date.getMonth() + 1);
        $('#fecha_fin').datepicker("setEndDate", newMaxDate);
        //  En caso de que la fecha fin este vacia, se le emplaza la fecha actual seleccionada en inicio
        //  y se establece la fecha maxima seleccionable 
        if($('#fecha_fin').val() == ''){
            $('#fecha_fin').datepicker("setDate", e.date);
            $('#fecha_fin').datepicker("setEndDate", newMaxDate);
            $('#fecha_fin').datepicker('show');
        }
    });
    
     checkout = $('#fecha_fin').datepicker({
         format: 'yyyy-mm-dd',
         weekStart: 1,
         autoclose: true,
         endDate: now,
         language: 'es',
         todayHighlight: true
    }).on('changeDate', function(e) {
        $('#fecha_inicio').datepicker("setStartDate", newMinDate);
        var newMinDate = new Date(e.date);
        newMinDate.setMonth(e.date.getMonth() - 1);
        // Si Inicio no tiene contenido, abre datepicker estableciendo fecha limite minima selecionable
        if($('#fecha_inicio').val() == ''){
            $('#fecha_inicio').datepicker("setDate", e.date);
            $('#fecha_inicio').datepicker("setStartDate", newMinDate);
            $('#fecha_inicio').datepicker("show");
        }
        $('#fecha_fin').datepicker("hide");
    });
    
    /*-----------------------------------------------------------------------------------------------------------------
                                                            Fin
     ----------------------------------------------------------------------------------------------------------------*/
});
var table;
var data;
var row;
var checkin;
var checkout;
var dataok = [];
function guardar_gasto(action) {
    var guardar = [];
    $('[id^="modal_gasto"] input').each(function(){
        guardar.push($(this).val());
    });
    $('[id^="modal_gasto"] select').each(function(){
        guardar.push($(this).val());
    });
    //console.log(guardar);
    $.ajax({
        url: '/guardar_gasto',
        type: 'POST',
        data: {id: guardar[0], cantidad: guardar[1], Descripcion: guardar[2], precio: guardar[3], hotspot: guardar[4], action: action}
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
