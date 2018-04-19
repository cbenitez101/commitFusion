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

/* SET TIMEZONE */
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
        if ($result = $apidbp->query("SELECT * FROM hotspots WHERE apikey='".$headers['Authorization']."'"));  
        
        /*---------------------------------------------------------------
                    FIN OBTENCION API KEY Y DATOS HOTSPOT
        -----------------------------------------------------------------*/
        
        // Si se encuentra el usuario por su APIKEY procesamos el body de la petición, accediendo a los
        // campos que se nos envían
        if ($result->num_rows > 0){
            
            $aux = $result->fetch_assoc();
            
            $idHotspot = $aux['id'];
            
            $ServerName = $aux['ServerName'];
            
            /*---------------------------------------------------------------
                                COMIENZO OPERACIONES
            -----------------------------------------------------------------*/
            
            // Si tenemos los campos necesarios, procedemos a crear el ticket
            if (isset($_POST['profileid']) && isset($_POST['ref']) && !isset($_POST['username'])){
                
                // Obtenemos perfil mediante el id que nos pasan en el body de la peticion. Si nos faltan datos, los cogeremos del perfil   
                $result4 = $apidbp->query("SELECT * FROM `perfiles` WHERE id = '".$_POST['profileid']."'");
                
                $aux4 = $result4->fetch_assoc();
                   
                // Cálculo de la fecha de expiración. Si nos dan hora, se pone el expiration con la fecha y hora dadas. Si no nos mandan la hora ponemos el expirationTime a las 0:00 horas del dia siguiente.
                if (isset($_POST['expirationDay'])) {
                    
                    $expirationDate = ((isset($_POST['expirationTime']))? date('d M Y', strtotime($_POST['expirationDay']))." ".$_POST['expirationTime'] : date('d M Y', strtotime($_POST['expirationDay']. '+ 1 Day'))." 0:00");
                    
                } else{ // En caso de no pasarnos hora, cogeremos el Expiratio y/o duration del perfil
                    
                    if ($aux4['Expiration'] !== '0000-00-00') $expirationDate = $aux4['Expiration'];
                    
                    else $duration = $aux4['Duracion']; // En caso contrario utilizaremos el expiration o la duracion del profile
                    
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
                    
                    if ($aux4['userformat'] !== '') {   // Si el campo usuario no esta vacio se crea el usuario con dicho formato
                        
                        $username = usuario_aleatorio($aux4['userformat']);
                        
                        if ($aux4['Password'] == 'usuario'){    // Si el password es 'usuario', tendrá el mismo valor que el usuario
                            
                            $contrasena = $username;
                            
                        }else{
                            
                            $contrasena =  usuario_aleatorio($aux4['Password']); // Si no pone 'usuario', generamos la contraseña con el patrón guardado 
                            
                        }
                        
                    } else { // Si el formato de usuario está vacio, se genera un usuario con el formato 'CVCVCVNN'
                        
                        $username = usuario_aleatorio('CVCVCVNN');
                        
                        if ($aux4['Password'] == 'usuario'){
                            
                            $contrasena = $username;
                            
                        }else{
                            
                            $contrasena = usuario_aleatorio($aux4['Password']);
                            
                        }
                    }

                }
                
                // Se comprueba que no exista el usuario ya creado con anterioridad
                $resul2 = $apidbr->query("SELECT * FROM `radusergroup` WHERE `username` = '".$ServerName.'_'.$contrasena."'");
                
                $resul3 = $apidbr->query("SELECT * FROM `radcheck` WHERE `username` = '".$ServerName.'_'.$contrasena."'");
            
                // if ($database->query('INSERT INTO `lotes`(`Id_perfil`, `Duracion`, `Costo`, `Precio`) VALUES ("'.$_POST['id_perfil'].'", "'.$_POST['duracion'].'", "'.$_POST['costo'].'", "'.$_POST['precio'].'")')) die();

                
                // Si no existe el usuario procedemos a crear las entradas necesarias en el radius.
                if ($resul2->num_rows == 0 && $resul3->num_rows == 0 ){
                    
                    // Introducimos valores necesarios en el radius para crear y habilitar el nuevo ticket
                    
                    if ($apidbr->query("INSERT INTO `radusergroup`(`username`, `groupname`, `priority`) VALUES ('".$ServerName.'_'.$username."','".$ServerName."',1)")) {
                        
                        if ($apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','Cleartext-Password',':=','$contrasena')")) {
                            
                            if ($apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','".$aux4['Movilidad']."','==','".$ServerName."')")) {
                            
                                if (isset($duration)) $apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','".$aux4['ModoConsumo']."',':=','".$duration."')");
                            
                                if (isset($expirationDate)) $apidbr->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$ServerName.'_'.$username."','Expiration',':=','".$expirationDate."')");
                                
                                if ($result6 = $apidbp->query("SELECT id, precio FROM `lotes` WHERE Id_perfil = ".$_POST['profileid'])){
                                    
                                    if ($result6->num_rows > 0){
                                    
                                        $aux6 = $result6->fetch_assoc();
                                        
                                        $apidbp->query("INSERT INTO `ventashotspot`(`Id_Lote`, `FechaVenta`, `Usuario`, `Precio`, `identificador`) VALUES ('".$aux6['id']."',NOW(),'".$ServerName.'_'.$username."','".$aux6['precio']."','".$_POST['ref']."')");
                                    }
                                    
                                }
                                
                            }   
                            
                        }  
                        
                    } 
                    
                      // se devuelve la respuesta con código 200 (éxito)
                    if (isset($expirationDate)){
                        
                        if ($contrasena == $username) $response = ['code'=>'10', 'username'=>$username, 'ExpirationDate'=>$expirationDate];
                        
                        else $response = ['code'=>'10', 'username'=>$username, 'ExpirationDate'=>$expirationDate];
                        
                    }else{
                        
                        if ($contrasena == $username) $response = ['code'=>'10', 'username'=>$username, 'duration'=>$duration];
                        
                        else $response = ['code'=>'10', 'username'=>$username, 'duration'=>$duration];
                        
                    }
                     
                    http_response_code(200);
                    
                    echo json_encode($response);
                    
                }else{
                  // Error, ya hay un user creado con ese nombre de usuario.
                    $response = ['code'=>'00'];
                    
                    http_response_code(400);
                    
                    echo json_encode($response);
                    
                }
                
            }else{
                
                if (isset($_POST['username']) && isset($_POST['expirationDay'])){
                     
                    $expirationDate = ((isset($_POST['expirationTime']))? date('d M Y', strtotime($_POST['expirationDay']))." ".$_POST['expirationTime'] : date('d M Y', strtotime($_POST['expirationDay']. '+ 1 Day'))." 0:00");
                    
                    /*------------------------------------------------------
                    |                                                      |
                    |       HACER UPDATE DE LAS ENTRADAS EN RADIUS         |
                    |                                                      |
                    ------------------------------------------------------*/
                       
                    // $database3= new mysqli('localhost', 'radiususer', 'Pwp+*f2b', 'radius');
                    
                    if ($result5 = $apidbr->query("UPDATE `radcheck` SET `value` ='".$expirationDate."' WHERE `attribute` = 'Expiration' AND `username` = '".$ServerName."_".$_POST['username']."'")){
                        
                        if (mysqli_affected_rows($apidbr) > 0){
                            
                            $response = ['code'=>'11', 'username'=>$_POST['username'], 'expirationDay' => $expirationDate];
                    
                            http_response_code(200);
                            
                            echo json_encode($response); 
                            
                        }else{
                            
                            $response = ['code'=>'02'];
                        
                            http_response_code(400);
                            
                            echo json_encode($response);
                            
                        }
                       
                    }else{
                        
                        $response = ['code'=>'03'];
                    
                        http_response_code(400);
                        
                        echo json_encode($response);

                    }
                    
                 }else{
                     
                    $response = ['code'=>'01'];
                    
                    http_response_code(400);
                    
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



