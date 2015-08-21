<form method="POST" id="pageusuarios">
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
        {html_table table_attr='border="0" class="tabledit" id="tableusers"' loop=$users tr_attr=$tr cols=4}
    </div>
    </div>
    <div class="float_clear"></div>
    {if $smarty.session.cliente == 'admin'}
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
        {html_table table_attr='border="0" class="tabledit" id="tableclientes"' loop=$clientes tr_attr=$trcliente}
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
                            {foreach item=item from=$cliente}
                                <option value="{$item.0}">{$item.1}</option>
                            {/foreach}
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
        {html_table table_attr='border="0" class="tabledit" id="tablelocales"' loop=$local tr_attr=$trlocal cols=4}
    </div>
    <div class="float_clear"></div>
    {/if}
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
                        {foreach item=item from=$cliente}
                            <option value="{$item.0}">{$item.1}</option>
                        {/foreach}
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="eliminar">
    <div>¿Desea realemente eliminar la entrada?</div>
</div>
