
<div class="row">
	<div class="col-lg-12">
		{if isset($mes)}
			<h1 class="page-header">Estadísticas de {$mes}</h1>
		{else}
			<h1 class="page-header">Estadísticas</h1>
		{/if}
	</div>
	<!-- /.col-lg-12 -->
</div>

{if isset($servers)}
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper row">
						<div class="col-md-12">
							<div class="row">
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
			</div>
		</div>
	</div>
{else}
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div id="connectionschart" >
										<div id="container2"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
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
				</div>	
			</div>
		</div>
		<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper row">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<div id="connectionschart" >
										<div id="container"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
{/if}

