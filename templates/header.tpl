<!DOCTYPE html>
{strip}
<html lang="es">
    <head>
        <title>{$title}</title>
        <meta charset="UTF-8">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        {*<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">*}
	    {*<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">*}
    {foreach item=code from=$includeheadercss}
	    {$code}
    {/foreach}
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	    {*<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>*}
    {foreach item=code from=$includeheaderjs}
        {$code}
    {/foreach}
    </head>
    <body>
        <div class="align_center">
            <img src="{$smarty.const.DOMAIN}/images/logos/{$smarty.session.cliente}{if isset($smarty.session.local)}.{$smarty.session.local}{/if}.png" {if ($smarty.const.TEMPLATE_NAME != 'login') && ($smarty.const.TEMPLATE_NAME != 'contrasena')} width="150px"{/if}>
        </div>
        <br>
    {/strip}
        
