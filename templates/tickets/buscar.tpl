{if isset($busqueda)}
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Buscar Tickets</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="dataTable_wrapper row">
						<div class="col-md-12">
							<form role="form" class="form-horizontal" method="GET" action="/tickets/resultado">
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-user"></i></span>
									<input class="form-control" type="text" name="user" placeholder="Usuario">
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
									<input class="form-control" type="text" name="fechainicio" placeholder="Inicio"
                                           id="fecha_inicio">
									<input class="form-control" type="text" name="fechafin" placeholder="Fin"
									       id="fecha_fin">
								</div>
								<div class="form-group input-group">
									<span class="input-group-addon"><i class="fa fa-flag"></i></span>
									<input class="form-control" type="text" name="identificador"
									       placeholder="Identificador">
								</div>
								{if isset($servers)}
									<div class="form-group input-group">
										<span class="input-group-addon"><i class="fa fa-hdd-o"></i> </span>
										<select class="form-control" name="server">
											<option value="">Elija Hotspot</option>
											{foreach item=item from=$servers}
												<option value="{$item}">{$item}</option>
											{/foreach}
										</select>
									</div>
								{/if}
								<button type="submit" class="btn btn-success">Buscar</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
{else}
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Información del Ticket</h1>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-6">
							<h4>Usuario</h4>
							{$out['info']['username']}
						</div>
						<div class="col-xs-6">
							<h4>Contraseña</h4>
							{foreach item=item from=$out['infoticket']}
								{if $item['attribute'] == 'Cleartext-Password'}
									{$item['value']}
								{/if}
							{/foreach}
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<h4>Local</h4>
							{$out['plataforma']['ServerName']}
						</div>
						<div class="col-xs-6">
							<h4>Lote</h4>
							{$out['plataforma']['Descripcion']}
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<h4>Costo</h4>
							{$out['plataforma']['Costo']}€
						</div>
						<div class="col-xs-6">
							<h4>Precio</h4>
							{$out['plataforma']['Precio']}€
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<h4>Fecha 1er uso</h4>
							{$out['accounting'][0]['acctstarttime']|date_format: "%d/%m/%y %T"}
						</div>
						<div class="col-xs-6">
							<h4>Fecha último uso</h4>
							{if count($out['accounting']) > 0}
								{if !empty($out['accounting'][count($out['accounting'])-1]['acctstoptime'])}
									{$out['accounting'][count($out['accounting'])-1]['acctstoptime']|date_format: "%d/%m/%y %T"}
								{else}
									En Uso
								{/if}
							{/if}
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<h4>Fecha venta</h4>
							{$out['plataforma']['FechaVenta']|date_format: "%d/%m/%y %T"}
						</div>
						<div class="col-xs-6">
							<h4>Identificador</h4>
							{$out['plataforma']['identificador']}
						</div>
					</div>
					<div class="row">
						<div class="col-xs-6">
							<h4>Estado</h4>
							<div class="alert alert-{if $estado == 'VALIDO'}success{else}danger{/if}">{$estado}</div>
							{if $estado == "CANCELADO"}'{$out['plataforma']['comentario']}' '{$out['plataforma']['anulacion_usuario']} - {$out['plataforma']['anulacion_fecha']|date_format: "%d/%m/%y %T"}'{/if}
						</div>
						<div class="col-xs-6">
							<h4>Anulación</h4>
							<script>var anula_user = "{$smarty.session.user}"</script>
							{if $estado == 'VALIDO'}
								<input type="button" value="Anular" id="anularticket" class="btn btn-warning"/>
							{elseif $smarty.session.cliente == 'admin'}
								<input type="button" value="Desanular" id="desanularticket" class="btn btn-success"/>
							{/if}
							{if $smarty.session.cliente == 'admin'}
								<input type="button" value="Borrar" id="borrarticket" class="btn btn-danger"/>
							{/if}
						</div>
					</div>
				</div>
			</div>
		</div>
		{if count($out['accounting']) > 0}
			<div class="col-lg-6">
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="dataTable_wrapper">
							<table border="0" class="tabledit" id="table-search">
								<thead>
								<tr>
									<th>
										Equipo
									</th>
									<th>
										Inicio Sesion
									</th>
									<th>
										Fin de Sesion
									</th>
									<th>
										Duracion
									</th>
									<th>
										Subida
									</th>
									<th>
										Descarga
									</th>
									<th>
										Total
									</th>
								</tr>
								</thead>
								<tbody class="accountingtable">
								{foreach item=item from=$out['accounting']}
									<tr>
										<td>
											{$item['callingstationid']|truncate:14:'**':true:true} {mac_vendor($item['callingstationid'])}
										</td>
										<td>
											{$item['acctstarttime']}
										</td>
										<td>
											{$item['acctstoptime']}
										</td>
										<td>
											{intval($item['acctsessiontime'] / 86400)} Días {gmdate('H:i:s', $item['acctsessiontime'])}
										</td>
										<td>
											{if $item['acctinputoctets'] > (1024*1024)}
												{number_format((($item['acctinputoctets']/1024)/1024),0,',','.')}Mb
											{else}
												{number_format(($item['acctinputoctets']/1024),0,',','.')}Kb
											{/if}
										</td>
										<td>
											{if $item['acctoutputoctets'] > (1024*1024)}
												{number_format((($item['acctoutputoctets']/1024)/1024),0,',','.')}Mb
											{else}
												{number_format(($item['acctoutputoctets']/1024),0,',','.')}Kb
											{/if}
										</td>
										<td>
											{if ($item['acctoutputoctets']+$item['acctinputoctets']) > (1024*1024)}
												{number_format(((($item['acctoutputoctets']+$item['acctinputoctets'])/1024)/1024),0,',','.')}Mb
											{else}
												{number_format((($item['acctoutputoctets']+$item['acctinputoctets'])/1024),0,',','.')}Kb
											{/if}
										</td>
									</tr>
								{/foreach}
								</tbody>
							</table>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-2 ">
								<h4>Total</h4>
							</div>
							<div class="col-md-4">
								<h4>Duración</h4>
								{intval($out['suma']['time']/86400)} Días {gmdate('H:i:s', $out['suma']['time'])}
							</div>
							<div class="col-md-2">
								<h4>Subida</h4>
								{if $out['suma']['in'] > (1024*1024)}
									{number_format((($out['suma']['in']/1024)/1024),0,',','.')}Mb
								{else}
									{number_format(($out['suma']['in']/1024),0,',','.')}Kb
								{/if}
							</div>
							<div class="col-md-2">
								<h4>Descarga</h4>
								{if $out['suma']['out'] > (1024*1024)}
									{number_format((($out['suma']['out']/1024)/1024),0,',','.')}Mb
								{else}
									{number_format(($out['suma']['out']/1024),0,',','.')}Kb
								{/if}
							</div>
							<div class="col-md-2">
								<h4>Total</h4>
								{if ($out['suma']['out']+$out['suma']['in']) > (1024*1024)}
									{number_format(((($out['suma']['out']+$out['suma']['in'])/1024)/1024),0,',','.')}Mb
								{else}
									{number_format((($out['suma']['out']+$out['suma']['in'])/1024),0,',','.')}Kb
								{/if}
							</div>
						</div>
					</div>
				</div>
			</div>
		{/if}
	</div>
{/if}
