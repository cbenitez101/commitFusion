<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dispositivos{if isset($server)} de {$server} {else}{/if}</h1>
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
				<div class="dataTable_wrapper row">
					<div class="col-md-12">
						
						{if isset($server)}
							{html_table cols=$cols  table_attr='border="0" class="tabledit dispositivotable server hover" id="table-search" width="100%"' loop=$dispositivos}
						{else}
							<!-- Si no hay dispositivos activos no mostramos la tabl -->
							 {if !$noactivos}
								{html_table cols=$cols  table_attr='border="0" class="tabledit dispositivotable hover" id="table-search" width="100%"' loop=$dispositivos}
							 {/if}
						{/if}
					</div>
				</div>
				{if $smarty.session.cliente == 'admin'}	
				<div class="row">
						<div class="col-md-2">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
							Crear Dispositivo
						</button>
					</div>
					 {if $noactivos}
					 	<div class="col-md-2 col-md-offset-8">
							<button type="button" id="eliminarHotspot" class="btn btn-danger" >Eliminar Hotspot</button>
						</div>
					{/if}
				</div>
				<div class="modal fade" id="modal_dispositivo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Dispositivos</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<input type="hidden" name="dispositivoid" id="modal_dispositivoid">
									<div class="form-group">
										<label>Hotspot</label>
										<select class="form-control" name="dispositivohotspot" id="modal_dispositivohotspot">
												<option value="">Seleccione un Hotspot</option>
											{foreach item=item from=$hotspot }
												<option value="{$item.0}">{$item.1}</option>
											{/foreach}
										</select>
									</div>
									<div class="form-group">
										<label>Tipo de Dispositivo</label>
										<select class="form-control" name="dispositivotipo" id="modal_dispositivotipo">
											<option value="">Seleccione un tipo de dispositivo</option>
											<option value="ap">Antena</option>
											<option value="balanceador">Balanceador</option>
											<option value="switch">Switch</option>
											<option value="otro">Otro</option>
										</select>
									</div>
									<div class="form-group">
										<label>Descripción</label>
										<input class="form-control" name="dispositivodescripcion" id="modal_dispositivodescripcion">
									</div>
									<div class="form-group">
										<label>Nota</label>
										<input class="form-control" name="dispositivonota" id="modal_dispositivonota">
									</div>
								</form>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<!--<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>-->
								<button type="button" class="btn btn-primary action" data-dismiss="modal">Guardar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				{/if}
			</div>
		</div>
	</div>
</div>

