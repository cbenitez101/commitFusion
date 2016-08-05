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
						<form role="form" class="form-horizontal" method="GET" target="_blank" action="/informeventas">
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
								<input class="form-control" type="text" name="fechaini" placeholder="Inicio"
                                       id="fecha_inicio">
								<input class="form-control" type="text" name="fechafin" placeholder="Fin"
								       id="fecha_fin">
							</div>
							<div class="form-group input-group">
								<span class="input-group-addon"><i class="fa fa-folder-open"></i></span>
								<select class="form-control" name="modo">
									<option value="">Elija un tipo de informe</option>
									<option value="0">Normal</option>
									<option value="1">Devueltos (Usuarios devueltos)</option>
									<option value="2">Completo (Todos los usuarios)</option>
								</select>
							</div>
							{if isset($servers)}
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-hdd-o"></i> </span>
									<select class="form-control" name="hotspot">
										<option value="">Elija Hotspot</option>
										{foreach item=item from=$servers}
											<option value="{$item.server}">{$item.server}</option>
										{/foreach}
									</select>
								</div>
							{else}
							<input type="hidden" name="hotspot" value="{$smarty.session.local}">
							{/if}
							<button type="submit" class="btn btn-success">Generar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
