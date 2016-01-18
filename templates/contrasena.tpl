<div class="align_center">
    <div>
        Introduzca su correo electrónico:
        <input type="text" name="email" id="mail">
    </div>
    <input type="button" name="enviar" value="Enviar" onclick="event.preventDefault();$.ajax({literal}{url: '{/literal}{$smarty.const.DOMAIN}{literal}/send_mail', type: 'POST', data:{correoelec: $('#mail').val()}}).done(function (data){alert(data.trim());}){/literal};window.location='{$smarty.const.DOMAIN}'">
</div>