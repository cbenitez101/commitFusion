<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Clientes y Locales </h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-md-12">
	    <ul class="nav nav-tabs" role="tablist" id="tabs">
	        <li role="presentation" class="active">
	            <a href="#clientes" aria-controls="clientes" role="tab" data-toggle="tab">Clientes</a>
            </li>
	        <li role="presentation">
	            <a href="#locales" aria-controls="locales" role="tab" data-toggle="tab">Locales</a>
            </li>
	    </ul>
	    <div class="tab-content">
	        <div role="tabpanel" class="tab-pane active" id="clientes">
    	        <div class="panel panel-default">
        			<div class="panel-heading">
        				Clientes
        			</div>
        			<!-- /.panel-heading -->
        			<div class="panel-body">
        				<div class="dataTable_wrapper row">
        					<div class="col-md-12">
        						{html_table cols=$cols  table_attr='border="0" class="tabledit clientestable hover"
        						id="table-cliente" width="100%"' loop=$clientes}
        					</div>
        				</div>
        				<div class="row">
        					<div class="col-md-1 col-md-offset-11">
        						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_cliente">
        							Crear
        						</button>
        					</div>
        				</div>
        				<div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        					<div class="modal-dialog">
        						<div class="modal-content">
        							<div class="modal-header">
        								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        								<h4 class="modal-title">Cliente</h4>
        							</div>
        							<div class="modal-body">
        								<form role="form">
        									<input type="hidden" name="id" id="modal_clienteid">
        									<div class="form-group">
        										<label>Nombre</label>
        										<input class="form-control" name="nombre" id="modal_clientenombre">
        									</div>
        									<div class="form-group">
        									    <div class="row">
        									        <div class="col-md-8">
        									            <label>Imagen</label>
            										    <input type="file" name="logo" id="modal_clienteimagen">
        									        </div>
        									        <div class="col-md-2" id="clienteimagen"></div>
        									    </div>
        									</div>
        								</form>
        							</div>
        							<div class="modal-footer">
        								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        								{*<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>*}
        								<button type="button" class="btn btn-primary action" data-dismiss="modal">Guardar</button>
        							</div>
        						</div><!-- /.modal-content -->
        					</div><!-- /.modal-dialog -->
        				</div><!-- /.modal -->
        			</div>
        		</div>
    	    </div>
    	    <div role="tabpanel" class="tab-pane" id="locales">
    	        <div class="panel panel-default">
        			<div class="panel-heading">
        				Locales
        			</div>
        			<!-- /.panel-heading -->
        			<div class="panel-body">
        				<div class="dataTable_wrapper row">
        					<div class="col-md-12">
        						{html_table cols=$cols1  table_attr='border="0" class="tabledit localestable hover"
        						id="table-local" width="100%"' loop=$locales}
        					</div>
        				</div>
        				<div class="row">
        					<div class="col-md-1 col-md-offset-11">
        						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_local">
        							Crear
        						</button>
        					</div>
        				</div>
        				<div class="modal fade" id="modal_local" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        					<div class="modal-dialog">
        						<div class="modal-content">
        							<div class="modal-header">
        								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        								<h4 class="modal-title">Local</h4>
        							</div>
        							<div class="modal-body">
        								<form role="form">
        									<input type="hidden" name="id" id="modal_localid">
        									<div class="form-group">
        										<label>Nombre</label>
        										<input class="form-control" name="nombre" id="modal_localnombre">
        									</div>
        						            <div class="form-group">
        										<label>Cliente</label>
        										<select class="form-control" name="cliente" id="modal_localcliente">
        											<option value="">Cliente</option>
                                                    {foreach item=item from=$clientelocales}
                                                        <option value="{$item.id}">{$item.nombre}</option>
                                                    {/foreach}
        										</select>
        									</div>
        									<div class="form-group">
        										<div class="row">
        									        <div class="col-md-8">
        									            <label>Imagen</label>
            										    <input type="file" name="logo" id="modal_localimagen">
        									        </div>
        									        <div class="col-md-2" id="localimagen"></div>
        									    </div>
        									</div>
        								</form>
        							</div>
        							<div class="modal-footer">
        								<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        								{*<button type="button" class="btn btn-danger action" data-dismiss="modal">Eliminar</button>*}
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
</div>

    