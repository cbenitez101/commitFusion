function actualizar_permiso (usuario, cliente, local, accion) {
    $.ajax({
                url: "http://servibyte.net/actualiza_permiso",
                type: "POST",
                data: {
                    usuario: usuario,
                    cliente: cliente,
                    local:local,
                    accion: accion
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
    $('#messageresult').remove();
    $('form').append('<div id="messageresult">'+texto+'</div>');
    setInterval(function(){
        $('#messageresult').fadeOut();
    }, 2000);
}