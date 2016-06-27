
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Tickets</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
{if $smarty.session.cliente == 'admin'}
<div class="row">
	<div class="col-md-12">
		<form role="form">
			<div class="form-group">
				<label>HotSpot</label>
				<select class="form-control" id="crear_server" onchange="crear_server_ticket($(this).val());">
					<option>Seleccione Hotspot</option>
					{foreach item=item from=$servers}
						<option>{$item}</option>
					{/foreach}
				</select>
			</div>
		</form>
	</div>
</div>
	{foreach item=ticket key=server from=$tickets}
		<div class="row serverhidden" id="Server_{$server}">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
					{$server}
					</div>
					<div class="panel-body">
						{foreach item=item from=$ticket}
							<div class="ticket col-md-2 col-xs-4" {foreach item=data key=key from=$item}{if ($key != 'duraciontexto')} data-{$key}="{$data}"{/if}{/foreach}>
								<div class="row">
									<div class="col-md-12">
										<button type="button" class="btn btn-success btn-circle btn-xl" data-toggle="modal" data-target=".modal">
											<i class="fa fa-ticket"></i>
										</button>
									</div>
									<div class="col-md-12">
										{$item['duraciontexto']}<br>
										{$item['Precio']}€
									</div>
								</div>
							</div>
						{/foreach}
						<div class="modal fade" id="modal_gasto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<h4 class="modal-title">Información del Ticket</h4>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Numero de Habitación</label>
											<input class="form-control modal_ticketid" type="text" name="ticketident">
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
										<button type="button" class="btn btn-success action modal_creaticket" data-dismiss="modal" id="modal_creaticket">Crear</button>
									</div>
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					</div>
				</div>
			</div>
		</div>
	{/foreach}
{else}
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				{*<div class="panel-heading">*}
				{*Historial de Informes*}
				{*</div>*}
				<div class="panel-body">
					{foreach item=item from=$tickets}
						<div class="ticket col-md-2 col-xs-4" {foreach item=data key=key from=$item}{if ($key != 'duraciontexto')} data-{$key}="{$data}"{/if}{/foreach}>
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="btn btn-success btn-circle btn-xl" data-toggle="modal" data-target=".modal">
										<i class="fa fa-ticket"></i>
									</button>
								</div>
								<div class="col-md-12">
									{$item['duraciontexto']}<br>
									{$item['Precio']}€
								</div>
							</div>
						</div>
					{/foreach}
					<div class="modal fade" id="modal_gasto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Información del Ticket</h4>
								</div>
								<div class="modal-body">
									<form role="form">
										<div class="form-group">
											<label>Numero de Habitación</label>
											<input class="form-control" type="text" name="ticketident" id="modal_ticketid">
										</div>
									</form>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-success action" data-dismiss="modal" id="modal_creaticket">Crear</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
				</div>
			</div>
		</div>
	</div>
{/if}
<div class="ticket-crear">
    <button style="visibility: hidden;" class="btnPrint"/>
</div>





