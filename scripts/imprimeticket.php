<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" type="text/css" media="all" href="grid960/reset.css" /> 
        <link rel="stylesheet" type="text/css" media="all" href="grid960/text.css" /> 
        <link rel="stylesheet" type="text/css" media="all" href="grid960/960.css" /> 
        <style type="text/css">
	        
	      
	             <?php if (isset($_GET['full'])): ?>
	                 @page {size: A4;margin: 0;} @media print {html, body {width: 210mm;height: 297mm;}}  .data{ padding-top: 5px; margin-left: -30px;} .border {border: 1px solid black;display: inline-block}
	             <?php else: ?>
	                 @media print {html, body {width: 80mm;}} body {width: 8cm; text-align: center; font-size: 30px;}
	             <?php endif; ?>
	             
	             
	             <?php
        	            date_default_timezone_set('Atlantic/Canary');
        	            function secondsToTime($seconds) {
        	                $dtF = new \DateTime('@0');
        	                $dtT = new \DateTime("@$seconds");
        	                return $dtF->diff($dtT)->format((($seconds >= 86400)?'%a days':'%h hours'));
        				}
	        ?>
	        .logo {
	            text-align: center;
	            float: center;
	        }
	        #logo{
	        	max-width: 350px;
	        	max-height: 250px;
	        	padding-top: 30px;
	        	padding-bottom: 30px;
	        	
	        }
	        .logo2 {
	            text-align: center;
	        	padding-bottom: 5px;
	        	padding-left: 10px;
	        	max-width: 350px;
	        }
	        .data {
	            text-align: center;
                 
	        }
	        
	        .border {
	            text-align: center;
	            width: 350px;
	            padding-bottom: 5px;
	            <?php if (!isset($_GET['full'])): ?>
	                padding-top:5px;
	                padding-left: 20px;
	           <?php else: ?>
	                padding-top:20px;
	           <?php endif; ?>
	            
	        }
	        .grid_5{
	        	font-size: 90%;
	            padding-top: 30px;
	            text-align: justify;
	        } 
	        .flags {
	            margin-top: -100px;
	        }
	        .flagimg{
	            max-width:100px;
	            text-align: center;
	        }
	      
	        </style>
    </head>
    <body>    
		
        <div class='data'>
            <?php 
    		//Si se pasa por parámetro una foto con nombre $hotspot, se buscará $hotspot.hotspot.es y si existe se utiliza como logo
                $logo = ((file_exists(getcwd().'/../images/logos/'.strtolower($_GET['hotspot']).'.'.strtolower($_GET['hotspot']).'.png'))?'logos/'.strtolower($_GET['hotspot']).'.'.strtolower($_GET['hotspot']):"logo");
            ?>
            <div class="logo<?php echo ((isset($_GET['full']))? '':'2')?>">
                 <img id="logo" src="../images/<?php echo $logo ?>.png">
            </div>
              
        	<div class='border'>
                
                <!-- Aqui no estaba el condicional, solo se por el usuario -->

                <?php if (!empty($_GET['pass'])): ?>
                    <p>User: <?php echo $_GET['user']; ?></p>
                <?php else: ?>
                    <p>Pass: <?php echo $_GET['user']; ?></p>
                <?php endif; ?>
                
                <!-- Aqui no estaba el condicional, solo se por el usuario -->
                  
                <?php if (!empty($_GET['pass'])): ?>
                    <p>Pass: <?php echo $_GET['pass']; ?></p>
                <?php endif; ?>
                <?php if (!empty($_GET['identificador'])): ?>
                    <p>
                        Id: <?php echo $_GET['identificador']; ?>
                        &nbsp;Date: 
                        <?php if (!empty($_GET['fecha'])): ?>
                            <?php echo $_GET['fecha']; ?>
                        <?php else: ?>
                            <?php echo date("d-m-y") ?>
                        <?php endif; ?>
                    </p>
                <?php else: ?>
                    <?php if (!empty($_GET['fecha'])): ?>
                        <p>
                            <?php echo $_GET['fecha']; ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($_GET['precio'])): ?>
                    <p>
                        <?php echo (($_GET['precio'] == '0.00')?"Free":$_GET['precio']."€"); ?>
                         &nbsp;<?php echo secondsToTime($_GET['duracion']); ?>
                         &nbsp;-&nbsp; <?php echo ((strtolower($_GET['hotspot']) == 'coronablanca')? 'HIGH SPEED' : ''); ?>
                    </p>
                <?php endif; ?>
            </div>
            <?php if(isset($_GET['full'])): ?> 
            	<!-- Parte de los términos. Se utiliza grid360 para las columnas-->
            	
            	<div class="flags container_12">
            	    <div class="grid_1"> &nbsp;</div>
            	    <div class="grid_2">
            	        <img class="flagimg" src="../images/es.png" alt="es"></img>
            	    </div>
            	    <div class="grid_6"> &nbsp;</div>
            	    <div class="grid_2">
            	        <img class="flagimg" src="../images/en.png" id="esflag" alt="en"></img>
            	    </div>
            	</div>
                <div class="clear">&nbsp;</div> 
                <div class="container_12">
                    <div class="grid_1">&nbsp; </div>
                    <div class="grid_5"> 
                        <ol>
                            <li><strong>¿Puedo coneectarme con más de un dispositivo a la vez? </strong>Si, hay un límite de <strong> <?php echo ((strtolower($_GET['hotspot']) == 'coronablanca')? '3 dispositivos por sesión' : 'X dispositivos por sesión'); ?> </strong> . Si quiere conectar mas dispositivos, primero tiene que cerrar la sesión en uno que esté en uso. Para saber como desconectar consulte el punto 6.</li>
                            <li><strong>¿Hay limitaciones de tráfico, velocidad o aplicaciones? </strong>Los límites están establecidos en la velocidad de descarga y de subida. No hay límites en la cantidad de tráfico ni en aplicaciones.</li>
                            <li><strong>¿Formas de pago?</strong>Se puede pagar en mostrador del establecimiento en efectivo o tarjeta, o mediante la plataforma de pago paypal en el portal de la red wifi (donde se pide el código de conexión).</li>
                            <li><strong>¿Seguridad de los datos?</strong>Todas las redes están protegidas para que los usuarios no se vean entre sí. Los datos de conexión del dispositivo serán registrados acorde con la Ley Orgánica de Protección de Datos (LOPD).</li>
                            <li><strong>¿Cómo me conecto?</strong>Antes de todo compruebe que el Wifi del dispositivo está activado (en la configuración de redes del dispositivo). Entre las redes que le aparezcan seleccione la red del establecimiento. Está configurado para libre acceso, sin contraseña, seleccione la red y conéctese a ella. Una vez conectado, si no se le abre una página web pidiendo la clave de conexión, abra un navegador e intente navegar a cualquier página web (intente acceder a google por ejemplo). Una vez con la pantalla de solicitud del código de conexión introdúzcalo, acepte las condiciones y pulse acceder. Se le mostrará un mensaje de confirmación y ya podrá navegar.</li>
                            <li><strong>¿Cómo me desconecto?</strong>Para cerrar la conexión acceda a http://exit.com. La sesión se cerrará automáticamente si no se conecta en un periodo de 7 días.</li>
                            <li><strong>Solución de problemas</strong>
                                <ol>
                                    <li><u>No me puedo conectar:</u> Dependiendo del número de dispositivos autorizados en el establecimiento puede ser que tenga otros dispositivos con la sesión abierta. Cierre la sesión en todos los sdispositivos y vuelva a conectarse. Si este no es el caso o habiendo cerrado todos los dispositivos sigue sin poder conectar, borre las cookies del navegador (en la configuración del navegador del dispositivo) y en las conexiones wifi escoja olvidar la red del establecimiento (en la configuración wifi del dispoditivo).</li>
                                    <li><u>Estoy conctado pero no navego:</u> Asegúrese de que ha iniciado la sesión en el dispositivo, si no sabe si está iniciada la sesión, ciérrela y vuelva a iniciar la sesión.</li>
                                    <li><u>Otras dudas:</u> En caso de no poder solucionar las dudas acuda al mostrador del establecimiento donde le podrán asesorar y en el caso abrir un ticket de incidencia.</li>
                                </ol>
                            </li>
                        </ol>
                    </div> 
                    <div class="grid_5"> 
                        <ol>
                            <li><strong>Can I connect more than one device at the same time? </strong>Yes, there is a limit of <strong><?php echo ((strtolower($_GET['hotspot']) == 'coronablanca')? '3 dispositivos por sesión' : 'X dispositivos por sesión'); ?> </strong>. If you want to connect more than x device first must log out one in use. To know how to disconnect, see point 6.</li>
                            <li><strong>Are there limitations of traffic, speed or applications? </strong>The limits are set at download and upload speed. There is no limitation about the traffic amount or kind of applications.</li>
                            <li><strong>Payment?</strong>You can pay cash or credit card at info establishment's desk, or by paypal payment at wireless wabsite platform (where connection code is required).</li><!--<br>-->
                            <li><strong>Data security?</strong>All networks are protected that users can not see each other. The connection data device will be recorded according to Spanish Data Protection Law (LOPD).</li><!--<br>-->
                            <li><strong>How do I connect?</strong>First of all, check that the wireless device is tuned on (at device network configuration). Select establishment. It is open acces without password, select the network and connect to it. Once connected, if it does not open a webpage asking the connection pass, open a browser and try to navigate to any web page (try access to google for example). Once the webpage is loaded insert code request connection, accept the terms and press enter. It will show a confirmation message and then you can navigate.</li><!--<br><br>-->
                            <li><strong>How do I disconnect?</strong>To log out reach http://exit.com. The session will close automatically if it is not connected over a period of 7 days</li><!--<br>-->
                            <li><strong>Troubleshooting</strong>
                                <ol>
                                    <li><u>I can not connect:</u> Depending on the number of authorized devices at the same time you might have another device logged in. Log out all devices and try again. If this is not the case or having closed all devices still can not be able to connect, delete browser cookier (in device browser settings) and Wi-Fi connections choose "forget network" option (in the wireless device configuration).</li><!--<br><br>-->
                                    <li><u>I am connected to the network but not navigate:</u> Make sure you are logged in, if you do not know if you're logged in, then logout and try again to log in.</li>
                                    <li><u>Other questions:</u> If you have more doubt, please ask in establishment info where they will advise you and if it's needed open a sat ticket.</li>
                                </ol>
                            </li>
                        </ol>
                    </div> 
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
