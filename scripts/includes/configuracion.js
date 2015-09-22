$(document).ready(function(){
    $('#permisotabla tr').on('click', function(){   //para el evento de la tabla permisos
        $('#pusuarios').val($(this).find('td:first-of-type').text());   // Coger el campo id de la tabla y guardarlo en el input
        $('#fpermisos').submit();                                       //enviar el formulario
    });
    $('#permisotabla #row'+$('#pusuarios').val()).css('background', 'gray');    //Marcar el usuario seleccionado
    $('.cliente input:checkbox').on('change', function() {
        if ($(this).prop('checked')) {  //se marca
            if ($(this).attr('local')) {    //es local
                actualizar_permiso($('#pusuarios').val(),$(this).attr('cliente'),$(this).attr('local'),1);
            } else {    //es cliente
                actualizar_permiso($('#pusuarios').val(),$(this).attr('cliente'),null,1);
            }
        } else {    //se desmarca
            if ($(this).attr('local')) {    //es local
                actualizar_permiso($('#pusuarios').val(),$(this).attr('cliente'),$(this).attr('local'),2);
            } else {    //es cliente
                actualizar_permiso($('#pusuarios').val(),$(this).attr('cliente'),null,2);
            }
        }
    });
    var elemento;
    $('.tabledit input[type="button"]').on('click', function() {    //Botones editar y eliminar en las tablas de usuarios
        if ($(this).attr('value') === 'Eliminar') {
            elemento = this;
            eliminar.dialog("open");
        } else {
            elemento = new Array();
            $(this).parent().prevAll().each(function() {
                elemento.unshift($(this).text());
            });
            elemento.unshift($(this).parent().parent().parent().parent().attr('id').substr(5));
            dialog.dialog("open");
        }
    });
    $('#table-search').filterTable({ // apply filterTable to all tables on this page
        inputSelector: '#input-filter', // use the existing input instead of creating a new one
        minRows: 1
    });
    var eliminar = $('.eliminar').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Borrar": function() {borrar(); eliminar.dialog("close");},
            "Cancelar": function() {eliminar.dialog("close");}
        }
    });
    var dialog = $('.modal').dialog({
        dialogClass: "no-close",        //Para el boton cancelar superior, se le pone display none
        autoOpen: false,
        width: 350,
        modal: true,
        buttons: {
            "Guardar": function() {guardar(); dialog.dialog("close");},
            "Cancelar": function() {dialog.dialog("close");}
        },
        open: function() {      //para el array que se genera se busca los parametros
            for (var i = 0; i < elemento.length; i++) {
                switch(i) {
                    case 0:
                        if (elemento[0] === 'users'){
                            $('.modal .title').text('Editar Usuarios');
                        } else {
                            $('.modal .title').text('Editar '+elemento[i][0].toUpperCase() + elemento[i].slice(1));
                        }
                        break;
                    case 1:
                        $('#modalid').val(elemento[i]);
                        break;
                    case 2:
                        $('#modalnombre').val(elemento[i]);
                        break;
                    case 3:
                        if (elemento[0] === 'locales') {
                            $('#tdmodallocal').css('display', 'inherit');
                            var selectid=0;
                            $('#modallocal option').each(function(){
                                if ($(this).text() === elemento[i]) selectid = $(this).val();
                            });
                            if (selectid !== 0) $('#modallocal').val(selectid);
                        } else {
                            $('#tdmodalcorreo').css('display', 'inherit');
                            $('#modalemail').val(elemento[i]);
                        }
                        break;
                }
            }
            if (elemento[0] !== 'users') {
                $('#tdmodallogo').css('display', 'inherit');
                $('.logo_td').attr('src', '/images/logos/'+(($('#modallocal option:selected').val() !== '')? $('#modallocal option:selected').html().toLowerCase()+'.' :'')+$('#modalnombre').val().toLowerCase()+'.png');
            }
        },
        close: function() {
            $('.modal input').val('');
            $('#modallocal').val('');
            $('tr[id^="tdmodal"]').css('display', '');
            elemento= new Array;
        }
    });
    function guardar() {
        var todo = {accion: "editar", table: $('.modal .title').text().substring(7).toLowerCase()};
        $('input[id^=modal]').each(function() { //Cogemos todos los campos que esten rellenados
            if ($(this).val() !== "") todo[$(this).attr('id').substr(5)]=$(this).val();
        });
        if ($('#modallocal option:selected').val() !== '') todo['local']=$('#modallocal option:selected').val();
        // coger el valor del option
        if (todo['logo'] !== undefined) {
            var data = new FormData();
            $.each(files, function(key, value){
                if (key !== 'logo') {
                    data.append(key, value);
                }
            });
            data.append('nombre', todo['nombre']);
            if (todo['local'] !== undefined) data.append('local', $('#modallocal option:selected').html());
            $.ajax({
                url: 'http://servibyte.net/upload_logo',
                type: 'POST',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false
            });
        }
        $.ajax({
            url: 'http://servibyte.net/edita_usuarios',
            type: 'POST',
            data: todo
        }).done(function() {
            mensajealert('Se ha actualizado la entrada');
            window.location = document.URL;
        }).fail(function() {
            mensajealert('No se ha podido actualizar la entrada');
        });
    }
    function borrar() {
        var table = $(elemento).parent().parent().parent().parent().attr('id').substr(5);   //Para saber que menu esta abierto, vamos al titulo de la ventana y cogemos la ultima palabra
        $.ajax({
            url: 'http://servibyte.net/edita_usuarios',
            type: 'POST',
            data: {accion: 'eliminar', idusuario: $(elemento).parent().parent().attr('id').substr(3), table:table} 
        })
        .done(function(){
            mensajealert('Se ha eliminado el '+table);
            $(elemento).parent().parent().remove();
        })
        .fail(function() {
            mensajealert('No se ha podido eliminar el '+table);
        });
    }
    $('input[type=file]').on('change', function(event) {
        files = event.target.files;
    });  //Para la subida de ficheros
    $('.check_menu').on('click', function() {
        $.ajax({
            url: 'http://servibyte.net/edita_menus',
            type: 'POST',
            data: {user: $(this).attr('data-id'), menu: $(this).attr('data-menu'), action: $(this).prop('checked') ? 'add' : 'del' }
        })
        .done(function(){
            mensajealert('Se ha modificado el menu para el usuario');
        }).fail(function(){
            mensajealert('No se ha podido modificar el menu para el usuario');
        });
    });
    $('#confmenu table th').each(function(){
        $(this).text($(this).text());
    });
    $('#confmenu table th').on('click', function() {
        elemento= 'menu_'+$(this).text().trim().toLowerCase();
        if ((elemento !== 'menu_id') && (elemento != 'menu_email') && (elemento != 'menu_cliente') && (elemento != 'menu_nombre'))
        menueliminar.dialog("open");
    });
    var menueliminar = $('.menueliminar').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Borrar": function() {quitar_menu(); menueliminar.dialog("close");},
            "Cancelar": function() {menueliminar.dialog("close");}
        }
    });
    function quitar_menu() {
        $.ajax({
            url: 'http://servibyte.net/quitar_menu',
            type: 'POST',
            data: {menu: elemento}
        }).done(function(){
            window.location = document.URL;
        });
    }
    var hotspot;
    $('.hotspottable tbody tr').on('click', function() {
        hotspot = this;
        modalhotspot.dialog("open");
    });
    var modalhotspot = $('.modal_hotspot').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Guardar": function() {guardar_hotspot(0); modalhotspot.dialog("close");},
            "Borrar": function() {guardar_hotspot(1); modalhotspot.dialog("close");},
            "Cancelar": function() {modalhotspot.dialog("close");}
        },
        open: function() {
            $(hotspot).children().each(function(index, element){
                switch (index) {
                    case 0:
                        $('#modal_serverid').val($(element).text().trim());
                        break;
                    case 1:
                        $('#modal_servername').val($(element).text().trim());
                        break;
                    case 2:
                        $('#modal_servernumber').val($(element).text().trim());
                        break;
                    case 3:
                        $('#modal_serverstatus').val($(element).text().trim().toLowerCase());
                        break;
                    case 4:
                        $('#modal_serverlocal').val($(element).text().trim());
                        break;
                    case 5:
                        switch ($(element).text().trim()) {
                            case 'No':
                                $('#modal_serverinforme').val(1);
                                break;
                            case 'Estadistica':
                                $('#modal_serverinforme').val(2);
                                break;
                            case 'Tickets':
                                $('#modal_serverinforme').val(3);
                                break;
                        }
                        break;
                    case 6:
                        $('#modal_serversi').val(($(element).text().trim().length == 0)? 'Cliente': $(element).text().trim());
                        break;
                }
            });
        }
    });
    function guardar_hotspot(action) {
        var guardar = [];
        $('.modal_hotspot input').each(function(){
            guardar.push($(this).val());
        });
        $('.modal_hotspot select').each(function(){
            guardar.push($(this).val());
        });
        $.ajax({
            url: 'http://servibyte.net/guardar_hotspot',
            type: 'POST',
            data: {id: guardar[0], name: guardar[1], number: guardar[2], status: guardar[3].toUpperCase(), local: guardar[4], informe: guardar[5], si: guardar[6], action: action}
        }).done(function(){
            window.location = document.URL;
        });
    }
    var perfil;
    $('.perfiltable tbody tr').on('click', function() {
        perfil = this;
        modalperfil.dialog("open");
    });
    var modalperfil = $('.modal_perfil').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Guardar": function() {guardar_perfil(0); modalperfil.dialog("close");},
            "Borrar": function() {guardar_perfil(1); modalperfil.dialog("close");},
            "Cancelar": function() {modalperfil.dialog("close");}
        },
        open: function() {
            $(perfil).children().each(function(index, element){
                if (index === 0) $('#modal_perfilid').val($(element).text().trim());
                else $('#per_'+(index - 1)).val($(element).text().trim());
            });
        }
    });
    function guardar_perfil(action) {
        var guardar = new Object();
        $('.modal_perfil input').each(function(index, element){
            guardar[$(element).attr('id')]=$(element).val();
        });
        $('.modal_perfil select').each(function(index, element){
            guardar[$(element).attr('id')]=$(element).val();
        });
        guardar['action'] = action;
        $.ajax({
            url: 'http://servibyte.net/guardar_perfil',
            type: 'POST',
            data: guardar
        }).done(function(){
            window.location = document.URL;
        });
    }
    $('#datepicker').datepicker({minDate: -1, dateFormat: 'yy-mm-dd'});
    $('#per_9').datepicker({minDate: -1, dateFormat: 'yy-mm-dd'});
    $('#selectsn').on('change', function(){
        $('#inputsn').val($('#selectsn option:selected').text());
    });
    $('#per_0').on('change', function(){
        $('#per_4').val($('#per_0 option:selected').text());
    });
    var lote;
    $('.lotestable tbody tr').on('click', function() {
        lote = this;
        modallote.dialog("open");
    });
    var modallote = $('.modal_lote').dialog({
        autoOpen: false,
        modal: true,
        dialogClass: "no-close",
        buttons: {
            "Guardar": function() {guardar_lote(0); modallote.dialog("close");},
            "Borrar": function() {guardar_lote(1); modallote.dialog("close");},
            "Cancelar": function() {modallote.dialog("close");}
        },
        open: function() {
            $(lote).children().each(function(index, element){
                switch (index) {
                    case 1:
                        $('#modal_Id_perfil').val($(element).text().trim());
                        break;
                    case 2:
                        $('#modal_Duracion').val($(element).text().trim());
                        break;
                    case 3:
                        $('#modal_Precio').val($(element).text().trim());
                        break;
                    case 4:
                        $('#modal_Costo').val($(element).text().trim().toLowerCase());
                        break;
                    case 0:
                        $('#modal_Id').val($(element).text().trim());
                }
            });
        }
    });
    function guardar_lote(action) {
        var guardar = new Object();
        $('.modal_lote input').each(function(index, element){
            guardar[$(element).attr('id')]=$(element).val();
        });
        $('.modal_lote select').each(function(index, element){
            guardar[$(element).attr('id')]=$(element).val();
        });
        guardar['action'] = action;
        $.ajax({
            url: 'http://servibyte.net/guardar_lote',
            type: 'POST',
            data: guardar
        }).done(function(){
            window.location = document.URL;
        });
    }
    $('#idperfilchange').change(function() {
        $('#perfilduracionchange').val($(this).find(':selected').data('duracion'));
        $('#lot_duration').val($(this).find(':selected').data('duracion'));
    });
});
var files;