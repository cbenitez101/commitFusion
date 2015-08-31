<div class="container align_center">
	<img src="{$smarty.const.DOMAIN}/images/logos/{$smarty.session.cliente}{if isset($smarty.session.local)}.{$smarty.session.local}{/if}.png" {if ($smarty.const.TEMPLATE_NAME != 'login') && ($smarty.const.TEMPLATE_NAME != 'contrasena')} width="150px"{/if}>
</div>
<br>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<script>$(document).ready(function(){
    $(".menu  .m1 span:not('.noop')").on("click", function() {literal}{window.location='{/literal}{$smarty.const.DOMAIN}{literal}/' +this.textContent.toLocaleLowerCase().trim();});{/literal}
    $(".menu  .m2 span").on("click", function() {literal}{window.location='{/literal}{$smarty.const.DOMAIN}{literal}/'+$(this).parent().parent().prev().text().toLocaleLowerCase().trim()+'/' +this.textContent.toLocaleLowerCase().trim();});
    $(".menu .m1 span").hover(function() {$(this).next('li .m2').css('display', 'inline');});
    $('.menu').menu({position: {my:'center bottom', at:'center bottom'}});
}{/literal});</script>
<ul class="menu align_center">
    <li class="m1"><span>Inicio</span></li>
    {foreach item=item from=$smarty.session.menu key=key}
    <li class="m1"><span{if count($item) > 0} class="noop" onclick="$('.menu').menu('expand');"{/if}>{$key|capitalize}</span>
            {if count($item) > 0}
                <ul>
            {/if}
            {foreach item=submenu from=$item}
                <li class="m2"><span>{$submenu|capitalize}</span></li>
            {/foreach}
            {if count($item) > 0}
                </ul>
            {/if}
        </li>
    {/foreach}
    <li class="m1"><span>Salir</span></li>
</ul>