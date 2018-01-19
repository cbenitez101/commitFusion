<div class="row">
	<div class="col-lg-8">
		<h1 class="page-header"> {if isset($server)}Dispositivos de {$server} {else} Servicios{/if}</h1>
	</div>
	<!--<div class="col-lg-4">
		{if isset($creaServicio)} 
			<button type="button" id="eliminaServicio" class="btn btn-danger" style="margin-top:40px;">
				Eliminar Servicio
			</button>
		{/if}
	</div>-->

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
							{html_table cols=$cols  table_attr='border="0" class="tabledit dispositivotable server hover"
						id="table-search" width="100%"' loop=$dispositivos}
						{else}
							{html_table cols=$cols  table_attr='border="0" class="tabledit dispositivotable hover"
						id="table-search" width="100%"' loop=$dispositivos}
						{/if}
					</div>
				</div>
				{if $smarty.session.cliente == 'admin'}	
					<div class="row">
						<div class="col-md-2">
							{if isset($creaServicio)} 
								<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">Crear Dispositivo</button>	
							{/if}
						</div>
					</div>
					{if !isset($creaServicio)}	
						
						<div class="modal fade" id="modal_servicio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Crear Servicio</h4>
									</div>
									<div class="modal-body">
										<form role="form">
											<input type="hidden" name="serviceid" id="modal_dispositivoid">
											<div class="form-group">
												<label>ServerName</label>
												<input  class="form-control" name="servicename" id="modal_dispositivoname">
											</div>
											<div class="form-group">
												<label>ServerNumber</label>
												<input class="form-control" name="serialnumber" id="modal_dispositivonumber">
											</div>
											<div class="form-group">
												<label>Status</label>
												<select class="form-control" name="servicestatus" id="modal_dispositivostatus">
													<option>Select</option>
		                                            <option value="online">ONLINE</option>
		                                            <option value="blocked">BLOCKED</option>
		                                            <option value="maintenance">MAINTENANCE</option>
												</select>
											</div>
											<div class="form-group">
												<label>Local</label>
												<select class="form-control" name="servicelocal" id="modal_dispositivolocal">
													<option value="">Local</option>
													{foreach item=item from=$local}
		                                                <option value="{$item.0}">{$item.1}</option>
		                                            {/foreach}
												</select>
											</div>
											<!--<div class="form-group">
												<label>Tipo de Informe</label>
												<select class="form-control" name="serviceinforme" id="modal_serviceinforme">
		                                            <option value="">Tipo</option>
		                                            <option value="1">No Informe</option>
		                                            <option value="2">Estadistica</option>
		                                            <option value="3">Por Tickets</option>
												</select>
											</div>-->
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
					{else}
				
				
						<div class="modal fade" id="modal_servdisp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Crear Dispositivos</h4>
								</div>
								<div class="modal-body">
									<form role="form">
										<input type="hidden" name="dispositivoid" id="modal_dispositivoid">
										<!--<div class="form-group">
											<label>Servicio</label>
											<select class="form-control" name="dispositivohotspot" id="modal_dispositivoservicio">
													<option value="">Seleccione un Servicio</option>
												{foreach item=item from=$servicios }
													<option value="{$item.0}">{$item.1}</option>
												{/foreach}
											</select>
										</div>
										<div class="form-group">
											<label>Hotspots</label><br/>
											<input type="checkbox" id="introduceHotspot" >Introducir a Hotspot</input>
											<select class="form-control" name="dispositivohotspot" id="modal_dispositivoservicio" disabled>
													<option value="">Seleccione un Hotspot</option>
												{foreach item=item from=$servicios }
													<option value="{$item.id}">{$item.ServerName}</option>
												{/foreach}
											</select>
										</div>-->
										<div class="form-group">
											<label>Tipo de Dispositivo</label>
											<select class="form-control" name="dispositivotipo" id="modal_dispositivotipo">
												<option value="">Seleccione un tipo de dispositivo</option>
												<option value="ap">Antena</option>
												<option value="balanceador">Balanceador</option>
												<option value="switch">Switch</option>
												<option value="tpv">TPV</option>
												<option value="camara">Cámara</option>
												<option value="servidor">Servidor</option>
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
								<!--	<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>-->
									<button type="button" class="btn btn-primary action" data-dismiss="modal">Guardar</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
					{/if}
				{/if}
			</div>
		</div>
	</div>
</div>

