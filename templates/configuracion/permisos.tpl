{strip}
<form method="POST" id="fpermisos">
    <div id="permisotabla" class="float_left">
        <div class="input-filter-container"><label for="input-filter">Buscar:</label> <input type="search" id="input-filter" size="15" placeholder="search"></div>
        {html_table cols="Id, Nombre, Email" table_attr='border="0" class="tabledit" id="table-search"' loop=$users tr_attr=$tr}
        <input type="hidden" name="user" id="pusuarios" value="{$id}">
    </div>
    <div id="permisos" class="float_left">
        <div class="ptitle">Clientes &nbsp; &nbsp; Locales</div>
        {foreach item=cliente key=cnombre from=$permisos}
            <div class="cliente">
                &#x25B6;
                <input type="checkbox" cliente="{$cliente.id}" name="cliente[]" value="" {if in_array($id,$cliente['usuarios'])} checked="checked"{/if}/>{$cnombre}
                {if count($cliente['locales'])>0}
                    {foreach item=local key=lnombre from=$cliente.locales}
                        <div class="local">
                            <input type="checkbox" cliente="{$cliente.id}" local="{$local.id}" name="locales[{$cliente.id}][]" value="" {if in_array($id,$local['usuarios'])} checked="checked"{/if}/>{$lnombre}
                        </div>
                    {/foreach}
                {/if}
            </div>
        {/foreach}
    </div>
    <div class="float_clear"></div>
</form>
{/strip}

    