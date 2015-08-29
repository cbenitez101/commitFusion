<?php /* Smarty version Smarty-3.1.18, created on 2015-08-29 08:27:14
         compiled from "/volume1/web/www-sb/templates/tickets/bloc.tpl" */ ?>
<?php /*%%SmartyHeaderCode:160872653355e15ed21ae870-01030315%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29eecd87d35269193a61ad01c0ecb171699bd374' => 
    array (
      0 => '/volume1/web/www-sb/templates/tickets/bloc.tpl',
      1 => 1440829858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160872653355e15ed21ae870-01030315',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cols' => 0,
    'bloc' => 0,
    'excel' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_55e15ed224d3e2_66778346',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e15ed224d3e2_66778346')) {function content_55e15ed224d3e2_66778346($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_table')) include '/volume1/web/www-sb/includes/../libs/plugins/function.html_table.php';
?><form method="POST">
    <div>
        Crear bloc:
        <input type="text" name="bloc_nombre" placeholder="Nombre">
        <select type="text" name="bloc_tiempo">
            <option>Seleccione duración</option>
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
        <input type="text" name="bloc_cantidad" placeholder="Tickets">
        <input type="text" name="bloc_descripcion" placeholder="Descripcion">
        <input class="ui-button" type="submit" value="Crear" name="create_gasto" />
    </div>
</form>
<div class="float_left">
    <?php echo smarty_function_html_table(array('cols'=>$_smarty_tpl->tpl_vars['cols']->value,'table_attr'=>'border="0" class="tabledit bloctable" id="table-search-bloc"','loop'=>$_smarty_tpl->tpl_vars['bloc']->value),$_smarty_tpl);?>

</div>
<?php if (isset($_smarty_tpl->tpl_vars['excel']->value)) {?>
    <script>window.location='http://servibyte.net/bloc_excel?bloc=<?php echo $_smarty_tpl->tpl_vars['excel']->value;?>
';</script>
<?php }?>
<div class="modal_bloc modal_ventana">
    <input type="hidden" name="blocid" id="modal_blocid">
    <table>
        <tr>
            <td>
                Nombre:
            </td>
            <td>
                <input type="text" name="blocnombre" id="modal_blocnombre">
            </td>
        </tr>
        <tr>
            <td>
                Tiempo:
            </td>
            <td>
                <span name="bloctiempo" id="modal_bloctiempo"></span>
            </td>
        </tr>
        <tr>
            <td>
                Descripción:
            </td>
            <td>
                <input type="text" name="blocdescripcion" id="modal_blocdescripcion">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input class="ui-button" type="button" value="Excel" id="excel_button"/>
            </td>
        </tr>
    </table>
</div>
<div class="modal_import modal_ventana">
    <input type="hidden" name="importid" id="modal_importid">
    <table>
        <tr>
            <td>
                HotSpot:
            </td>
            <td>
                <select id="modal_importhotspot" name="importhotspot">
                    <option value="">Seleccione un Hotspot</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Perfil:
            </td>
            <td>
                <select id="modal_importperfil" name="importperfil" disabled="disabled">
                    <option>Selecciona un Perfil</option>
                </select>
            </td>
        </tr>
    </table>
</div><?php }} ?>
