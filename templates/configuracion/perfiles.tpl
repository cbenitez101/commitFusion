<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Perfiles</h1>
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
						{html_table cols=$cols  table_attr='border="0" class="tabledit perfilestable hover"
						id="table-search" width="100%"' loop=$perfiles}
					</div>
				</div>
				<div class="row">
					<div class="col-md-1 col-md-offset-11">
						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
							Crear
						</button>
					</div>
				</div>
				<div class="modal fade" id="modal_perfil" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title">Perfil</h4>
							</div>
							<div class="modal-body">
								<form role="form">
									<input class="perfil perfil-0" type="hidden" name="serverid" id="modal_perfilid">
									<input class="form-control perfil-2" type="hidden" name="servername" id="modal_perfilserver">
    							    <div class="row">
    							        <div class="col-md-6">
    							            <div class="form-group">
        										<label>Id Hotspot</label>
        										<select class="form-control perfil-1" name="idhotspot" id="modal_perfilidhotspot">
        											<option value="">Id Hotspot</option>
                                                    {foreach item=item from=$local}
                                                        <option value="{$item.id}">{$item.ServerName}</option>
                                                    {/foreach}
        										</select>
        									</div>
        									<div class="form-group">
        										<label>Descripción</label>
        										<input class="form-control perfil-3" name="descripcion" id="modal_perfildescripcion">
        									</div>
        									<div class="form-group">
        										<label>Movilidad</label>
        										<select class="form-control perfil-5" name="movilidad" id="modal_perfilmovilidad">
        											<option value="">Movilidad</option>
                                                    <option value="Called_Station-Id">No</option>
                                                    <option value="WISPr-Location-Name">Si</option>
        										</select>
        									</div>
        									<div class="form-group">
        										<label>Acct-Interim-Interval</label>
        										<input class="form-control perfil-7" name="acct-interim-interval" id="modal_perfilinterval">
        									</div>
        									<div class="form-group">
        										<label>Simultaneous-Use</label>
        										<input class="form-control perfil-9" name="simultaneous-use" id="modal_perfilsimultaneous">
        									</div>
        									<div class="form-group">
        										<label>Expiration</label>
        										<input class="form-control perfil-11" name="expiration" id="modal_perfilexpiration">
        									</div>
        									<div class="form-group">
        										<label>WISPr-Bandwidth-Max-Up</label>
        										<input class="form-control perfil-13" name="wispr-bandwidth-max-up" id="modal_perfilmaxup">
        									</div>
    							        </div>
    							        <div class="col-md-6">
        									<div class="form-group">
        										<label>Duración</label>
        										<select class="form-control perfil-4" name="duracion" id="modal_perfilduracion">
        											<option value="">Seleccione un periodo</option>
                                                    <option value="300">5 minutos</option>
                                                    <option value="600">10 minutos</option>
                                                    <option value="900">15 minutos</option>
                                                    <option value="1800">30 minutos</option>
                                                    <option value="3600">1 hora</option>
                                                    <option value="7200">2 horas</option>
                                                    <option value="14400">4 horas</option>
                                                    <option value="21600">6 horas</option>
                                                    <option value="28800">8 horas</option>
                                                    <option value="43200">12 horas</option>
                                                    <option value="86400">1 día</option>
                                                    <option value="172800">2 días</option>
                                                    <option value="259200">3 días</option>
                                                    <option value="345600">4 días</option>
                                                    <option value="432000">5 días</option>
                                                    <option value="518400">6 días</option>
                                                    <option value="604800">7 días</option>
                                                    <option value="691200">8 días</option>
                                                    <option value="777600">9 días</option>
                                                    <option value="864000">10 días</option>
                                                    <option value="950400">11 días</option>
                                                    <option value="1036800">12 días</option>
                                                    <option value="1123200">13 días</option>
                                                    <option value="1209600">14 días</option>
                                                    <option value="1296000">15 días</option>
                                                    <option value="1382400">16 días</option>
                                                    <option value="1468800">17 días</option>
                                                    <option value="1555200">18 días</option>
                                                    <option value="1641600">19 días</option>
                                                    <option value="1728000">20 días</option>
                                                    <option value="1814400">21 días</option>
                                                    <option value="1900800">22 días</option>
                                                    <option value="1987200">23 días</option>
                                                    <option value="2073600">24 días</option>
                                                    <option value="2160000">25 días</option>
                                                    <option value="2246400">26 días</option>
                                                    <option value="2332800">27 días</option>
                                                    <option value="2419200">28 días</option>
                                                    <option value="2505600">29 días</option>
                                                    <option value="2592000">30 días</option>
                                                    <option value="2678400">31 días</option>
                                                    <option value="5184000">2 meses</option>
                                                    <option value="7776000">3 meses</option>
                                                    <option value="10368000">4 meses</option>
                                                    <option value="12960000">5 meses</option>
                                                    <option value="15552000">6 meses</option>
                                                    <option value="18144000">7 meses</option>
                                                    <option value="20736000">8 meses</option>
                                                    <option value="23328000">9 meses</option>
                                                    <option value="25920000">10 meses</option>
                                                    <option value="28512000">11 meses</option>
                                                    <option value="31104000">1 año</option>
        										</select>
        									</div>
        									<div class="form-group">
        										<label>Modo Consumo</label>
        										<select class="form-control perfil-6" name="consumo" id="modal_perfilconsumo">
                                                    <option value="">Modo Consumo</option>
                                                    <option value="One-All-Session">Continuo</option>
                                                    <option value="Max-All-Session">Real</option>
                                                    <option value="Max-All-Mb">Megas</option>
                                                    <option value="One-Daily-Session">Diario</option>
        										</select>
        									</div>
        									<div class="form-group">
        										<label>Idle-Timeout</label>
        										<input class="form-control perfil-8" name="idle-timeout" id="modal_perfiltimeout">
        									</div>
        									<div class="form-group">
        										<label>Login-Time</label>
        										<input class="form-control perfil-10" name="login-time" id="modal_perfillogin">
        									</div>
        									<div class="form-group">
        										<label>WISPr-Bandwidth-Max-Down</label>
        										<input class="form-control perfil-12" name="wispr-bandwidth-max-down" id="modal_perfilmaxdown">
        									</div>
        									<div class="form-group">
        										<label>TraficoDescarga</label>
        										<input class="form-control perfil-14" name="traficodescarga" id="modal_perfiltraficodescarga">
        									</div>
    									    <div class="tooltip-demo form-group">
    									        <label>Formato Usuario</label>
                                                <input class="form-control perfil-15" name="formato" id="modal_perfilformato" data-toggle="tooltip" data-placement="left" title="'T': Todos, 'A': Alfabeto, 'M': Mayúsculas, 'm': Minusculas, 'N': Números, 'b': minúsculas y números, 'B': Mayúsculas y números, 'V': Vocales mayúsculas, 'v': Vocales minúsculas, 'C': Consonantes mayúsculas, 'c': consonantes minúsculas. Si se deja en blanco se generará con un formato predefinido por el sistema.">
                                            
                                            	<label>Formato Contraseña</label>
        										<input class="form-control perfil-16" name="password" id="modal_perfilpassword" data-toggle="tooltip" data-placement="left" title="'T': Todos, 'A': Alfabeto, 'M': Mayúsculas, 'm': Minusculas, 'N': Números, 'b': minúsculas y números, 'B': Mayúsculas y números, 'V': Vocales mayúsculas, 'v': Vocales minúsculas, 'C': Consonantes mayúsculas, 'c': consonantes minúsculas. 'Usuario': utiliza el nombre de usuario como password. Si se deja en blanco se generará con un formato predefinido por el sistema.">
                                            
                                            </div>
    							        </div>
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
