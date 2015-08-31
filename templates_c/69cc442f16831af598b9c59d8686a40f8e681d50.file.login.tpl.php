<?php /* Smarty version Smarty-3.1.18, created on 2015-08-31 05:56:33
         compiled from "/volume1/web/www-sb/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:126130165755e211b2a45d27-03782715%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69cc442f16831af598b9c59d8686a40f8e681d50' => 
    array (
      0 => '/volume1/web/www-sb/templates/login.tpl',
      1 => 1440996953,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126130165755e211b2a45d27-03782715',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e211b2a88d58_64526802',
  'variables' => 
  array (
    'err_msg' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e211b2a88d58_64526802')) {function content_55e211b2a88d58_64526802($_smarty_tpl) {?>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="align_center">
				<img src="<?php echo @constant('DOMAIN');?>
/images/logos/<?php echo $_SESSION['cliente'];?>
<?php if (isset($_SESSION['local'])) {?>.<?php echo $_SESSION['local'];?>
<?php }?>.png" <?php if ((@constant('TEMPLATE_NAME')!='login')&&(@constant('TEMPLATE_NAME')!='contrasena')) {?> width="150px"<?php }?>>
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

    <?php echo $_smarty_tpl->tpl_vars['err_msg']->value;?>

</div><?php }} ?>
