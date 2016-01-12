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
    
    table = $('#table-search:not(.hotspottable, .permisostable)').DataTable({
        //"iDisplayLength": 25, //Hay un error cuando se pasa de página que no me capta el evento onclick. Checkear eventos en la pagina del datatable
        "preDrawCallback" : function() {
            var api = this.api();
            $('#table-search:not(.permisostable) tbody td').click(function() {
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
    
    var table1 = $('#table-permisos').DataTable({
        //"iDisplayLength": 25, //Hay un error cuando se pasa de página que no me capta el evento onclick. Checkear eventos en la pagina del datatable
        "preDrawCallback" : function() {
            api1 = this.api();
            $('#table-permisos tbody td').click(function() {
                if (!$(this).hasClass('sorting_1')) {
                    row1 = api1.row($(this).parent());
                    data1 = api1.row($(this).parent()).data();
                    
                    $('.modal').modal();
                }
            });
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        "responsive" : true
    });
    
    var table2 = $('#table-menu').DataTable({
        //"iDisplayLength": 25, //Hay un error cuando se pasa de página que no me capta el evento onclick. Checkear eventos en la pagina del datatable
        "preDrawCallback" : function() {
            api1 = this.api();
            $('#table-permisos tbody td').click(function() {
                if (!$(this).hasClass('sorting_1')) {
                    row1 = api1.row($(this).parent());
                    data1 = api1.row($(this).parent()).data();
                    
                    $('.modal').modal();
                }
            });
        },
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.9/i18n/Spanish.json"
        },
        "responsive" : true
    });
    
    $('#tabs a').click(function (e) {
      e.preventDefault()
      $(this).tab('show')
    });
    
    
    // Pone los datos de la variable modal en la tabla
    $('.modal').on('show.bs.modal', function(){
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
            $('.modal-body [id^="modal_usuario"]').each(function(elem) {
                if (!($(this).attr('id') == 'modal_usuariopass') && !($(this).attr('id') == 'modal_usuariopasssend')) {
                    $(this).val(data[i]);
                    i++;
                }
            });
            if ($('#modal_usuario').length !== 0) {
                $('#modal_usuariopasssend').prop('checked', false);
                table1.page.len(-1).draw();
                $('.table-usuarios').each(function(elem) {
                    if ($(this).data('usuarios').indexOf(parseInt(data[0])) > -1) {
                        $(this).prop('checked', true);
                    }
                });
                table1.page.len(10).draw();
                table2.page.len(-1).draw();
                $('.table-menu').each(function(elem) {
                    if ($(this).data('usuarios').indexOf(parseInt(data[0])) > -1) {
                        $(this).prop('checked', true);
                    }
                });
                table2.page.len(10).draw();
            }
        } else {
            $('#modal_usuariopasssend').prop('checked', true);
            $('#passrefresh').click();
            $('#tabholder').addClass('disableed');
        }
    });
    // Resetea los campos del formulario
    $('.modal').on('hidden.bs.modal', function(){
        data = null;
        $('.modal input').val('');
        $('.modal select').val('');
        $('#modal_usuariopasssend').prop('checked', false);
        table1.page.len(-1).draw();
        $('.table-usuarios').prop('checked', false);
        table1.page.len(10).draw();
        table2.page.len(-1).draw();
        $('.table-menu').prop('checked', false);
        table2.page.len(10).draw();
        $('#tabholder').removeClass('disableed');
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
                guardar_lote(0);
            } 
            if ($('#modal_usuario').length !== 0) { // Solo entra aqui si existe el modal_hotspot
                if ($('#modal_usuarioid').val() !== "") {
                    $('.modal-body [id^="modal_usuario"]').each(function(elem) {
                        if ($(this).attr('id') !== "modal_usuariopasssend") {
                            dataok.push($(this).val());
                        } else {
                            if ($(this).prop('checked')) dataok.push('true');
                            else dataok.push('false');
                        }   
                    });
                }
                guardar_usuario(0);
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
            } else if ($('#modal_usuario').length !== 0) {
                if (($('#modal_usuarioid').val()!== "")) {
                    //Si estamos creando no hay id asignado y no se llama a la función
                    guardar_usuario(1);
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
    // Genera contraseñas aleatorias
    $('#passrefresh').click(function() {
        $.ajax({
            url: '/aleatorio',
            method: 'POST',
            data: {tipoalf: 'T', lon: 6}
        }).done(function(data) {
            $('#modal_usuariopass').val(data);
        });
    });
    $('.table-menu').change(function() {
        // Parte de codigo para modificar el campo data-usuarios
        var aux = $(this).data('usuarios');
        if ($(this).prop('checked')) {
            aux.push(parseInt($('#modal_usuarioid').val()));
            $(this).data('usuarios', aux);
        } else {
            aux.splice(aux.indexOf(parseInt($('#modal_usuarioid').val())), 1);
            $(this).data('usuarios', aux);
        }
        $.ajax({
            url: '/edita_menus',
            type: 'POST',
            data: {user: $('#modal_usuarioid').val(), menu: $(this).attr('id'), action: $(this).prop('checked') ? 'add' : 'del' }
        })
        .done(function(){
            if ($(this).prop('checked')) {
                mensajealert('ok');
            } else {
                mensajealert('delete');
            }
        }).fail(function(){
            mensajealert('error');
        });
            
    });
    $('.table-usuarios').change(function() {
        // Parte de codigo para modificar el campo data-usuarios
        var aux = $(this).data('usuarios');
        if ($(this).prop('checked')) {
            aux.push(parseInt($('#modal_usuarioid').val()));
            $(this).data('usuarios', aux);
        } else {
            console.log('in');
            aux.splice(aux.indexOf(parseInt($('#modal_usuarioid').val())), 1);
            $(this).data('usuarios', aux);
            console.log('out');
        }
        var user = $(this).attr('id').split('-');
        $.ajax({
            url: "/actualiza_permiso",
            type: "POST",
            data: {
                usuario: $('#modal_usuarioid').val(),
                cliente: user[0],
                local:user[1] == undefined ? null: user[1],
                accion: $(this).prop('checked') ? '1' : '2'
            }
        })
        .done(function() {
            if ($(this).prop('checked')) {
                mensajealert('ok');
            } else {
                mensajealert('delete');
            }
        })
        .fail(function() {
            mensajealert('error');
        });
            
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
var data1;
var row1;
var dataok = [];
var checkout;
var api1;
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

function guardar_usuario(action) {
    var guardar = [];
    $('input[id^="modal_usuario"]').each(function(){
        if ($(this).attr('id') !== "modal_usuariopasssend") {
            guardar.push($(this).val());
        } else {
            if ($(this).prop('checked')) guardar.push('true');
            else guardar.push('false');
        }
    });
    $('select[id^="modal_usuario"]').each(function(){
        guardar.push($(this).val());
    });
    if (guardar.length > 0) {
        $.ajax({
            url: '/guardar_usuario',
            type: 'POST',
            data: {id: guardar[0], nombre: guardar[1], correo: guardar[2], pass: guardar[4], envia: guardar[3], action: action}
        }).done(function(){
            if (action === 0) {
                if (guardar[0] === '') {
                    window.location = document.URL;
                } else {
                     var aux = row.data();
                    dataok[3] = aux[3];
                    dataok[4] = aux[4];
                    dataok[5] = aux[5];
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