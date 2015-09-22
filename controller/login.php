<?php
if (isset($postparams['username']) && isset($postparams['userpass']) && isset($postparams['submit'])) {
    //Se ha hecho login
    $result = $database->query((isset($_SESSION['local']))?"SELECT users.* FROM `users` LEFT JOIN permisos ON users.id = permisos.usuario LEFT JOIN locales ON permisos.local = locales.id LEFT JOIN clientes ON permisos.cliente = clientes.id WHERE users.nombre = '".$postparams['username']."' AND users.pass = MD5('".$postparams['userpass']."') AND clientes.nombre = '".$_SESSION['cliente']."' AND locales.nombre = '".$_SESSION['local']."'":"SELECT users.*, permisos.*, clientes.* FROM `users` LEFT JOIN permisos ON users.id = permisos.usuario LEFT JOIN locales ON permisos.local = locales.id LEFT JOIN clientes ON permisos.cliente = clientes.id WHERE users.nombre = '".$postparams['username']."' AND users.pass = MD5('".$postparams['userpass']."') AND clientes.nombre = '".$_SESSION['cliente']."' AND locales.nombre IS NULL");
    if ($result->num_rows > 0) {
	//Hay resultado
	$aux = $result->fetch_assoc();
        $database->query("UPDATE users SET ip='".$_SERVER['REMOTE_ADDR']."' WHERE id = ".$aux['id']);
        $_SESSION['isLoggedIn'] = true;
        $_SESSION['user']=$postparams['username'];
        $menu = array();
        foreach ($aux as $key => $value) {
            if (strstr($key, 'menu_') && $value) {
                if (substr_count($key, '_') > 1) {
                    $menu[strstr(substr(strstr($key, '_'), 1),'_', TRUE)][]= substr(strstr(substr(strstr($key, '_'), 1),'_'), 1);
                } else {
                    $menu[substr(strstr ($key, '_'),1)]=array();
                }
            }
        }
        $_SESSION['menu']=$menu;
        header('Location: '.DOMAIN.'/inicio');
    } else {
        $smarty->assign('err_msg', 'Usuario y contraseña incorrecta<br><a href="/contrasena">Olvidé mi contraseña</a>');
    }
}
