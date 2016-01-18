<?php /* Smarty version Smarty-3.1.18, created on 2015-04-13 11:02:31
         compiled from "/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/crear.tpl" */ ?>
<?php /*%%SmartyHeaderCode:82391456154cbea17cf0e57-21189505%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b94e5dc3be7d7c98de3a57a47c53aaa64b589d6e' => 
    array (
      0 => '/var/www/vhosts/servibyte.com/servibyte.net/templates/tickets/crear.tpl',
      1 => 1428326872,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '82391456154cbea17cf0e57-21189505',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54cbea17cf1932_61232383',
  'variables' => 
  array (
    'tickets' => 0,
    'item' => 0,
    'key' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54cbea17cf1932_61232383')) {function content_54cbea17cf1932_61232383($_smarty_tpl) {?><?php if ($_SESSION['cliente']=='admin') {?>
    <div>
        <div class="title">
            Crea bloc
        </div>
        <div>
            <form action="" method="POST">
                <div>
                    Hotspot
                </div>
                <div>
                    
                </div>
            </form>
        </div>
    </div>
<?php } else { ?>
<div>
    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tickets']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
        <div class="ticket" <?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value) {
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['data']->key;
?><?php if (($_smarty_tpl->tpl_vars['key']->value!='duraciontexto')) {?> data-<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['data']->value;?>
"<?php }?><?php } ?>><p><?php echo $_smarty_tpl->tpl_vars['item']->value['duraciontexto'];?>
</p><p><?php echo $_smarty_tpl->tpl_vars['item']->value['Precio'];?>
€</p></div>
    <?php } ?>
</div>
<div class="ticket-crear">
    <button style="visibility: hidden;" class="btnPrint"/>
</div>
<div class="modal_creaticket modal_ventana">
    <table>
        <tr>
            <td>
                Numero de habitacion:
            </td>
            <td>
                <input type="text" name="ticketident" id="modal_ticketid">
            </td>
        </tr>
    </table>
</div>
<?php }?><?php }} ?>
