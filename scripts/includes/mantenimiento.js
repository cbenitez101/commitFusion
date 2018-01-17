$(document).ready(function(){
    // Manejador de la tabla, se le pone que al hacer lick en una fila llame al modal y guarda los datos de la tabla
    // en data.
    //   console.log(window.location.href.split("/"));
    table = $('#table-search').DataTable({
        "preDrawCallback" : function() {
                var api = this.api();
                if ($('#modal_dispositivo').length !== 0 || $('#modal_servicio').length !== 0 || $('#modal_servdisp').length !== 0) { // Solo entra aqui si existe el modal_dispositivo
                    $('#table-search:not(.server) tbody td').click(function() {
                        if (!$(this).hasClass('sorting_1')) {
                            row = api.row($(this).parent());
                            data = api.row($(this).parent()).data();
                            //$('.modal').modal();
                            if (!data[0].includes("span")) {
                                // console.log(window.location.href.split("/")[4]);
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
        //Cambiar
        $("#modal_dispositivoservicio option:selected").removeAttr("selected");
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

            if ($(this).parent().parent().parent().parent().attr("id") == 'modal_servicio' || $(this).parent().parent().parent().parent().attr("id") == 'modal_servdisp') guardar_dispositivo(0);/*guardar_servicio(0);*/
            else if ($(this).parent().parent().parent().parent().attr("id") == 'modal_dispositivo') guardar_dispositivo(0);

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
     * ESTA ULTIMA PARTE SE ELIMINA EN CASO DE NO UTILIZARLA
     * /
    
    
    /**
     * Botón de eliminar servicio. Llama a la función eliminar_servicio, al igual que en el caso siguiente de eliminar un 
     * hotspot si no tiene antenas (en mi caso antenas activas)
    //  */
    // $('#eliminaServicio').on('click', function(){
    //     // if (window.location.href.split("/")[5] !== "") eliminar_servicio(window.location.href.split("/")[5], 'servicios');
    //     if (window.location.href.split("/")[5] !== "") guardar_servicio(1, 'serv');
    // });
    
    /**
     * Boton de eliminar hotspot. Se puede eliminar desde Configuracion > Hotspots y desde Mantenimiento > Dispositivos en el caso
     * que no hayan dispositivos atcivos disponibles para dicho hotspot. Al no estar en un modal, hay que eliminarlo con
     * otra función, no se puede con guardar_hotspot con el action a 1. Pendiente de intentar juntar funciones si es que lo ya
     * implementado esté bien.
    //  */
    // $('#eliminarHotspot').on('click', function(){
    //     // if (window.location.href.split("/")[5] !== "") eliminar_servicio(window.location.href.split("/")[5], 'dispositivos');
    //   if (window.location.href.split("/")[5] !== "") guardar_hotspot(1, 'dispositivos');
    // });
    

    
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
    console.log(guardar);
    $.ajax({
        url: '/guardar_dispositivo',
        type: 'POST',
        data: {id: guardar[0], descripcion: guardar[1], notas: guardar[2]/*, hotspot: guardar[3]*/, tipo: guardar[3], idlocal:window.location.href.split("/")[5], action: action, api: '943756eb7841efcc43b7cd37d7254c76'}
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



/**
 * LA SIGUIENTE FUNCION TAMBIEN HAY QUE ELIMINARLA SI NO SE UTILIZA
 */

// function guardar_servicio(action, del=null) {
//     var guardar = [];
//     // if ($('.modal').attr('id') === 'modal_servicedisp'){
//     //     $('input[id^="modal_service"]').each(function(){
//     //         if ($(this).attr('name') !== 'modal_servicefull') guardar.push( $(this).val());
//     //     });
        
//     //     $('select[id^="modal_service"]').each(function(){
//     //         guardar.push($(this).val());
//     //     });
        

//     // }else {
        
//     $('input[id*="modal_dispositivo"]').each(function(){
//          guardar.push( $(this).val());
//     });
    
//     $('select[id*="modal_dispositivo"]').each(function(){
//         guardar.push($(this).val());
//     });
//     // } 
//     // console.log($('.modal').attr('id'));
//     console.log(guardar);
//     // console.log(action);
    
//     if (guardar.length > 0) {
//         $.ajax({
//             url: (($('.modal').attr('id') == 'modal_servdisp')?((del !== null)?'/guardar_servicio':'/guardar_dispositivoserv'):'/guardar_servicio'),
//             type: 'POST',
//             data: (($('.modal').attr('id') != 'modal_servdisp')?{id: ((action == 1)?window.location.href.split("/")[5]:guardar[0]), name: guardar[1], number: guardar[2], status: guardar[3].toUpperCase(), local: guardar[4], action: action, api: '943756eb7841efcc43b7cd37d7254c76'}:{id: ((action == 1)?window.location.href.split("/")[5]:guardar[0]), descripcion: guardar[1], notas: guardar[2], hotspot: guardar[3], tipo: guardar[4], action: action, api: '943756eb7841efcc43b7cd37d7254c76'})
//         }).done(function(){
//             if (action === 0) {
//                 if (guardar[0] === '') {
//                     window.location = document.URL;
//                 } else {
//                     var aux = row.data();
//                     dataok[3] = dataok[3].toUpperCase();
//                     row.data(dataok);
//                     dataok = [];
//                 }
//                 mensajealert('ok');
//             } else {
//                 // row.remove().draw();
//                 mensajealert('delete');
//                 window.history.back();
//                 // window.location = document.referrer;
                
//             }
//         });
//     } 
// }




// function guardar_servicio(action) {
//     var guardar = [];
//     // if ($('.modal').attr('id') === 'modal_servicedisp'){
//     //     $('input[id^="modal_service"]').each(function(){
//     //         if ($(this).attr('name') !== 'modal_servicefull') guardar.push( $(this).val());
//     //     });
        
//     //     $('select[id^="modal_service"]').each(function(){
//     //         guardar.push($(this).val());
//     //     });
        

//     // }else {
        
//         $('input[id*="modal_dispositivo"]').each(function(){
//              guardar.push( $(this).val());
//         });
        
//         $('select[id*="modal_dispositivo"]').each(function(){
//             guardar.push($(this).val());
//         });
//     // } 
//     console.log(guardar);
//     if (guardar.length > 0) {
//         $.ajax({
//             url: (($('.modal').attr('id') == 'modal_servicio')?'/guardar_servicio':'/guardar_dispositivoserv'),
//             type: 'POST',
//             data: (($('.modal').attr('id') == 'modal_servicio')?{id: guardar[0], name: guardar[1], number: guardar[2], status: guardar[3].toUpperCase(), local: guardar[4], action: action, api: '943756eb7841efcc43b7cd37d7254c76'}:{id: guardar[0], descripcion: guardar[1], notas: guardar[2], hotspot: guardar[3], tipo: guardar[4], action: action, api: '943756eb7841efcc43b7cd37d7254c76'})
//         }).done(function(){
//             if (action === 0) {
//                 if (guardar[0] === '') {
//                     window.location = document.URL;
//                 } else {
//                     var aux = row.data();
//                     dataok[3] = dataok[3].toUpperCase();
//                     row.data(dataok);
//                     dataok = [];
//                 }
//                 mensajealert('ok');
//             } else {
//                 row.remove().draw();
//                 mensajealert('delete');
//             }
//         });
//     } 
// }

/** 
 * Funcion que elimina un servicio o un hotspot pasandole el id de los mismos
*/
// function eliminar_servicio(idserv, serv){
//     $.ajax({
//         url: '/eliminar_servicio',
//         type: 'POST',
//         data: {id: idserv, servi: serv}
//     }).done(function(){
//       window.location =  window.location.href = "/mantenimiento/"+serv+"/";
//     });
   
// }



/**
 * ¿SIGUIENTE FUNCION NECESARIA?
 */

// function guardar_hotspot(action, br=null) {
// //     console.log('entra');
// //     var guardar = [];
// //     $('input[id^="modal_server"]').each(function(){
// //         if ($(this).attr('id') === 'modal_serverhsfull1' && $(this).prop('checked')) {
// //             guardar.push( 1 );
// //         }else if($(this).attr('id') === 'modal_serverhsfull2' && $(this).prop('checked')){
// //             guardar.push( 0 );
        
// //         } else if( $(this).attr('id') === 'modal_serverhsfecha' || $(this).attr('id') === 'modal_serverhsprecio' || $(this).attr('id') === 'modal_serverhsduracion' || $(this).attr('id') === 'modal_serverhsidentificador' || $(this).attr('id') == 'modal_serverhslogo'  ){
// //             guardar.push( (($(this).prop('checked'))?1:0) );
// //         } else if ($(this).attr('name') !== 'modal_serverfull') guardar.push( $(this).val());
// //     });
    
// //     $('select[id^="modal_server"]').each(function(){
// //         guardar.push($(this).val());
// //     });
// // console.log(guardar)
//     // if (guardar.length > 0) {
//         $.ajax({
//             url: '/guardar_hotspot',
//             type: 'POST',
//             data: {id: window.location.href.split("/")[5], action: action}
//         }).done(function(){
//             if (action === 0) {
//                 if (guardar[0] === '') {
//                     window.location = document.URL;
//                 } else {
//                     var aux = row.data();
//                     dataok[3] = dataok[3].toUpperCase();
//                     row.data(dataok);
//                     dataok = [];
//                 }
//                 mensajealert('ok');
//             } else {
//                 // row.remove().draw();
//                 mensajealert('delete');
//                  window.history.back();
//             }
//         });
//     // } 
// }