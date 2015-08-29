<?php /* Smarty version Smarty-3.1.18, created on 2015-08-29 08:26:48
         compiled from "/volume1/web/www-sb/templates/configuracion/usuarios.tpl" */ ?>
<?php /*%%SmartyHeaderCode:108715765355e15eb8d25e36-65952228%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fb8e8fa10c4e02cfb01e5991376486caf40dd39' => 
    array (
      0 => '/volume1/web/www-sb/templates/configuracion/usuarios.tpl',
      1 => 1440829858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '108715765355e15eb8d25e36-65952228',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'users' => 0,
    'tr' => 0,
    'clientes' => 0,
    'trcliente' => 0,
    'cliente' => 0,
    'item' => 0,
    'local' => 0,
    'trlocal' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e15eb8eb33d6_23962380',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e15eb8eb33d6_23962380')) {function content_55e15eb8eb33d6_23962380($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/volume1/web/www-sb/includes/../libs/plugins/function.html_table.php';
?><form method="POST" id="pageusuarios">
    <div class="float_left">
        <table class="dashboard" >
            <thead>
                <tr>
                    <th class="title" colspan="2">Añadir Usuario</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Usuario:</td>
                    <td><input type="text" name="nombre" id="nombre"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" id="email"></td>
                </tr>
                <tr>
                    <td colspan="2" class="align_center">
                        <input type="submit" name="area_usuario" value="Crear" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="float_left">
        <?php echo smarty_function_html_table(array('table_attr'=>'border="0" class="tabledit" id="tableusers"','loop'=>$_smarty_tpl->tpl_vars['users']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['tr']->value,'cols'=>4),$_smarty_tpl);?>

    </div>
    </div>
    <div class="float_clear"></div>
    <?php if ($_SESSION['cliente']=='admin') {?>
    <div class="float_left">
        <table class="dashboard" >
            <thead>
                <tr>
                    <th class="title" colspan="2">Añadir Cliente</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Cliente:</td>
                    <td><input type="text" name="ccliente" id="ccliente"></td>
                </tr>
                <tr>
                    <td colspan="2" class="align_center">
                        <input type="submit" name="area_cliente" value="Crear" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div><div class="float_left">
        <?php echo smarty_function_html_table(array('table_attr'=>'border="0" class="tabledit" id="tableclientes"','loop'=>$_smarty_tpl->tpl_vars['clientes']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['trcliente']->value),$_smarty_tpl);?>

    </div>
    <div class="float_clear"></div>
    <div class="float_left">
        <table class="dashboard" >
            <thead>
                <tr>
                    <th class="title" colspan="2">Añadir Local</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Local:</td>
                    <td><input type="text" name="lcliente" id="lcliente"></td>
                </tr>
                <tr>
                    <td>Cliente:</td>
                    <td>
                        <select name="localcliente" id="localcliente">
                            <option value="">Elige un Cliente</option>
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cliente']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="align_center">
                        <input type="submit" name="area_local" value="Crear" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="float_left">
        <?php echo smarty_function_html_table(array('table_attr'=>'border="0" class="tabledit" id="tablelocales"','loop'=>$_smarty_tpl->tpl_vars['local']->value,'tr_attr'=>$_smarty_tpl->tpl_vars['trlocal']->value,'cols'=>4),$_smarty_tpl);?>

    </div>
    <div class="float_clear"></div>
    <?php }?>
</form>
<div class="modal">
    <table class="dashboard" >
        <thead>
            <tr>
                <th class="title" colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <tr id="tdmodalnombre">
                <td>Nombre:</td>
                <td>
                    <input type="text" name="modalnombre" id="modalnombre">
                    <input type="hidden" name="modalid" id="modalid">
                </td>
            </tr>
            <tr id="tdmodalcorreo">
                <td>Email:</td>
                <td><input type="text" name="modalemail" id="modalemail"></td>
            </tr>
            <tr id="tdmodallogo">
                <td>Logo:</td>
                <td><input type="file" name="modallogo" id="modallogo"></td>
                <td><img src="" class="logo_td"></td>
            </tr>
            <tr id="tdmodallocal">
                <td>Local:</td>
                <td>
                    <select name="modallocal" id="modallocal">
                        <option value="">Elige un Cliente</option>
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cliente']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="eliminar">
    <div>¿Desea realemente eliminar la entrada?</div>
</div>
<?php }} ?>
