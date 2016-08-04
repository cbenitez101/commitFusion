<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Informe de Ventas</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="dataTable_wrapper row">
					<div class="col-md-12">
						<form role="form" class="form-horizontal">
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
								<input class="form-control" type="text" name="fechainicio" placeholder="Inicio"
                                       id="fecha_inicio">
								<input class="form-control" type="text" name="fechafin" placeholder="Fin"
								       id="fecha_fin">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-folder-open"></i></span>
								<select class="form-control" name="informe">
									<option value="">Elija un tipo de informe</option>
									<option>Normal</option>
									<option>Devueltos (Usuarios devueltos)</option>
									<option>Completo (Todos los usuarios)</option>
								</select>
							</div>
							{if isset($servers)}
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-hdd-o"></i> </span>
									<select class="form-control" name="server">
										<option value="">Elija Hotspot</option>
										{foreach item=item from=$servers}
											<option value="{$item.id}">{$item.server}</option>
										{/foreach}
									</select>
								</div>
							{/if}
							<button type="submit" class="btn btn-success">Generar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
