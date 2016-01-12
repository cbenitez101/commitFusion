<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Usuarios</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
	    <div class="tab-content">
	        <div class="panel panel-default">
    			{*<div class="panel-heading">
    				Usuarios
    			</div>*}
    			<!-- /.panel-heading -->
    			<div class="panel-body">
    				<div class="dataTable_wrapper row">
    					<div class="col-md-12">
    						{html_table cols=$cols  table_attr='border="0" class="tabledit userstable hover"
    						id="table-search" width="100%"' loop=$usuarios}
    					</div>
    				</div>
    				<div class="row">
    					<div class="col-md-1 col-md-offset-11">
    						<button type="button" class="btn btn-success" data-toggle="modal" data-target=".modal">
    							Crear
    						</button>
    					</div>
    				</div>
    				<div class="modal fade" id="modal_usuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    					<div class="modal-dialog modal-lg">
    						<div class="modal-content">
    							<div class="modal-header">
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    								<h4 class="modal-title">Cuenta</h4>
    							</div>
    							<div class="modal-body">
    								<form data-toggle="validator" role="form">
    								    <div class="row">
    								        <div class="col-md-4">
    								            <input class="perfil" type="hidden" name="usuarioid" id="modal_usuarioid">
            									<div class="form-group">
            										<label>Nombre</label>
            										<input class="form-control" name="nombre" id="modal_usuarionombre" required>
            										<div class="help-block with-errors"></div>
            									</div>
            									<div class="form-group">
            										<label>E-Mail</label>
            										<input type="email" class="form-control" name="email" id="modal_usuarioemail" required>
            										<div class="help-block with-errors"></div>
            									</div>
            									<div class="form-group">
            										<label>
            										    Contraseña
            										</label>
            										<i id="passrefresh" class="fa fa-refresh" style="margin-left: 5px;"></i>
        										    <input id="modal_usuariopasssend" type="checkbox" name="enviapass" style="margin-left: 20px;">
        										    <i class="fa fa-envelope-o"></i>
            										<input class="form-control" name="pass" id="modal_usuariopass">
            									</div>
    								        </div><!-- /.col-md-4 -->
    								        <div class="col-md-8" id="tabholder">
    								            <ul class="nav nav-tabs" role="tablist" id="tabs">
                                        	        <li role="presentation" class="active">
                                        	            <a href="#permiso" aria-controls="permiso" role="tab" data-toggle="tab">Permisos</a>
                                                    </li>
                                        	        <li role="presentation">
                                        	            <a href="#menu" aria-controls="menu" role="tab" data-toggle="tab">Menú</a>
                                                    </li>
                                        	    </ul>
                                        	    <div class="tab-content">
	                                                <div role="tabpanel" class="tab-pane active" id="permiso">
	                                                    {html_table cols=$colu  table_attr='border="0" class="tabledit permisostable hover" id="table-permisos" width="100%"' loop=$tabla}
	                                                </div>
	                                                <div role="tabpanel" class="tab-pane" id="menu">
	                                                    {html_table cols=$colmenu  table_attr='border="0" class="tabledit menutable hover" id="table-menu" width="100%"' loop=$tablamenu}
	                                                </div>
                                                </div>
    								        </div><!-- /.col-md-8 -->
    								    </div><!-- /.row -->
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
</div>