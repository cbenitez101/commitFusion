<?php

/* INCLUDES */
include_once('../includes/functions.php');

include_once('configs.php');

/* HEADERS */
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); 

/* SET TIMEZONE: Hay que comprobar que la hora sea la correcta ya que se ejecuta desde la VPS */
/* Probablemente haya que quitar esta instruccion y/o añadirle 1 hora a los expirationTime */


date_default_timezone_set ('Atlantic/Canary');

// Se comprueba si se nos han enviado datos
if (!empty($_POST)){
    // Se obtienen los headers de la peticion realizada
    $headers = apache_request_headers();
    // Si tiene el header de autorizacion y concuerda con el del cliente podemos realizar la operacion
    if (isset($headers['Authorization'])){
        
        /*---------------------------------------------------------------
                    COMIENZO OBTENCION API KEY Y DATOS HOTSPOT
        -----------------------------------------------------------------*/


        // Se busca el usuario por su apikey
        if ($hotspots = $apidbp->query("SELECT * FROM hotspots WHERE apikey='".$headers['Authorization']."'"));  
        
        /*---------------------------------------------------------------
                    FIN OBTENCION API KEY Y DATOS HOTSPOT
        -----------------------------------------------------------------*/
        
        // Si se encuentra el usuario por su APIKEY procesamos el body de la petición, accediendo a los
        // campos que se nos envían
        if ($hotspots->num_rows > 0){
            
            $aux = $hotspots->fetch_assoc();
            
            $idHotspot = $aux['id'];
            
            $ServerName = $aux['ServerName'];
            
            /*---------------------------------------------------------------
                                COMIENZO OPERACIONES
            -----------------------------------------------------------------*/
            
            // Si tenemos los campos necesarios, procedemos a crear el ticket
            if (isset($_POST['profileid']) && isset($_POST['ref']) && !isset($_POST['username'])){
                
                // Obtenemos perfil mediante el id que nos pasan en el body de la peticion. Si nos faltan datos, los cogeremos del perfil   
                $perfiles = $apidbp->query("SELECT * FROM `perfiles` WHERE id = '".$_POST['profileid']."'");
                
                $auxperfil = $perfiles->fetch_assoc();
                   
                // Cálculo de la fecha de expiración. Si nos dan hora, se pone el expiration con la fecha y hora dadas. Si no nos mandan la hora ponemos el expirationTime a las 0:00 horas del dia siguiente.
                if (isset($_POST['expirationDay'])) {
                    
                    // TIMEZONE: Probar y añadir 1 hora al expirationTime si es necesario ya que el VPS tiene horario peninsular.
                    
                    $addedTime = date('d M Y H:i', strtotime( $_POST['expirationDay']." ".$_POST['expirationTime']."+1 hour"));
                    
                    $expirationDate = ((isset($_POST['expirationTime']))? $addedTime : date('d M Y', strtotime($_POST['expirationDay']. '+ 1 Day'))." 0:00");
                    
                    // $expirationDate = ((isset($_POST['expirationTime']))? date('d M Y', strtotime($_POST['expirationDay']))." ".$_POST['expirationTime'] : date('d M Y', strtotime($_POST['expirationDay']. '+ 1 Day'))." 0:00");
                    
                } else{ // En caso de no pasarnos hora, cogeremos el Expiratio y/o duration del perfil
                    
                    if ($auxperfil['Expiration'] !== '0000-00-00') $expirationDate = $auxperfil['Expiration'];
                    
                    else $duration = $auxperfil['Duracion']; // En caso contrario utilizaremos el expiration o la duracion del profile
                    
                }
                
                // Creación del usuario para el hotspot. se utilizan 3 primeras letras del nombre, 3 primeras letras del primer apellido y la fecha de checkout sin guiones ni espacios.
                if (isset($_POST['name']) && isset($_POST['lastname'])) { // Si se envían nombre y apellidos, formamos el usuario con los mismos
                    
                    if (isset($_POST['expirationDay'])) { // Si nos envían fecha de salida la incluimos en el nombre de usuario
                        
                        $username = strtoupper(substr($_POST['name'],0,3).substr($_POST['lastname'],0,3).substr(str_replace("-","",$_POST['expirationDay']), 2));
                        
                        $contrasena = $username;
                        
                    }
                    
                    else{ // si no se envía la fecha de salida, ponemos la referencia en su lugar
                        
                        $username = strtoupper(substr($_POST['name'],0,3).substr($_POST['lastname'],0,3).date('ymd', strtotime("NOW")));//Ponerle otro campo en vez de la fecha de salida
                        
                        $contrasena = $username;
                    }
                    
                } else {    // En el caso que no se envíen nombre y apellidos, utilizaremos los formatos de usuario y contraseña del perfil
                    
                    if ($auxperfil['userformat'] !== '') {   // Si el campo usuario no esta vacio se crea el usuario con dicho formato
                        
                        $username = usuario_aleatorio($auxperfil['userformat']);
                        
                        // Si el password es 'usuario', tendrá el mismo valor que el usuario
                        if ($auxperfil['Password'] == 'usuario') $contrasena = $username;
                        
                        else $contrasena =  usuario_aleatorio($auxperfil['Password']); // Si no pone 'usuario', generamos la contraseña con el patrón guardado 
                            
                        
                        
                    } else { // Si el formato de usuario está vacio, se genera un usuario con el formato 'CVCVCVNN'
                        
                        $username = usuario_aleatorio('CVCVCVNN');
                        
                        if ($auxperfil['Password'] == 'usuario') $contrasena = $username;
                        
                        else $contrasena = usuario_aleatorio($auxperfil['Password']);
                            
                    }

                }
                
                // Se comprueba que no exista el usuario ya creado con anterioridad
                $radusrgrp = $apidbr->query("SELECT * FROM `radusergroup` WHERE `username` = '".$ServerName.'_'.$contrasena."'");
                
                $resul = $apidbr->query("SELECT * FROM `radcheck` WHERE `username` = '".$ServerName.'_'.$contrasena."'");

                // Si no existe el usuario procedemos a crear las entradas necesarias en el radius.
                if ($radusrgrp->num_rows == 0 && $resul->num_rows == 0 ){
                    
                    // Introducimos valores necesarios en el radius para crear y habilitar el nuevo ticket
                    
                    if ($apidbr->query("INSERT INTO `radusergroup`(`username`, `groupname`, `priority`) VALUES ('".$ServerName.'_'.$username."','".$ServerName."',1)")) {
                        
                        if ($apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','Cleartext-Password',':=','$contrasena')")) {
                            
                            if ($apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','".$auxperfil['Movilidad']."','==','".$ServerName."')")) {
                            
                                if (isset($duration)) $apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','".$auxperfil['ModoConsumo']."',':=','".$duration."')");
                            
                                if (isset($expirationDate)) $apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','Expiration',':=','".$expirationDate."')");
                                
                                if ($lotes = $apidbp->query("SELECT id, precio FROM `lotes` WHERE Id_perfil = ".$_POST['profileid'])){
                                    
                                    if ($lotes->num_rows > 0){
                                    
                                        $auxplote = $lotes->fetch_assoc();
                                        
                                        $apidbp->query("INSERT INTO `ventashotspot`(`Id_Lote`, `FechaVenta`, `Usuario`, `Precio`, `identificador`) VALUES ('".$auxplote['id']."',NOW(),'".$ServerName.'_'.$username."','".$auxplote['precio']."','".$_POST['ref']."')");
                                    }
                                    
                                }
                                
                            }   
                            
                        }  
                        
                    } 
                    
                      // se devuelve la respuesta con código 200 (éxito)
                    if (isset($expirationDate)){
                        
                        if ($contrasena == $username) $response = ['code'=>'10', 'username'=>$username, 'ExpirationDate'=>$expirationDate];
                        
                        else $response = ['code'=>'10', 'username'=>$username,'password'=>$contrasena ,'ExpirationDate'=>$expirationDate];
                        
                    }else{
                        
                        if ($contrasena == $username) $response = ['code'=>'10', 'username'=>$username, 'duration'=>$duration];
                        
                        else $response = ['code'=>'10', 'username'=>$username,'password'=>$contrasena, 'duration'=>$duration];
                        
                    }
                     
                    http_response_code(200); // 200 OK
                    
                    echo json_encode($response);
                    
                }else{
                  // Error, ya hay un user creado con ese nombre de usuario.
                    $response = ['code'=>'00'];
                    
                    http_response_code(400); //Error 400 Bad Request
                    
                    echo json_encode($response);
                    
                }
                
            }else{
                
                if (isset($_POST['username']) && isset($_POST['expirationDay'])){
                    
                    
                    $addedTime = date('d M Y H:i', strtotime( $_POST['expirationDay']." ".$_POST['expirationTime']."+1 hour"));
                    
                    $expirationDate = ((isset($_POST['expirationTime']))? $addedTime : date('d M Y', strtotime($_POST['expirationDay']. '+ 1 Day'))." 0:00");
                    
                    
                    // No añade la hora de más
                     
                    // $expirationDate = ((isset($_POST['expirationTime']))? date('d M Y', strtotime($_POST['expirationDay']))." ".$_POST['expirationTime'] : date('d M Y', strtotime($_POST['expirationDay']. '+ 1 Day'))." 0:00");
                    
                    /*------------------------------------------------------
                    |                                                      |
                    |       HACER UPDATE DE LAS ENTRADAS EN RADIUS         |
                    |                                                      |
                    ------------------------------------------------------*/
                       
                    
                    if ($radcheck = $apidbr->query("UPDATE `radcheck` SET `value` ='".$expirationDate."' WHERE `attribute` = 'Expiration' AND `username` = '".$ServerName."_".$_POST['username']."'")){
                        
                        if (mysqli_affected_rows($apidbr) > 0){
                            
                            $response = ['code'=>'11', 'username'=>$_POST['username'], 'expirationDay' => $expirationDate];
                    
                            http_response_code(200); // 200 OK
                            
                            echo json_encode($response); 
                            
                        }else{
                            
                            $response = ['code'=>'02'];
                        
                            http_response_code(400); //Error 400 Bad Request
                            
                            echo json_encode($response);
                            
                        }
                       
                    }else{
                        
                        $response = ['code'=>'03'];
                    
                        http_response_code(400); //Error 400 Bad Request
                        
                        echo json_encode($response);

                    }
                    
                 }else{
                     
                    $response = ['code'=>'01'];
                    
                    http_response_code(400); //Error 400 Bad Request
                    
                    echo json_encode($response);
                    
                 }
                    
                    
            }

        } else {
          
            $response = ['code'=>'04'];
            
            http_response_code(401); // Error 401: Unauthorized
            
            echo json_encode($response);
            
        }
        
    } else {
        
        $response = ['code'=>'04'];
        
        http_response_code(401); // Error 401: Unauthorized
        
        echo json_encode($response);
        
    }
    
        // Meter log
        
        $apidbp->query("INSERT INTO `apilog` (`fecha`, `ServerName`, `apikey`, `body`, `response`, `codigo`) VALUES (NOW(), '".$ServerName."', '".$headers['Authorization']."', '".json_encode($_POST)."', '".json_encode($response)."', '".$response['code']."')");
        die();
}



