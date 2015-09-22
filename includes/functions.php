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
                } else {
                    // If no function and page is found send 404 code
                    header('Location: http://servibyte.net/404.html');
                }
            }
        } else {
            header('Location: '.DOMAIN.'/main');
            die();
        }
    }
    return $get_values;
}

function get_subdoamin() {
    global $database;
    $subdomain = strstr($_SERVER['SERVER_NAME'], '.servibyte.net', TRUE);   //se extrae la parte delante de subdomain si no hay .servinet se devuelve false
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
            header('Location: http://servibyte.net/404.html');
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
function external_send_mail($correo = NULL){
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
        $pass = substr(md5(time()), 3, 6);
        $mail->msgHTML(utf8_decode('Contraseña generada:<br>'.$pass));
        if($mail->send()) {
            echo 'Se le ha enviado el correo con la nueva contraseña';
            $database->query("UPDATE users SET pass=MD5('$pass') WHERE email='".$correo."'");
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
function external_upload_logo() {
    global $fulldomain;
    file_put_contents($fulldomain.'/testo', print_r($_POST, TRUE));
    foreach ($_FILES as $file) {
        if (move_uploaded_file($file['tmp_name'], $fulldomain.'/images/logos/'.(($_POST['local'])?strtolower($_POST['local']).'.':'').strtolower($_POST['nombre']).'.png')) die();
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
        if ($database->query('ALTER TABLE `users` DROP `'.$_POST['menu'].'`;'))die();
    }
}
function external_guardar_hotspot(){
    if ((!empty($_POST['id'])) && (!empty($_POST['name'])) && (!empty($_POST['number'])) && (!empty($_POST['status'])) && (!empty($_POST['local'])) && (!empty($_POST['informe'])) && (!empty($_POST['si']))) {
        global $database;
        global $radius;
        if ($_POST['action'] == 1) {
            if ($database->query('DELETE FROM `hotspots` WHERE id="'.$_POST['id'].'"')) {
                if ($radius->query('DELETE FROM `radgroupcheck` WHERE `groupname` = "'.$_POST['local'].'" AND `value`= "'.$_POST['name'].'"')) die();
            }
        } else {
            $temporal = $database->query('SELECT * FROM hotspots WHERE id = "'.$_POST['id'].'"');
            $aux = $temporal->fetch_assoc();
            if ($database->query('UPDATE `hotspots` SET `ServerName`="'.$_POST['name'].'",`SerialNumber`="'.$_POST['number'].'",`Status`="'.$_POST['status'].'",`Local`="'.$_POST['local'].'",`Informe`="'.$_POST['informe'].'",`si`='.(($_POST['si']=='Cliente')?"NULL":'"'.$_POST['si'].'"').' WHERE id="'.$_POST['id'].'"')) {
                if ($radius->query('UPDATE `radgroupcheck` SET `groupname` = "'.$_POST['local'].'", `value`= "'.$_POST['name'].'" WHERE groupname="'.$aux['Local'].'" AND value = "'.$aux['ServerName'].'"')) die();
            }
        }
    }
}
function external_guardar_perfil() {
    global $database;
    if ($_POST['action']== 1) {
        if ($database->query('DELETE FROM perfiles WHERE Id = '.$_POST['modal_perfilid'])) die();
    } elseif ($_POST['action']== 0) {
        if ($database->query('UPDATE `perfiles` SET `Id_hotspot`="'.$_POST['per_0'].'",`ServerName`="'.$_POST['per_1'].'",`Descripcion`="'.$_POST['per_2'].'",`Duracion`="'.$_POST['per_3'].'",`Movilidad`="'.$_POST['per_4'].'",`ModoConsumo`="'.$_POST['per_5'].'",`Acct-Interim-Interval`="'.$_POST['per_6'].'",`Idle-Timeout`="'.$_POST['per_7'].'",`Simultaneous-Use`="'.$_POST['per_8'].'",`Login-Time`="'.$_POST['per_9'].'",`Expiration`="'.$_POST['per_10'].'",`WISPr-Bandwidth-Max-Down`="'.$_POST['per_11'].'",`WISPr-Bandwidth-Max-Up`="'.$_POST['per_12'].'",`TraficoDescarga`="'.$_POST['per_13'].'",`Password`="'.$_POST['per_14'].'" WHERE id = '.$_POST['modal_perfilid'])) die ();
    }
}
function external_guardar_lote() {
    global $database;
    if ($_POST['action']== 1) {
        if ($database->query('DELETE FROM lotes WHERE Id = '.$_POST['modal_Id'])) die();
    } elseif ($_POST['action']== 0) {
        if ($database->query('UPDATE `lotes` SET `Id_perfil`="'.$_POST['modal_Id_perfil'].'",`Duracion`="'.$_POST['modal_Duracion'].'",`Costo`="'.$_POST['modal_Costo'].'",`Precio`="'.$_POST['modal_Precio'].'" WHERE `Id`='.$_POST['modal_Id'])) die ();
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
        $contrasena = (empty($_POST['password'])?usuario_aleatorio('CVCVCVNN', 8):$_POST['password']);
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
                                    $radius->query("INSERT INTO `radcheck`( `username`, `attribute`, `op`, `value`) VALUES ('".$_POST['servername'].'_'.$usuario."','".(($elem == 'Continuo')?'One-All-Session':'Max-All-Session')."',':=','".$_POST['duracion']."')");      //Continuo hay dos tipos?
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
        //MOISESSSSSSSSSS linea para que pongas lo que quieras donde el print_r y que se guarde en un fichero
        //file_put_contents($fulldomain.'/ticketrad', print_r($_POST, true));    
        
        echo "user=$usuario&pass=$contrasena";
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
			<img src="http://servibyte.net/images/logo.png">
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
            if ($database->query("UPDATE `gastos` SET `hotspot`=".$_POST['hotspot'].",`cantidad`=".$_POST['cantidad'].",`Descripcion`='".$_POST['Descripcion']."',`precio`=".$_POST['precio']." WHERE `id`=".$_POST['id'])) die();
        }
    }
}
function external_informepdf(){
    if (isset($_GET['id']) && isset($_GET['fecha'])) {
        global $database;
        $result = $database->query("SELECT * FROM `historial` WHERE `id`='".$_GET['id']."' AND `fecha`='".$_GET['fecha']."'");
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
            pdf($in, $hotspot, TRUE, spanish(date('F', strtotime('- 1 month',strtotime($_GET['fecha'])))));
        }
        die();
    }
}

function external_guardar_bloc(){
    if (isset($_POST['nombre']) && isset($_POST['descripcion']) && isset($_POST['id'])) {
        global $database;
        $database->query('UPDATE `blocs` SET `nombre`="'.$_POST['nombre'].'",`descripcion`="'.$_POST['descripcion'].'" WHERE `id`='.$_POST['id']);
        die();
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
                        $database->query("INSERT INTO `ventashotspot`(`Id_Lote`, `FechaVenta`, `Usuario`, `Precio`, `identificador`) VALUES ('".$lote['Id']."',NOW(),'".$perfil['ServerName'].'_'.$aux['user']."','".$lote['Precio']."','Ticket $count del Bloc')");
                    }   
                }  
            }
        }
        $database->query("DELETE FROM `bloc_usuarios` WHERE `bloc_id`= ".$_POST['id']);
        $database->query("DELETE FROM `blocs` WHERE `id`=".$_POST['id']);
        die();
    }  
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
 * 0= Carac May, min y num
 * 1= carac may, min
 * 2= Carac May
 * 3= Carac min
 * 4= num
 * 5= Carac min y num
 * 6= Carac May y num
 * @param type $tipoafab
 * @param type $lon
 * @return array
 */
function usuario_aleatorio($tipoafab, $lon= NULL) {
    $alfabetos= array(
        "T" => array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"), 
        "A"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),
        "M"=>array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"),
        "m"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"),
        "N"=>array("0","1","2","3","4","5","6","7","8","9"),
        "b"=>array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","1","2","3","4","5","6","7","8","9"),
        "B"=>array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"),
        "V"=>array("A", "E", "I", "O", "U"),
        "v"=>array("a", "e", "i", "o", "u"),
        "C"=>array("B","C","D","F","G","H","J","K","L","M","N","P","Q","R","S","T","V","W","X","Y","Z"),
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
    $x = $pdf->GetY();
    $x+=12;
    $pdf->SetY($x);
    $pdf->Cell(35, 5, 'IGIC %', 1,0, 'C');
    $pdf->Cell(35, 5, '7%', 1,0, 'C');
    $pdf->SetX(100);
    $pdf->Cell(35, 5, '% Comision', 0,0, 'R');
    $pdf->Cell(35, 5, "$comision%", 1,0, 'C');
    $subtotal  = ($total['Tickets'] - $total['Gastos'])*($comision/100);
    $pdf->Cell(35, 5, number_format($subtotal, 2,',','.').  chr(128), 1,1, 'C');
    $subtotal+=$total['Gastos'];
    $sinigic = (($subtotal*100)/107);
    $pdf->Cell(35, 5, 'Total sin IGIC', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($sinigic, 2,',','.').chr(128), 1,0, 'C');
    $pdf->SetX(100);
    $pdf->Cell(35, 5, 'Gastos', 0,0, 'R');
    $pdf->Cell(35, 5, ' ', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($total['Gastos'], 2,',','.').chr(128), 1,1, 'C');
    $pdf->Cell(35, 5, 'IGIC', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($sinigic*0.07, 2,',','.').chr(128), 1,0, 'C');
    $pdf->SetX(135);
    $pdf->Cell(35, 5, 'TOTAL A PAGAR', 0,0, 'R');
    $pdf->Cell(35, 5, number_format($subtotal, 2,',','.').chr(128), 1,1, 'C');
    $pdf->Cell(35, 5, 'TOTAL', 1,0, 'C');
    $pdf->Cell(35, 5, number_format($subtotal, 2,',','.').chr(128), 1,1, 'C');
    return $subtotal;
}
function pdf($in, $local, $print = false, $mes = FALSE) {
    global $fulldomain;
    require $fulldomain.'/scripts/fpdf/fpdf.php';
    global $suma;
    global $database;
    $suma= array();
    $totalfin = array();
    $pdf = new FPDF();
    $pdf->AddPage('P', 'A4');
    $pdf->SetFont('Arial', 'I', 14);
    $pdf->SetTextColor(0);
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
        cabecera($pdf, $x, $value['cantidad'], $duracion['Descripcion'], $value['precio']);
    }
    $totalfin['Tickets'] = subtotal($pdf, 'Tickets');
    $factura = cierreinforme($pdf, $totalfin, 50);
    $out = array();
    foreach ($in as $key => $value) {
        if ($value['cantidad'] !=  count($value['usuario'])) {
            foreach ($value['usuario'] as $item) {
                if (strlen($item) != 8) {
                    $lote = $database->query("SELECT perfiles.Descripcion FROM lotes INNER JOIN perfiles ON perfiles.id = lotes.Id_perfil WHERE lotes.id = $key");
                    $duracion = $lote->fetch_assoc();
                    $out[]= strstr($item, ' ', TRUE)." -  ".$duracion['Descripcion'];
                }
            }
        }
    }
    if (count($out) > 0) {
        $pdf->Cell(30,5,utf8_decode('Relación de Tickets Anulados:'),0,1,'L');
        foreach ($out as $value) {
            $pdf->SetX(30);
            $pdf->Cell(30,5,$value,0,1,'L');
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
    $mysqli = new mysqli('83.56.10.172', 'servibyte', 'sbyte_15_Mxz', 'simpleinvoices', 8092); 
    if ($mysqli->query("INSERT INTO `si_invoices`(`index_id` ,`biller_id`, `customer_id`, `type_id`, `preference_id`, `date`)  SELECT MAX(`index_id`)+1 ,'1', '".$pdf[2]['si']."', '2', '1', NOW() FROM `si_invoices`")) {
        if ($mysqli->query("INSERT INTO `si_invoice_items`(`invoice_id`, `quantity`, `product_id`, `unit_price`, `tax_amount`, `gross_total`, `description`, `total`) SELECT MAX(`index_id`) ,1,3,".number_format((($pdf[1]*100)/107), 2,'.','.').",".number_format((($pdf[1]*100)/107)*0.07, 2,'.','.').",".number_format((($pdf[1]*100)/107), 2,'.','.').",'Mes de ".spanish(date('F'))."',".number_format($pdf[1], 2,'.','.')." FROM `si_invoices`")) {
            if ($mysqli->query("INSERT INTO `si_invoice_item_tax`(`invoice_item_id`, `tax_id`, `tax_type`, `tax_rate`, `tax_amount`) SELECT MAX(`id`) ,1,'%',7,".number_format((($pdf[1]*100)/107)*0.07, 2,'.','.')." FROM `si_invoice_items`")) {
                $ok = file_get_contents('http://83.56.10.172:8091/access.php?info=a');
                if ($ok == 'done') {
                    $result = $mysqli->query("SELECT MAX(`index_id`) as idd FROM `si_invoices`");
                    $id = $result->fetch_assoc();
                    $get=file_get_contents('http://83.56.10.172:8091/index.php?module=export&view=invoice&id='.$id['idd'].'&format=pdf');
                    file_put_contents('Factura '.$pdf[0], $get);
                    file_get_contents('http://83.56.10.172:8091/access.php?info=c');
                    return $pdf;
                }
            }
        }
    }
}
function enviaemail($pdf) {
    global $fulldomain;
    require 'scripts/phpmailer/PHPMailerAutoload.php';
    $mysqli = new mysqli('83.56.10.172', 'servibyte', 'sbyte_15_Mxz', 'simpleinvoices', 8092); 
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

