
<div class="row">
	<div class="col-lg-{if isset($select_mes)}8{else}12{/if}">
		{if isset($mes)}
			<h1 class="page-header">Estadísticas de {$mes}</h1>
		{else}
			<h1 class="page-header">Estadísticas</h1>
		{/if}
	</div>
	<!-- /.col-lg-8 -->
	{if isset($select_mes)}
	<div class="col-md-4">
		<form role="form">
			<h1 class="page-header">
					<select class="form-control" id="estadistica_mes" action"">
						<option value="">Seleccione un Mes</option>
						{foreach item=item from=$select_mes}
							<option value="{$item.fecha}" {if $item.fecha == $mes_selected} selected{/if}>{$item.texto}</option>
						{/foreach}
					</select>
			</h1>
		</form>
	</div>
	{/if}
</div>
{if isset($servers)}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-12">
						<form role="form">
							<div class="form-group">
								<label>HotSpot</label>
								<select class="form-control" id="estadistica_server">
									<option value="">Seleccione Hotspot</option>
									{foreach item=item from=$servers}
										<option value="{$item.server}">{$item.server}</option>
									{/foreach}
								</select>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
{else}
	<div class="row">
		<div class="col-md-6  graficas">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="container2"></div>
				</div>
			</div>
		</div>
		<div class="col-md-6  graficas">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body">
						<div id="container3"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12  graficas">
			<div class="panel panel-default">
				<div class="panel-body">
					<div id="container"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="panel-heading align_center">
                        <h3>Datos</h3>
                    </div>
                    <div class="panel-body align_center panel_estadisticas">
                        {if isset($num_con)}
							<label>Número de conexiones: </label> <br>{$num_con}<br>
						{/if}
						{if isset($media_con)}
							<label>Número medio de conexiones por usuario: </label><br>{$media_con}<br>
						{/if}
						{if isset($media_sesion)}
							<label>Tiempo medio de sesion: </label><br>{$media_sesion}<br>
						{/if}
						{if isset($bytes_descarga)}
							<label>Datos subidos: </label><br>{$bytes_descarga}<br>
						{/if}
						{if isset($bytes_subida)}
							<label>Datos descargados: </label><br>{$bytes_subida}<br>
						{/if}
                    </div>
				</div>	
			</div>
		</div>
	</div>
{/if}

