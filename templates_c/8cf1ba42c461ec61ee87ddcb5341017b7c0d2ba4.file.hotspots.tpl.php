<?php /* Smarty version Smarty-3.1.18, created on 2015-05-22 19:47:59
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/hotspots.tpl" */ ?>
<?php /*%%SmartyHeaderCode:124186241354beaf8d98a879-14016088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8cf1ba42c461ec61ee87ddcb5341017b7c0d2ba4' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/configuracion/hotspots.tpl',
      1 => 1432320475,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '124186241354beaf8d98a879-14016088',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54beaf8d9b8ed7_65180163',
  'variables' => 
  array (
    'local' => 0,
    'item' => 0,
    'si' => 0,
    'cols' => 0,
    'hotspot' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54beaf8d9b8ed7_65180163')) {function content_54beaf8d9b8ed7_65180163($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/function.html_table.php';
?><form method="POST">
    <div>
        Añadir Hotspot:
        <input type="text" name="hot_name" placeholder="ServerName">
        <input type="text" name="hot_number" placeholder="ServerNumber">
        <select name="hot_status">
            <option>Status</option>
            <option value="BLOCKED">BLOCKED</option>
            <option value="ONLINE">ONLINE</option>
            <option value="MAINTENANCE">MAINTENANCE</option>
        </select>
        <select name="hot_local">
            <option>Local</option>
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['local']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</option>
            <?php } ?>
        </select>
        <select name="hot_informe">
                <option>Informe</option>
                <option value="1">No Informe</option>
                <option value="2">Estadistica</option>
                <option value="3">Por Tickets</option>
        </select>
        <select name="hot_si">
            <option>Cliente</option>
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['si']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
            <?php } ?>
        </select>
        <input class="ui-button" type="submit" value="Crear" name="create_hot" />
    </div>
</form>
<div class="float_left">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit hotspottable" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['hotspot']->value),$_smarty_tpl);?>

</div>
<div class="modal_hotspot modal_ventana">
    <input type="hidden" name="serverid" id="modal_serverid">
    <table>
        <tr>
            <td>
                ServerName:
            </td>
            <td>
                <input type="text" name="servername" id="modal_servername">
            </td>
        </tr>
        <tr>
            <td>
                ServerNumber:
            </td>
            <td>
                <input type="text" name="serialnumber" id="modal_servernumber">
            </td>
        </tr>
        <tr>
            <td>
                Status:
            </td>
            <td>
                <select name="serverstatus" id="modal_serverstatus">
                    <option>Select</option>
                    <option value="online">ONLINE</option>
                    <option value="blocked">BLOCKED</option>
                    <option value="maintenance">MAINTENANCE</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Local:
            </td>
            <td>
                <select name="serverlocal" id="modal_serverlocal">
                    <option>Local</option>
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['local']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
            <td>
                Tipo Informe:
            </td>
            <td>
                <select name="serverinforme" id="modal_serverinforme">
                        <option>Tipo</option>
                        <option value="1">No Informe</option>
                        <option value="2">Estadistica</option>
                        <option value="3">Por Tickets</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Cliente:
            </td>
            <td>
                <select name="serversi" id="modal_serversi">
                    <option>Cliente</option>
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['si']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
                        <?php } ?>
                </select>
            </td>
        </tr>
    </table>
</div><?php }} ?>
