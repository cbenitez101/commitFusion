<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Hotspots</h1>
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
						{html_table cols=$cols  table_attr='border="0" class="tabledit hotspottable hover"
						id="table-search" width="100%"' loop=$hotspot}
					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-11">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_hotspot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Hotspot</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<input type="hidden" name="serverid" id="modal_serverid">
									<div class="form-group">
										<label>ServerName</label>
										<input  class="form-control" name="servername" id="modal_servername">
									</div>
									<div class="form-group">
										<label>ServerNumber</label>
										<input class="form-control" name="serialnumber" id="modal_servernumber">
									</div>
									<div class="form-group">
										<label>Status</label>
										<select class="form-control" name="serverstatus" id="modal_serverstatus">
											<option>Select</option>
                                            <option value="online">ONLINE</option>
                                            <option value="blocked">BLOCKED</option>
                                            <option value="maintenance">MAINTENANCE</option>
										</select>
									</div>
									<div class="form-group">
										<label>Local</label>
										<select class="form-control" name="serverlocal" id="modal_serverlocal">
											<option value="">Local</option>
											{foreach item=item from=$local}
                                                <option value="{$item.0}">{$item.1}</option>
                                            {/foreach}
										</select>
									</div>
									<div class="form-group">
										<label>Tipo de Informe</label>
										<select class="form-control" name="serverinforme" id="modal_serverinforme">
                                            <option value="">Tipo</option>
                                            <option value="1">No Informe</option>
                                            <option value="2">Estadistica</option>
                                            <option value="3">Por Tickets</option>
										</select>
									</div>
									{*<div class="form-group">
										<label>Cliente</label>
										<select class="form-control" name="serversi" id="modal_serversi">
                                            <option value="">Cliente</option>
                                            {foreach item=item from=$si}
                                                <option value="{$item['id']}">{$item['name']}</option>
                                            {/foreach}
										</select>
									</div>*}
								</form>
							</div>
							<div class="modal-footer">
								<div id="button-copy" class="btn btn-info"><i class="fa fa-stack-overflow"></i> Mkt Code</div>
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>
								<button type="button" class="btn btn-primary action" data-dismiss="modal">Guardar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
		</div>
	</div>
</div>
