<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Menus</h1>
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
						{html_table cols=$cols  table_attr='border="0" class="tabledit menutable hover"
						id="table-search" width="100%"' loop=$users}
					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-10">
						<button type="button" class="btn btn-danger action" data-toggle="modal" data-target="#modal_borrar">Eliminar</button>
					</div>
					<div class="col-md-1">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_menu">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
										<input  class="form-control" name="menuname" id="modal_menuname">
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
				<div class="modal fade" id="modal_borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
										<select class="form-control" name="menuname" id="modal_menuname">
                                            <option value="">Menu</option>
                                            {foreach item=item from=$menus}
                                                <option>{$item}</option>
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


{*<form method="POST">
    <div>
        Añadir menu: <input type="text" name="table_name"><input class="ui-button" type="submit" value="Crear" name="create_table" />
    </div>
</form>
<div class="float_left" id="confmenu">
    {html_table cols=$cols  table_attr='border="0" class="tabledit" id="table-search"' loop=$users}
</div>

<div class="menueliminar">
    <div>¿Desea realemente eliminar el menu?</div>
</div>*}