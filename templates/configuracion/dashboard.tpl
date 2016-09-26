<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard</h1>
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
						{html_table cols=$cols  table_attr='border="0" class="tabledit dashtable hover"
						id="table-search" width="100%"' loop=$users}
					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-10">
						<button type="button" class="btn btn-danger action" data-toggle="modal" data-target="#modal_borrar_dash">Eliminar</button>
					</div>
					<div class="col-md-1">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_dash">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_dash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Menu</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="form-group">
										<label>Nombre</label>
										<input  class="form-control" name="dashname" id="modal_dashname">
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-primary action" data-dismiss="modal">Guardar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
				<div class="modal fade" id="modal_borrar_dash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Menu</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<div class="form-group">
										<label>borrar</label>
										<select class="form-control" name="dashname" id="modal_dashnameborrar">
                                            <option value="">Menu</option>
                                            {foreach item=item from=$menus}
                                                <option value="{$item}">{$item}</option>
                                            {/foreach}
										</select>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
		</div>
	</div>
</div>