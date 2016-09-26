<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Bienvenidos a la plataforma de Servibyte</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			{*<div class="panel-heading">*}
				{*Gastos de los hotspots*}
			{*</div>*}
			<!-- /.panel-heading -->
			<div class="panel-body">
				Estamos contínuamente trabajando para mejorar el servicio.<br><br>
				Para cualquier incidencia por favor genere un ticket en nuestra <a href="http://soporte.servibyte.com" target="_blank">plataforma de averías</a>.<br><br>
				Para dudas o preguntas contáctenos en <a href="mailto:info@servibyte.com">info@servibyte.com</a> o en el <a href="tel:928767518">928767518</a>.
			</div>
		</div>
	</div>
</div>
{if isset($menu)}
	<div class="row">
		{foreach item=item from=$menu}
			{if $item !='tickets/buscar'}
				<div class="col-md-6">
					<div class="panel panel-default">
						<iframe class="dash_iframe {$item}" id="{$item}" src="http://www.plataforma.openwebcanarias.es/{$item}" frameborder="0" scrolling="no" width="100%"></iframe>
					</div>
				</div>
			{else}
				<div class="col-md-6">
					<div class="panel panel-default {$item}">
						{include file="$item.tpl"}
					</div>
				</div>
			{/if}	
		{/foreach}
	</div>
{/if}