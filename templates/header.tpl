<!DOCTYPE html>
{strip}
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Servibyte SCP">
        <title>{$title}</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	    {*<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">*}
	    <!-- MetisMenu CSS -->
	    <link href="/scripts/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

	    <!-- Custom CSS -->
	    <link href="/scripts/dist/css/sb-admin-2.css" rel="stylesheet">

	    <!-- Custom Fonts -->
	    <link href="/scripts/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
    {foreach item=code from=$includeheadercss}
	    {$code}
    {/foreach}

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src="/scripts/bower_components/metisMenu/dist/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="/scripts/dist/js/sb-admin-2.js"></script>

        {foreach item=code from=$includeheaderjs}
            {$code}
        {/foreach}
    </head>
    <body>

    {/strip}
        
