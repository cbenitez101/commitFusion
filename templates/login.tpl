{* Displays the login formular *}
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="align_center">
				<img src="{$smarty.const.DOMAIN}/images/logos/{$smarty.session.cliente}{if isset($smarty.session.local)}.{$smarty.session.local}{/if}.png" {if ($smarty.const.TEMPLATE_NAME != 'login') && ($smarty.const.TEMPLATE_NAME != 'contrasena')} width="150px"{/if}>
			</div>
		</div>
	</div>
    <div class="row">
	    <div class="col-md-4 col-md-offset-4">
		    <div class="login-panel panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Introduzca sus datos</h3>
				</div>
			    <div class="panel-body">
				    <form  id="loginformular" method="post">
					    <fieldset>
						    <div class="form-group">
							    <input class="form-control" id="username" type="text" name="username"
							           placeholder="Usuario" autofocus />
						    </div>
						    <div class="form-group">
							    <input class="form-control" type="password" name="userpass" placeholder="Contraseña" />
						    </div>
						    <input class="btn btn-lg btn-success btn-block" type="submit" name="submit" value="Acceder" />
					    </fieldset>
				    </form>
			    </div>
		    </div>
	    </div>
    </div>

    {$err_msg}
</div>