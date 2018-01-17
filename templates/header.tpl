<!DOCTYPE html>
{strip}
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Servibyte SCP">
        <link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png?v=YAK9NGzbq6">
        <link rel="icon" type="image/png" href="/icon/favicon-32x32.png?v=YAK9NGzbq6" sizes="32x32">
        <link rel="icon" type="image/png" href="/icon/favicon-16x16.png?v=YAK9NGzbq6" sizes="16x16">
        <link rel="manifest" href="/icon/manifest.json?v=YAK9NGzbq6">
        <link rel="mask-icon" href="/icon/safari-pinned-tab.svg?v=YAK9NGzbq6" color="#8b918b">
        <link rel="shortcut icon" href="/icon/favicon.ico?v=YAK9NGzbq6">
        <meta name="apple-mobile-web-app-title" content="Servibytge">
        <meta name="application-name" content="Servibytge">
        <meta name="msapplication-config" content="/icon/browserconfig.xml?v=YAK9NGzbq6">
        <meta name="theme-color" content="#ffffff">
        <title>{$title}</title>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	    {*<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">*}
	    <!-- MetisMenu CSS -->
	    <link href="/scripts/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

	    <!-- Custom CSS -->
	    <link href="/scripts/dist/css/sb-admin-2.css" rel="stylesheet">

	    <!-- Custom Fonts -->
	    <link href="/scripts/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js does not work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->
        {foreach item=code from=$includeheadercss}
    	    {$code}
        {/foreach}

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
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
        <div class="row mensajealerta">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable" id="alertok" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span>
                    </button>
                    Se ha guardado la entrada.
                </div>
                <div class="alert alert-success alert-dismissable" id="alertdelete" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Se ha eliminado la entrada.
                </div>
                <div class="alert alert-danger alert-dismissable" id="alerterror" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    No se ha podido finalizar la acción.
                </div>
            </div>
        </div>
    {/strip}
        
