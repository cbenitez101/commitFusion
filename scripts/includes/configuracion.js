$(document).ready(function(){
    // Manejador de la tabla, se le pone que al hacer lick en una fila llame al modal y guarda los datos de la tabla
    // en data.
    table = $('#table-search.hotspottable').DataTable({
        //"iDisplayLength": 25, //Hay un error cuando se pasa de página que no me capta el evento onclick. Checkear eventos en la pagina del datatable
        "preDrawCallback" : function() {
            var api = this.api();
            $('#table-search tbody td').click(function() {
                if (!$(this).hasClass('sorting_1')) {
                    row = api.row($(this).parent());
                    data = api.row($(this).parent()).data();
                    $('.modal').modal();
                }
            });
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        "responsive" : true,
        "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                {   
                    "defaultContent":""
                },
                
                {   
                    "defaultContent":""
                }
            ]
    });
    
    
    table = $('#table-search.perfilestable, #table-search.lotestable').DataTable({
        //"iDisplayLength": 25, //Hay un error cuando se pasa de página que no me capta el evento onclick. Checkear eventos en la pagina del datatable
        "preDrawCallback" : function() {
            var api = this.api();
            $('#table-search tbody td').click(function() {
                if (!$(this).hasClass('sorting_1')) {
                    row = api.row($(this).parent());
                    data = api.row($(this).parent()).data();
                    $('.modal').modal();
                }
            });
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
            $('.modal-body [id^="modal_server"]').each(function(elem) {
                if (i == 3) {
                    $(this).val(data[i].toLowerCase());
                } else if (i == 5) {
                    switch (data[i]) {
                        case "No":
                            $(this).val(1);
                            break;
                        case "Tickets":
                            $(this).val(3);
                            break;
                        case "Estadisticas":
                            $(this).val(2);
                            break;
                    }
                } else if (i == 6) {
                    if (data[i] !== "") $(this).val(data[i]);
                } else if (i < 6) {
                    $(this).val(data[i]);
                }
                i++;
            });
            $('.modal-body [id^="modal_perfil"]').each(function(elem) {
                $(this).val(data[$(this).attr("class").split(" ")[1].split("-")[1]]);
            });
            $('.modal-body [id^="modal_lote"]').each(function(elem) {
                $(this).val(data[i]);
                i++;
            });
        }
    });
    // Resetea los campos del formulario
    $('.modal').on('hidden.bs.modal', function(){
        data = null;
        $('.modal input').val('');
        $('.modal select').val('');
    });
    // Acciones de los botones
    $('.modal button.action').click(function(){
        if ($(this).text() == 'Guardar') {
            // Guardo los valores en dataok para actualizar la tabla
            if ($('#modal_hotspot').length !== 0) { // Solo entra aqui si existe el modal_hotspot
                if ($('#modal_serverid').val() !== "") {
                    $('.modal-body [id^="modal_server"]').each(function(elem) {
                        dataok.push($(this).val());
                    });
                    dataok[5] = data[5];
                }
                //console.log(dataok);
                guardar_hotspot(0);
            } 
            if ($('#modal_perfil').length !== 0) {
                 if ($('#modal_perfilid').val() !== "") {
                    for (var i = 0; i < 16 ; i++) {
                        dataok.push($('.perfil-' + i).val());
                    }
                }
                guardar_perfil(0);
            }
            if ($('#modal_lote').length !== 0) { // Solo entra aqui si existe el modal_hotspot
                if ($('#modal_loteid').val() !== "") {
                    $('.modal-body [id^="modal_lote"]').each(function(elem) {
                        dataok.push($(this).val());
                    });
                }
                console.log(dataok);
                guardar_lote(0);
            } 
        } else if ($(this).text() == 'Eliminar') {
            if ($('#modal_hotspot').length !== 0) {
                if (($('#modal_serverid').val()!== "")) {
                    //Si estamos creando no hay id asignado y no se llama a la función
                    guardar_hotspot(1);
                }
            } else if ($('#modal_perfil').length !== 0) {
                if (($('#modal_perfilid').val()!== "")) {
                    //Si estamos creando no hay id asignado y no se llama a la función
                    guardar_perfil(1);
                }
            } else if ($('#modal_lote').length !== 0) {
                if (($('#modal_loteid').val()!== "")) {
                    //Si estamos creando no hay id asignado y no se llama a la función
                    guardar_lote(1);
                }
            }
        }
    });
    //Controlador para el cambio en el modal de los perfiles para actualizar el servername
    $('#modal_perfilidhotspot').change(function(){
        $('#modal_perfilserver').val($(this).find('option:selected').text());
    })
    //Controlador para la edición de lotes que muestre el tiempo
    $('#modal_loteidperfil').change(function(){
       $('#modal_loteduracion').val($(this).find('option:selected').attr('data-duracion')); 
    });
    /*-----------------------------------------------------------------------------------------------------------------
                                                Parte para el datepicker de la búsqueda
     ----------------------------------------------------------------------------------------------------------------*/
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    checkout = $('#modal_perfilexpiration').datepicker({
        onRender: function(date) {
            return (date.valueOf() > now.valueOf() ? 'disabled' : '');
        },
        format: 'yyyy-mm-dd',
        weekStart: 1
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');
    /*-----------------------------------------------------------------------------------------------------------------
                                                            Fin
     ----------------------------------------------------------------------------------------------------------------*/
    
});
var table;
var data;
var row;
var dataok = [];
var checkout;
function guardar_hotspot(action) {
    var guardar = [];
    $('input[id^="modal_server"]').each(function(){
        guardar.push($(this).val());
    });
    $('select[id^="modal_server"]').each(function(){
        guardar.push($(this).val());
    });
    if (guardar.length > 0) {
        $.ajax({
            url: '/guardar_hotspot',
            type: 'POST',
            data: {id: guardar[0], name: guardar[1], number: guardar[2], status: guardar[3].toUpperCase(), local: guardar[4], informe: guardar[5], si: guardar[6], action: action}
        }).done(function(){
            if (action === 0) {
                if (guardar[0] === '') {
                    window.location = document.URL;
                } else {
                    var aux = row.data();
                    dataok[3] = dataok[3].toUpperCase();
                    dataok[7] = aux[7];
                    dataok[8] = aux[8];
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
}
function guardar_perfil(action) {
    var guardar = {};
    $('[id^="modal_perfil"]').each(function(){
        guardar["per_"+$(this).attr("class").split(" ")[1].split("-")[1]] = $(this).val();
    });
    guardar['action'] = action;
    $.ajax({
        url: '/guardar_perfil',
        type: 'POST',
        data: guardar
    }).done(function(){
        if (action === 0) {
            if (guardar['per_0'] === '') {
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
function guardar_lote(action) {
    var guardar = [];
    $('input[id^="modal_lote"]').each(function(){
        guardar.push($(this).val());
    });
    $('select[id^="modal_lote"]').each(function(){
        guardar.push($(this).val());
    });
    if (guardar.length > 0) {
        $.ajax({
            url: '/guardar_lote',
            type: 'POST',
            data: {id: guardar[0], id_perfil: guardar[3], duracion: guardar[4], costo: guardar[1], precio: guardar[2], action: action}
        }).done(function(){
            if (action === 0) {
                if (guardar[0] === '') {
                    window.location = document.URL;
                } else {
                    var nombre = $('#modal_loteidperfil option[value="'+guardar[3]+'"]').text().split(' - ');
                    var aux = row.data();
                    dataok[5] = nombre[0];
                    dataok[6] = nombre[1];
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
}