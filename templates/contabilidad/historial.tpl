<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Historial de Informes</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			{*<div class="panel-heading">*}
				{*Historial de Informes*}
			{*</div>*}
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="dataTable_wrapper">
					{html_table cols=$cols  table_attr='border="0" class="tabledit hisorialtable hover"
					id="table-search"'	loop=$tabla}
				</div>
				<div class="modal fade" id="modal_historial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Hotspot</h4>
							</div>
							<div class="modal-body">
								<div class="form-group">
									<form id="historico">
										<label>Tipo de Informe</label>
										<div class="radio">
											<label>
												<input type="radio" name="tipohistorial" value="0">
												"Normal"
											</label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" name="tipohistorial" value="1">
												"Devueltos"
											</label>
										</div>
										<div class="radio">
											<label>
												<input type="radio" name="tipohistorial" value="2">
												"Completo"
											</label>
										</div>
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
								<button type="button" class="btn btn-primary action" data-dismiss="modal">Abrir</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
		</div>
	</div>
</div>