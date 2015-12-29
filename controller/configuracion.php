<?php
if (isLoggedIn()) {
    include_header_file('filtertable');
    $smarty->assign('page', $template_data[1]);
    switch ($template_data[1]) {
        case 'usuarios':
            if (!empty($postparams)) {     
                if (isset($postparams['area_usuario'])) {   //Se va a crear un usuario
                    if (key_exists('nombre', $postparams) && key_exists('email', $postparams)) {
                        $database->query("INSERT INTO `users`(`nombre`, `email`) VALUES ('".$postparams['nombre']."','".$postparams['email']."')");
                        // la contraseña se envia por email o se muestra por pantalla?
                        external_send_mail($postparams['email']);
                    } 
                } elseif (isset ($postparams['area_cliente']) && ($_SESSION['cliente'] == 'admin') && !empty ($postparams['ccliente'])) {   //Sólo los admin pueden añadir grupos y se genera un usuario llamdo admin
                    if (key_exists('ccliente', $postparams)) {
                        $database->query("INSERT INTO `clientes`(`nombre`) VALUES ('".$postparams['ccliente']."')");
                        // la contraseña se envia por email o se muestra por pantalla?
//                        external_send_mail($postparams['cemail']);
                    } 
                } elseif (isset ($postparams['area_local']) && ($_SESSION['cliente'] == 'admin') && !empty ($postparams['lcliente']) && !empty ($postparams['localcliente'])) {
//                    dump($postparams, TRUE);
                    $database->query("INSERT INTO `locales`(`nombre`, `cliente`) VALUES ('".$postparams['lcliente']."','".$postparams['localcliente']."')");
                }
            }
            if ($_SESSION['cliente'] == 'admin') {
                $result = $database->query("SELECT * FROM `clientes`");
                $clientes = array();
                while ($row = $result->fetch_assoc()) {
                    $clientes[]= array($row['id'], $row['nombre']);
                }
                $smarty->assign('cliente', $clientes);
                $result = $database->query("SELECT id, nombre FROM clientes");  //Se selecciona todos los clientes
                $users = array('Id', 'Cliente', 'Accion');    //Se genera el array para la función de smarty que crea la tabla
                $tr = array('id="tabletitle"');    //valor del tr para la funcion smarty que genera la tabla
                while ($row = $result->fetch_assoc()) { //Se rellena el array
                    $tr[]= 'id="row'.$row['id'].'"';
                    foreach ($row as $value) $users[]=$value;
                    $users[]='<input type="button" id="tabletitle" name="editar" value="Editar" /><input type="button" id="tabletitle" name="eliminar" value="Eliminar" />';
                }
                $smarty->assign('clientes', $users);
                $smarty->assign('trcliente', $tr);
                $result = $database->query("SELECT locales.id, locales.nombre, clientes.nombre as cnombre, locales.cliente FROM locales left join clientes on locales.cliente=clientes.id");  //Se selecciona todos los locales
                $users = array('Id', 'Local', 'Cliente', 'Accion');    //Se genera el array para la función de smarty que crea la tabla
                $tr = array('id="tabletitle"');    //valor del tr para la funcion smarty que genera la tabla
                while ($row = $result->fetch_assoc()) { //Se rellena el array
                    $tr[]= 'id="row'.$row['id'].'"';
                    foreach ($row as $key => $value) if($key != 'cliente') $users[]=$value;
                    $users[]='<input type="button" id="tabletitle" name="editar" value="Editar" /><input type="button" id="tabletitle" name="eliminar" value="Eliminar" />';
                }
                $smarty->assign('local', $users);
                $smarty->assign('trlocal', $tr);
            }
            $result = $database->query("SELECT id, nombre, email FROM users");  //Se selecciona todos los usuarios
            $users = array('Id', 'Nombre', 'Email', 'Accion');    //Se genera el array para la función de smarty que crea la tabla
            $tr = array('id="tabletitle"');    //valor del tr para la funcion smarty que genera la tabla
            while ($row = $result->fetch_assoc()) { //Se rellena el array
                $tr[]= 'id="row'.$row['id'].'"';
                foreach ($row as $value) $users[]=$value;
                $users[]='<input type="button" id="tabletitle" name="editar" value="Editar" /><input type="button" id="tabletitle" name="eliminar" value="Eliminar" />';
            }
            $smarty->assign('users', $users);
            $smarty->assign('tr', $tr);
            break;
        case 'permisos':
            if ($_SESSION['cliente'] == 'admin') {  //Si no se es admin no se puede trabajar en este apartado
                $result = $database->query("SELECT id, nombre, email FROM users");  //Se selecciona todos los usuarios
                $users = array();    //Se genera el array para la función de smarty que crea la tabla
                $tr = array();    //valor del tr para la funcion smarty que genera la tabla
                while ($row = $result->fetch_assoc()) { //Se rellena el array
                    $tr[]= 'id="row'.$row['id'].'"';
                    foreach ($row as $value) $users[]=$value;
                }
                $result =$database->query("select permisos.usuario,permisos.cliente,permisos.local, users.id, clientes.nombre as cnombre, clientes.id as cid, locales.nombre as lnombre, locales.id as lid from clientes left join permisos on permisos.cliente = clientes.id left join users on permisos.usuario = users.id left join locales on locales.cliente = clientes.id");   //Se piden todas los clientes y locales con sus permisos
                $permisos = array();
                while ($row = $result->fetch_assoc()) {     //Se monta un  array para con los permisos de cada usuario en cada local, usuario
                    if (!empty($row['local'])) {
                        if ($row['local'] == $row['lid']) $permisos[$row['cnombre']]['locales'][$row['lnombre']]['usuarios'][] = $row['usuario'];    //se añade el usuario que esta
                        $permisos[$row['cnombre']]['id'] = $row['cid'];
                        $permisos[$row['cnombre']]['locales'][$row['lnombre']]['usuarios'] = array_unique($permisos[$row['cnombre']]['locales'][$row['lnombre']]['usuarios']);
                        $permisos[$row['cnombre']]['locales'][$row['lnombre']]['id'] = $row['lid'];  //se pone el id del local
                    } else {
                        if (!empty($row['id'])) {
                            $permisos[$row['cnombre']]['id'] = $row['cliente']; //se pone el id del cliente
                            $permisos[$row['cnombre']]['usuarios'][] = $row['usuario'];
                            $permisos[$row['cnombre']]['usuarios'] = array_unique($permisos[$row['cnombre']]['usuarios']);
                            $permisos[$row['cnombre']]['locales'][$row['lnombre']]['usuarios'] = array_unique($permisos[$row['cnombre']]['locales'][$row['lnombre']]['usuarios']);
                            $permisos[$row['cnombre']]['locales'][$row['lnombre']]['id'] = $row['lid'];  //se pone el id del local
                        } else {
                            $permisos[$row['cnombre']]['id'] = $row['cid'];
                            $permisos[$row['cnombre']]['locales'][$row['lnombre']]['usuarios'] = array_unique($permisos[$row['cnombre']]['locales'][$row['lnombre']]['usuarios']);
                            $permisos[$row['cnombre']]['locales'][$row['lnombre']]['id'] = $row['lid'];  //se pone el id del local
                        }
                    }
                }
                $smarty->assign('users', $users);
                $smarty->assign('permisos', $permisos);
                $smarty->assign('id', (empty($postparams['user']))?-1:$postparams['user']); //Si no hay usuario seleccionado el valor es -1
                $smarty->assign('tr', $tr);
                break;
            } else {
                header('Location: '.DOMAIN);
                die();
            }
        case 'menu':
            if ($_SESSION['cliente'] == 'admin') {
                if (!empty($postparams)) {
                    $database->query("ALTER TABLE `users` ADD `menu_".  strtolower($postparams['table_name'])."` INT(1) NOT NULL DEFAULT '0' ;");
                }
                $result = $database->query("SELECT * FROM users");
                $out = array();
                while ($aux = $result->fetch_assoc()) $out[] = $aux;
                $menu = array();
                foreach ($out as $value) {
                    $aux1 = array();
                    foreach ($value as $key => $item) if ((substr($key, 0, 5) == 'menu_') || ($key == 'nombre') || ($key == 'id') || ($key == 'email')) $aux1[ucwords((substr($key, 0, 5) == 'menu_')?  substr($key, 5):$key)] = $item;
                    $menu[]= $aux1;
                }
                if (count($menu)>0) {
                    $cols = implode(', ', array_keys($menu[0]));
                    foreach ($menu as $value) {
                        foreach ($value as $key => $item) {
                            $table[]=  ($key != 'Id' && $key != 'Nombre' && $key != 'Email') ? '<input type="checkbox" name="check" class="check_menu" data-menu="'.$key.'" data-id="'.$value['Id'].'" value="ON" '.($item == 1 ?'checked="checked"':'').'/>' : $item; //Aqui se pone el checkbox en vez del item
                        }
                    }
                    $smarty->assign('cols', $cols);
                    $smarty->assign('users', $table);
                }
                //ALTER TABLE `users` ADD `menu_configuracion_menu` INT(1) NOT NULL DEFAULT '0' ;
                break;
            } else {
                header('Location: '.DOMAIN);
                die();
            }
        case 'hotspots':
            if ($_SESSION['cliente'] == 'admin') {
                if (!empty($postparams)) {
                    $database->query('INSERT INTO `hotspots`(`ServerName`, `SerialNumber`, `Status`, `Local`, `Informe`,`si`) VALUES ("'.$postparams['hot_name'].'","'.$postparams['hot_number'].'","'.$postparams['hot_status'].'","'.$postparams['hot_local'].'","'.$postparams['hot_informe'].'",'.((empty($postparams['hot_s']))?'NULL':'"'.$postparams['hot_s'].'"').')');
                    $radius->query('INSERT INTO `radgroupcheck`(`groupname`, `attribute`, `op`, `value`) VALUES ("'.$postparams['hot_name'].'","Called-Station-Id","==","'.$postparams['hot_name'].'")');
                    $radius->query("INSERT INTO `radius`.`radgroupreply` (`groupname`, `attribute`, `op`, `value`) VALUES ('".$postparams['hot_name']."', 'Acct-Interim-Interval', ':=', '600')");
                }
                $si = new mysqli('217.125.25.165', 'servibyte', 'sbyte_15_Mxz', 'simpleinvoices', 8092);
                $result = $si->query("SELECT id, name FROM `si_customers`");
                $siout = array();
                while ($aux = $result->fetch_assoc()) $siout[] = $aux;
                $result = $database->query("SELECT hotspots.*, locales.nombre as 'Nombre Local' FROM hotspots INNER JOIN locales ON hotspots.Local = locales.id ORDER BY `hotspots`.`id` ASC");
                $out = array();
                while ($aux = $result->fetch_assoc()) $out[] = $aux;
                $menu = array();
                foreach ($out as $value) foreach ($value as $key => $item) {
                    $menu[]=$item;
                    if ($key == 'si') {
                        $found = false;
                        foreach ($siout as $elem) {
                            if ($elem['id'] == $item) {
                                $menu[]=$elem['name'];    //añadir el nombre del cliente a la tabla
                                $found = TRUE;
                            }
                        }
                        if (!$found) $menu[]="";
                    }
                }
                $result = $database->query('SELECT locales.*, clientes.nombre as cnombre FROM locales LEFT JOIN clientes ON clientes.id = locales.cliente');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = array($aux['id'],$aux['cnombre'].'.'.$aux['nombre']);
                $smarty->assign('si', $siout);
                $smarty->assign('local', $locales);
                $smarty->assign('cols', implode(', ', array_keys($out[0])).',NombreCliente');
                $smarty->assign('hotspot', $menu);
                break;
            } else {
                header('Location: '.DOMAIN);
                die();
            }
        case 'perfiles':
            if ($_SESSION['cliente'] == 'admin') {
                if (!empty($postparams)) {
                    $sql='INSERT INTO `perfiles`(`Id_hotspot`, `Descripcion`, `Duracion`, `Movilidad`, `ServerName`, `ModoConsumo`, `Acct-Interim-Interval`, `Idle-Timeout`, `Simultaneous-Use`, `Login-Time`, `Expiration`, `WISPr-Bandwidth-Max-Down`, `WISPr-Bandwidth-Max-Up`, `TraficoDescarga`, `Password`) VALUES (';
                    for ($index = 0; $index < 15; $index++) $sql.='"'.((!empty($postparams['per_'.$index]))?$postparams['per_'.$index]:'').'",';
                    $sql = substr($sql, 0, -1).')';
                    $database->query($sql);
                }
                load_modul('datepicker');
                $result = $database->query("SELECT * FROM perfiles");
                $out = array();
                while ($aux = $result->fetch_assoc()) $out[] = $aux;
                $menu = array();
                foreach ($out as $value) foreach ($value as $item) $menu[]=$item;
                $result = $database->query('SELECT id, ServerName FROM `hotspots`');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = $aux;
                $smarty->assign('local', $locales);
                $smarty->assign('cols', implode(', ', array_keys($out[0])));
                $smarty->assign('perfiles', $menu);
                break;
            } else {
                header('Location: '.DOMAIN);
                die();
            }
        case 'lotes':
            if ($_SESSION['cliente'] == 'admin') {
                if (!empty($postparams)) {
                    $database->query('INSERT INTO `lotes`(`Id_perfil`, `Duracion`, `Costo`, `Precio`) VALUES ("'.$postparams['lot_Id_perfil'].'", "'.$postparams['lot_duration'].'", "'.$postparams['lot_costo'].'", "'.$postparams['lot_precio'].'")');
                }
                $result = $database->query("SELECT lotes.*, perfiles.ServerName, perfiles.Descripcion FROM lotes INNER JOIN  perfiles ON lotes.Id_perfil = perfiles.id");
                $out = array();
                while ($aux = $result->fetch_assoc()) $out[] = $aux;
                $menu = array();
                foreach ($out as $value) foreach ($value as $item) $menu[]=$item;
                $result = $database->query('SELECT id, CONCAT(ServerName," - " ,Descripcion) AS ServerName, Duracion FROM `perfiles`');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = $aux;
                $smarty->assign('local', $locales);
                $smarty->assign('cols', implode(', ', array_keys($out[0])));
                $smarty->assign('lotes', $menu);
                break;
            } else {
                header('Location: '.DOMAIN);
                die();
            }
        default:
            break;
    }
} else {
    header('Location: '.DOMAIN);
}
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

