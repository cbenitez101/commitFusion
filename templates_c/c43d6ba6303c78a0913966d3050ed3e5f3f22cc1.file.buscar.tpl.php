<?php /* Smarty version Smarty-3.1.18, created on 2015-08-19 10:32:13
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/buscar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12501407135501dd762cabb3-10917945%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c43d6ba6303c78a0913966d3050ed3e5f3f22cc1' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/buscar.tpl',
      1 => 1439942243,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12501407135501dd762cabb3-10917945',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5501dd7636e107_24118612',
  'variables' => 
  array (
    'busqueda' => 0,
    'servers' => 0,
    'item' => 0,
    'out' => 0,
    'estado' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5501dd7636e107_24118612')) {function content_5501dd7636e107_24118612($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_truncate')) include '/var/www/vhosts/servibyte.com/servibyte.net/includes/../libs/plugins/modifier.truncate.php';
?><?php if (isset($_smarty_tpl->tpl_vars['busqueda']->value)) {?>
    <form method="GET" action="/tickets/resultado">
        <table>
            <tr>
                <th>
                    Usuario:
                </th>
                <td>
                    <input type="text" name="user" placeholder="Usuario">
                </td>
            </tr>
            <tr>
                <th>
                    Rango Fecha: 
                </th>
                <td>
                    <input type="text" name="fechainicio" id="datepicker1" placeholder="Inicio">
                </td>
                <td>
                    <input type="text" name="fechafin" id="datepicker2" placeholder="Fin">
                </td>
            </tr>
            <tr>
                <th>
                    Identificador:
                </th>
                <td>
                    <input type="text" name="identificador" placeholder="Identificador">
                </td>
            </tr>
	    <?php if (isset($_smarty_tpl->tpl_vars['servers']->value)) {?>
            <tr>
                <th>
                    Servidor:
                </th>
                <td>
                    <select name="server">
                        <option value="">Elija Hotspot</option>
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['servers']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
	    <?php }?>
            <tr>
                <td>
                    <input type="submit" value="Buscar" class="ptitle"/>
                </td>
            </tr>
        </table>
    </form>
<?php } else { ?>
    <div>
        <table id="infoticket">
            <tr>
                <th colspan="2">
                    Informacion del Ticket
                </th>
            </tr>
            <tr>
                <td>
                    Usuario:
                </td>
                <td>
                     <?php echo $_smarty_tpl->tpl_vars['out']->value['info']['username'];?>

                </td>
            </tr>
            <tr>
                <td>
                    Contraseña:
                </td>
                <td>
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['out']->value['infoticket']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['attribute']=='Cleartext-Password') {?>
                            <?php echo $_smarty_tpl->tpl_vars['item']->value['value'];?>

                        <?php }?>
                    <?php } ?>
                </td>
            </tr>
            
            <tr>
                <td>
                    Local:
                </td>
                <td>
                    <?php echo $_smarty_tpl->tpl_vars['out']->value['plataforma']['ServerName'];?>

                </td>
            </tr>
            <tr>
                <td>
                    Lote:
                </td>
                <td>
                    <?php echo $_smarty_tpl->tpl_vars['out']->value['plataforma']['Descripcion'];?>

                </td>
            </tr>
            <tr>
                <td>
                    Costo:
                </td>
                <td>
                    <?php echo $_smarty_tpl->tpl_vars['out']->value['plataforma']['Costo'];?>
€
                </td>
            </tr>
            <tr>
                <td>
                    Precio:
                </td>
                <td>
                    <?php echo $_smarty_tpl->tpl_vars['out']->value['plataforma']['Precio'];?>
€
                </td>
            </tr>
            <tr>
                <td>
                    Fecha Venta:
                </td>
                <td>
                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['out']->value['plataforma']['FechaVenta'],"%d/%m/%y %T");?>

                </td>
            </tr>
            <tr>
                <td>
                    Fecha primer uso:
                </td>
                <td>
                    <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['out']->value['accounting'][0]['acctstarttime'],"%d/%m/%y %T");?>

                </td>
            </tr>
            <tr>
                <td>
                    Fecha ultimo uso:
                </td>
                <td>
                    <?php if (count($_smarty_tpl->tpl_vars['out']->value['accounting'])>0) {?>
                        <?php if (!empty($_smarty_tpl->tpl_vars['out']->value['accounting'][count($_smarty_tpl->tpl_vars['out']->value['accounting'])-1]['acctstoptime'])) {?>
                            <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['out']->value['accounting'][count($_smarty_tpl->tpl_vars['out']->value['accounting'])-1]['acctstoptime'],"%d/%m/%y %T");?>

                        <?php } else { ?>
                            En Uso
                        <?php }?>
                    <?php }?>
                </td>
            </tr>
            <tr>
                <td>
                    Identificador:
                </td>
                <td>
                    <?php echo $_smarty_tpl->tpl_vars['out']->value['plataforma']['identificador'];?>

                </td>
            </tr>
            <tr>
                <td>
                    Estado:
                </td>
                <td>
                    
                    <span style="background-color: <?php if ($_smarty_tpl->tpl_vars['estado']->value=='VALIDO') {?>green<?php } else { ?>red<?php }?>"><?php echo $_smarty_tpl->tpl_vars['estado']->value;?>
</span><?php if ($_smarty_tpl->tpl_vars['estado']->value=="CANCELADO") {?>'<?php echo $_smarty_tpl->tpl_vars['out']->value['plataforma']['comentario'];?>
' '<?php echo $_smarty_tpl->tpl_vars['out']->value['plataforma']['anulacion_usuario'];?>
 - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['out']->value['plataforma']['anulacion_fecha'],"%d/%m/%y %T");?>
'<?php }?>
                </td>
            </tr>
        </table>
    </div>
    
    <div>
        <script>var anula_user = "<?php echo $_SESSION['user'];?>
"</script>
        <?php if ($_smarty_tpl->tpl_vars['estado']->value=='VALIDO') {?>
            <input type="button" value="Anular" id="anularticket" class="ptitle"/>
        <?php } elseif ($_SESSION['cliente']=='admin') {?>
            <input type="button" value="Desanular" id="desanularticket" class="ptitle"/>
        <?php }?>
        <?php if ($_SESSION['cliente']=='admin') {?>
            <input type="button" value="Borrar" id="borrarticket" class="ptitle"/>
        <?php }?>
    </div>
    <?php if (count($_smarty_tpl->tpl_vars['out']->value['accounting'])>0) {?>
        <div>
            <div>
                Usos de tickets
            </div>
            <table>
                <thead id="tabletitle">
                    <tr>
                        <th class="">
                            Equipo
                        </th>
                        <th>
                            Inicio Sesion
                        </th>
                        <th>
                            Fin de Sesion
                        </th>
                        <th>
                            Duracion
                        </th>
                        <th>
                            Subida
                        </th>
                        <th>
                            Descarga
                        </th>
                        <th>
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="accountingtable">
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['out']->value['accounting']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                    <tr>
                        <td>
                            <?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['callingstationid'],14,'**',true,true);?>
 <?php echo mac_vendor($_smarty_tpl->tpl_vars['item']->value['callingstationid']);?>

                        </td>
                        <td>
                            <?php echo $_smarty_tpl->tpl_vars['item']->value['acctstarttime'];?>

                        </td>
                        <td>
                            <?php echo $_smarty_tpl->tpl_vars['item']->value['acctstoptime'];?>

                        </td>
                        <td>
                            <?php echo intval($_smarty_tpl->tpl_vars['item']->value['acctsessiontime']/86400);?>
 Días <?php echo gmdate('H:i:s',$_smarty_tpl->tpl_vars['item']->value['acctsessiontime']);?>

                        </td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['item']->value['acctinputoctets']>(1024*1024)) {?>
                                <?php echo number_format((($_smarty_tpl->tpl_vars['item']->value['acctinputoctets']/1024)/1024),0,',','.');?>
Mb
                            <?php } else { ?> 
                                <?php echo number_format(($_smarty_tpl->tpl_vars['item']->value['acctinputoctets']/1024),0,',','.');?>
Kb
                            <?php }?>
                        </td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['item']->value['acctoutputoctets']>(1024*1024)) {?>
                                <?php echo number_format((($_smarty_tpl->tpl_vars['item']->value['acctoutputoctets']/1024)/1024),0,',','.');?>
Mb
                            <?php } else { ?> 
                                <?php echo number_format(($_smarty_tpl->tpl_vars['item']->value['acctoutputoctets']/1024),0,',','.');?>
Kb
                            <?php }?>
                        </td>
                        <td>
                            <?php if (($_smarty_tpl->tpl_vars['item']->value['acctoutputoctets']+$_smarty_tpl->tpl_vars['item']->value['acctinputoctets'])>(1024*1024)) {?>
                                <?php echo number_format(((($_smarty_tpl->tpl_vars['item']->value['acctoutputoctets']+$_smarty_tpl->tpl_vars['item']->value['acctinputoctets'])/1024)/1024),0,',','.');?>
Mb
                            <?php } else { ?> 
                                <?php echo number_format((($_smarty_tpl->tpl_vars['item']->value['acctoutputoctets']+$_smarty_tpl->tpl_vars['item']->value['acctinputoctets'])/1024),0,',','.');?>
Kb
                            <?php }?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2">&nbsp</td>
                    <td class="ptitle">Total</td>
                    <td>
                        <?php echo intval($_smarty_tpl->tpl_vars['out']->value['suma']['time']/86400);?>
 Días <?php echo gmdate('H:i:s',$_smarty_tpl->tpl_vars['out']->value['suma']['time']);?>

                    </td>
                    <td>
                        <?php if ($_smarty_tpl->tpl_vars['out']->value['suma']['in']>(1024*1024)) {?>
                            <?php echo number_format((($_smarty_tpl->tpl_vars['out']->value['suma']['in']/1024)/1024),0,',','.');?>
Mb
                        <?php } else { ?> 
                            <?php echo number_format(($_smarty_tpl->tpl_vars['out']->value['suma']['in']/1024),0,',','.');?>
Kb
                        <?php }?>
                    </td>
                    <td>
                        <?php if ($_smarty_tpl->tpl_vars['out']->value['suma']['out']>(1024*1024)) {?>
                            <?php echo number_format((($_smarty_tpl->tpl_vars['out']->value['suma']['out']/1024)/1024),0,',','.');?>
Mb
                        <?php } else { ?> 
                            <?php echo number_format(($_smarty_tpl->tpl_vars['out']->value['suma']['out']/1024),0,',','.');?>
Kb
                        <?php }?>
                    </td>
                    <td>
                        <?php if (($_smarty_tpl->tpl_vars['out']->value['suma']['out']+$_smarty_tpl->tpl_vars['out']->value['suma']['in'])>(1024*1024)) {?>
                            <?php echo number_format(((($_smarty_tpl->tpl_vars['out']->value['suma']['out']+$_smarty_tpl->tpl_vars['out']->value['suma']['in'])/1024)/1024),0,',','.');?>
Mb
                        <?php } else { ?> 
                            <?php echo number_format((($_smarty_tpl->tpl_vars['out']->value['suma']['out']+$_smarty_tpl->tpl_vars['out']->value['suma']['in'])/1024),0,',','.');?>
Kb
                        <?php }?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php }?>
<?php }?>
<div class="modal_ticket modal_ventana">
    <table>
        <tr>
            <td>
                Motivo Anulacion:
            </td>
            <td>
                <input type="text" name="ticketcancel" id="modal_ticketcancel">
            </td>
        </tr>
    </table>
</div>
<?php }} ?>
