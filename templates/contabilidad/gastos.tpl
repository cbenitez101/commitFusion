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
				{*<form method="POST">*}
					{*<div>*}
						{*Añadir Gastos:*}
						{*<select name="gasto_hotspot">*}
							{*<option>HotSpot</option>*}
							{*{foreach item=item from=$hotspot }*}
								{*<option value="{$item.0}">{$item.1}</option>*}
							{*{/foreach}*}
						{*</select>*}
						{*<input type="text" name="gasto_cantidad" placeholder="Cantidad">*}
						{*<input type="text" name="gasto_descripcion" placeholder="Descripcion">*}
						{*<input type="text" name="gasto_precio" placeholder="Precio">*}
						{*<input class="ui-button" type="submit" value="Crear" name="create_gasto" />*}
					{*</div>*}
				{*</form>*}
				<div class="dataTable_wrapper">
					{html_table cols=$cols  table_attr='border="0" class="tabledit gastotable" id="table-search"' loop=$gastos}
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
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary">Save changes</button>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->
			</div>
		</div>
	</div>
</div>

