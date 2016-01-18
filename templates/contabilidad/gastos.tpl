<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Gastos de los hotspots</h1>
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
						{html_table cols=$cols  table_attr='border="0" class="tabledit gastotable hover"
						id="table-search" width="100%"' loop=$gastos}
					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-11">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_gasto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Gastos</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<input type="hidden" name="gastoid" id="modal_gastoid">
									<div class="form-group">
										<label>Hotspot</label>
										<select class="form-control" name="gastohotspot" id="modal_gastohotspot">
											{foreach item=item from=$hotspot }
												<option value="{$item.0}">{$item.1}</option>
											{/foreach}
										</select>
									</div>
									<div class="form-group">
										<label>Cantidad</label>
										<input class="form-control" name="gastocantidad" id="modal_gastocantidad">
									</div>
									<div class="form-group">
										<label>Descripción</label>
										<input class="form-control" name="gastodescripcion" id="modal_gastodescripcion">
									</div>
									<div class="form-group">
										<label>Precio</label>
										<input class="form-control" name="gastoprecio" id="modal_gastogastoprecio">
									</div>
								</form>

							</div>
							<div class="modal-footer">
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

