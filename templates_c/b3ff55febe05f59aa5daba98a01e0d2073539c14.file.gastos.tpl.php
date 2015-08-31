<?php /* Smarty version Smarty-3.1.18, created on 2015-08-31 07:14:47
         compiled from "/volume1/web/www-sb/templates/contabilidad/gastos.tpl" */ ?>
<?php /*%%SmartyHeaderCode:197977658655e3f0d74fdce9-77243566%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3ff55febe05f59aa5daba98a01e0d2073539c14' => 
    array (
      0 => '/volume1/web/www-sb/templates/contabilidad/gastos.tpl',
      1 => 1440829858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197977658655e3f0d74fdce9-77243566',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hotspot' => 0,
    'item' => 0,
    'cols' => 0,
    'gastos' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e3f0d76022b6_52546150',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e3f0d76022b6_52546150')) {function content_55e3f0d76022b6_52546150($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/volume1/web/www-sb/includes/../libs/plugins/function.html_table.php';
?><form method="POST">
    <div>
        Añadir Gastos:
        <select name="gasto_hotspot">
            <option>HotSpot</option>
            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hotspot']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value[0];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</option>
            <?php } ?>
        </select>
        <input type="text" name="gasto_cantidad" placeholder="Cantidad">
        <input type="text" name="gasto_descripcion" placeholder="Descripcion">
        <input type="text" name="gasto_precio" placeholder="Precio">
        <input class="ui-button" type="submit" value="Crear" name="create_gasto" />
    </div>
</form>
<div class="float_left">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit gastotable" id="table-search"','loop'=>$_smarty_tpl->tpl_vars['gastos']->value),$_smarty_tpl);?>

</div>
<div class="modal_gasto modal_ventana">
    <input type="hidden" name="gastoid" id="modal_gastoid">
    <table>
        <tr>
            <td>
                Hotspot:
            </td>
            <td>
                <select name="gastohotspot" id="modal_gastohotspot">
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['hotspot']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                Cantidad:
            </td>
            <td>
                <input type="text" name="gastocantidad" id="modal_gastocantidad">
            </td>
        </tr>
        <tr>
            <td>
                Descripción:
            </td>
            <td>
                <input type="text" name="gastodescripcion" id="modal_gastodescripcion">
            </td>
        </tr>
        <tr>
            <td>
                Precio:
            </td>
            <td>
                <input type="text" name="gastoprecio" id="modal_gastoprecio">
            </td>
        </tr>
    </table>
</div><?php }} ?>
