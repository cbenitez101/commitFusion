function actualizar_permiso (usuario, cliente, local, accion) {
    $.ajax({
                url: "/actualiza_permiso",
                type: "POST",
                data: {
                    usuario: usuario,
                    cliente: cliente,
                    local:local,
                    accion: accion,
                    api:'943756eb7841efcc43b7cd37d7254c76'
                }
            })
            .done(function() {
                mensajealert('Se ha '+((accion === 1)?'añadido':'eliminado')+' el permiso');
            })
            .fail(function() {
                mensajealert('No se ha podido '+((accion === 1)?'añadir':'eliminar')+' el permiso');
            });
}
function mensajealert(texto) {
    //$('#messageresult').remove();
    ////$('form').append('<div id="messageresult">'+texto+'</div>');
    //$('.panel-header').append('<div class="alert alert-success alert-dismissable" id="messageresult"' +
    //    ' role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>'+texto+'</div>');
    //setInterval(function(){
    //    $('#messageresult').fadeOut();
    //}, 2000);
    $('#alert'+texto).fadeIn();
    setTimeout(function(){$('#alert'+texto).fadeOut()}, 5000);
}
$(document).ready(function() {
    $('.mensajealerta .alert').hide();
});