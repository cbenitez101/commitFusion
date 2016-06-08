<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Bonos</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper row">
					<div class="col-md-12">
						{html_table cols=$cols  table_attr='border="0" class="tabledit bonotable" id="table-search" width="100%"' loop=$bonos}
					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-11">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_bono" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
				     aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Bono</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<input type="hidden" name="bonoid" id="modal_bonoid">
									<div class="form-group">
										<label>Hotspot</label>
										<select class="form-control" name="bono_hotspot" id="modal_bonohotspot">
											<option value="">Seleccione Hotspot</option>
											{foreach item=item from=$hotspots}
											<option value="{$item.id}">{$item.ServerName}</option>
											{/foreach}>
										</select>
									</div>
									<div class="form-group">
										<label>Cantidad</label>
										<input class="form-control" name="bono_cantidad" id="modal_bonocantidad">
									</div>
									<div class="form-group">
										<label>Tipo</label>
										<select class="form-control" name="bono_tipo" id="modal_bonotipo">
											<option value="">Elige un tipo</option>
											<option value="Mensual">Mensual</option>
											<option value="Extra">Extra</option>
										</select>
									</div>
									<div class="form-group">
										<label>Fecha</label>
										<input class="form-control" name="bono_fecha" id="modal_bonofecha" disabled>
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