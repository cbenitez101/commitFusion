<?php
if (isLoggedIn()) {
    $smarty->assign('page', $template_data[1]);
//            include_header_file('filtertable');
    load_modul('datatable');
    // dump($template_data);
    switch ($template_data[1]) {
        case 'dispositivos':
            if ($_SESSION['cliente'] == 'admin') {
                if (!empty($template_data[2])) {
                    
                    $result = $database->query("SELECT syslog.*, dispositivos.notas, dispositivos.tipo, dispositivos.habilitado, hotspots.ServerName, dispositivos.id as dispid FROM `dispositivos` INNER JOIN hotspots ON dispositivos.id_hotspot = hotspots.id INNER JOIN syslog ON hotspots.ServerName = syslog.local WHERE dispositivos.id_hotspot='".$template_data[2]."' AND (dispositivos.descripcion = syslog.dispositivo OR syslog.dispositivo = 'hotspot') GROUP BY id");
                
                    $out = array();
                    if ($result->num_rows > 0) {
                        $keys = array("id","estado","habilitado","fecha", "ip", "dispositivo", "notas");
                        while ($aux = $result->fetch_assoc()) {
                            $hotspot = $aux['ServerName'];
                            if (isset($aux['info'])) foreach (json_decode($aux['info'], true) as $key => $value) if (!in_array($key, $keys)) $keys[] = $key;
                            $out[] = $aux;
                        }
                        //$keys[]='hablilitado';
                        
                        //$keys[]='hablilitado';
                        $out1 = array();
                        foreach ($out as $value) {
                            $aux1 = array('id'=> ((empty($value['dispid']))?0:$value['dispid']),'estado' => '<button type="button" class="btn btn-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"danger":"success").' btn-circle"><i class="fa fa-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"times":"check").'"></i>','habilitado'=>(($value['dispositivo'] != 'hotspot')?'<input class="checkhabilitado" id="habilitado-'.$value['dispid'].'" type="checkbox"'.(($value['habilitado'])?" checked":"").'>':''),'fecha' => $value['fecha'], "ip"=> $value['ip'], "dispositivo" => $value['dispositivo'], "notas" => $value['notas']);
                            if (isset($value['info'])) {
                                $aux2 = json_decode($value['info'], true);
                                foreach ($keys as $value1) if (($value1 != "id") && ($value1 != "estado") && ($value1 != "fecha") && ($value1 != "ip") && ($value1 != "dispositivo") && ($value1 != "notas") && ($value1 != "habilitado")) $aux1[$value1] = ((array_key_exists($value1, $aux2))?$aux2[$value1]:"");
                                //$aux1['hablilitado'] = '<button type="button" class="btn btn-success btn-circle"><i class="fa fa-check"></i>';
                                //<span class="dispositivos-'.(($value['dispositivo'] == "hotspot")?((array_key_exists('connected', json_decode($value['info'], true)))?"hotspotw":"hotspot"):$value['tipo']).'-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"off":"on").'" />
                                $out1[] = $aux1;
                            }
                        }
                        $menu = array();
                        foreach ($out1 as $value) foreach ($value as $item) $menu[] = $item;
                        $smarty->assign('server', $hotspot);
                    }
                    
                    /**
                     * Parte para permittir quitar los hotspots cuando no tienen antenas. Se cambia levemente la quiery par asolo obtener los de tipo 'ap', sin contar los hotspots propiamente dichos.
                    */
                    $resultado = $database->query("SELECT hotspots.id, (SELECT COUNT(*) FROM syslog WHERE local = hotspots.ServerName AND fecha > '".date("Y-m-d H:i:s", strtotime("-30 min"))."' AND (dispositivo IN (SELECT descripcion FROM dispositivos WHERE habilitado = 1 AND id_hotspot = hotspots.id AND tipo = 'ap'))) as activos FROM `hotspots` LEFT JOIN dispositivos ON dispositivos.id_hotspot = hotspots.id WHERE hotspots.id=".$template_data[2]." GROUP BY hotspots.id");
                    /**
                     * Contamos los dispositivos activos de tipo AP. Devolvemos variable $noactivos que está a TRUE si no hay dispositivos activos y FALSE en caso contrario.
                     * En el caso de que no hayan dispositivos activos de tipo AP, mostramos un botón que nos premite eliminar el hotspot [FALTA MIRAR CON RUBÉN].
                    */
                    $noactivos = TRUE;
                    $out2 = array();
                    if ($resultado->num_rows > 0) {
                        while ($aux2 = $resultado->fetch_assoc()){
                            if ($aux2['dispositivos'] > 1) $aux2['dispositivos']++;
                            $out2 = $aux2;
                        } 
                        if ($out2['activos'] > 0) $noactivos = FALSE;
                    }
                    //noactivos se utiliza para saber si no tenemos disp activos en el hotspot para mostrar el boton de elimina
                    $smarty->assign('noactivos', $noactivos);
                    $smarty->assign('cols', $keys);
                    $smarty->assign('dispositivos', $menu);
                } else {    
                    
                    $result = $database->query("SELECT hotspots.id ,hotspots.ServerName, COUNT(*) AS dispositivos, (SELECT COUNT(*) FROM syslog WHERE local = hotspots.ServerName AND fecha > '".date("Y-m-d H:i:s", strtotime("-30 min"))."' AND (dispositivo IN (SELECT descripcion FROM dispositivos WHERE habilitado = 1 AND id_hotspot = hotspots.id))  OR (dispositivo = 'hotspot' AND local = hotspots.ServerName)) as activos FROM `hotspots` LEFT JOIN dispositivos ON dispositivos.id_hotspot = hotspots.id GROUP BY hotspots.id");
                   
                    // Cuando entra un admin, se muestran todos los hotspot para que elija uno para ver en profuncidad, pero al entrar otro usuario solo ve sus hotspots sin posiblidad de escoger la antena. Para que el admin vea el hotspot al elegir una entra en la pagina siguiente dispositivos/id_hotspot
                    $out = array();
                    if ($result->num_rows > 0) {
                        while ($aux = $result->fetch_assoc()){
                            if ($aux['dispositivos'] > 1) $aux['dispositivos']++;
                            $out[] = $aux;
                        } 
                        $menu = array();
                        foreach ($out as $value) foreach ($value as $key => $item) $menu[] = $item;
                        // $smarty->assign('dispositivos', $menu);
                        // $smarty->assign('cols', implode(', ', array_keys($out[0])));
                    }
                    $smarty->assign('dispositivos', $menu);
                    $smarty->assign('cols', implode(', ', array_keys($out[0])));
                }
                $result = $database->query('SELECT id, ServerName FROM hotspots');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = array($aux['id'],$aux['ServerName']);
                $smarty->assign('hotspot', $locales);
            } else {
                header('Location: '.DOMAIN);
                die();
            }
            break;
            
        /** 
         * Servicios: Mostramos otros dispositivos que no sean hotspots organizados por locales (servicios). Permite añadir otros
         * dispositivos como TPV
        */
        case 'servicios':
            if ($_SESSION['cliente'] == 'admin') {
                if (!empty($template_data[2])) {
                    /**
                     * Básicamente se trata el servicio como si fuera un hotspot. Al seleccionar el servcio, muestra todos los
                     * dispositivos dependienes de ese servicio o local
                    */
                    $result = $database->query("SELECT syslog.*, dispositivos.notas, dispositivos.tipo, dispositivos.habilitado, servicios.ServerName, dispositivos.id as dispid FROM `dispositivos` INNER JOIN servicios ON dispositivos.id_servicio = servicios.id INNER JOIN syslog ON servicios.ServerName = syslog.local WHERE dispositivos.id_servicio='".$template_data[2]."' AND (dispositivos.descripcion = syslog.dispositivo) GROUP BY id");
                    
                    $out = array();
                    if ($result->num_rows > 0) {
                        $keys = array("id","estado","habilitado","fecha", "ip", "dispositivo", "notas");
                        while ($aux = $result->fetch_assoc()) {
                            $hotspot = $aux['ServerName'];
                            if (isset($aux['info'])) foreach (json_decode($aux['info'], true) as $key => $value) if (!in_array($key, $keys)) $keys[] = $key;
                            $out[] = $aux;
                        }
                        $out1 = array();
                        foreach ($out as $value) {
                            $aux1 = array('id'=> ((empty($value['dispid']))?0:$value['dispid']),'estado' => '<button type="button" class="btn btn-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"danger":"success").' btn-circle"><i class="fa fa-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"times":"check").'"></i>','habilitado'=>(($value['dispositivo'] != 'hotspot')?'<input class="checkhabilitado" id="habilitado-'.$value['dispid'].'" type="checkbox"'.(($value['habilitado'])?" checked":"").'>':''),'fecha' => $value['fecha'], "ip"=> $value['ip'], "dispositivo" => $value['dispositivo'], "notas" => $value['notas']);
                            if (isset($value['info'])) {
                                $aux2 = json_decode($value['info'], true);
                                foreach ($keys as $value1) if (($value1 != "id") && ($value1 != "estado") && ($value1 != "fecha") && ($value1 != "ip") && ($value1 != "dispositivo") && ($value1 != "notas") && ($value1 != "habilitado")) $aux1[$value1] = ((array_key_exists($value1, $aux2))?$aux2[$value1]:"");
                                $out1[] = $aux1;
                            }
                        }
                        $menu = array();
                        foreach ($out1 as $value) foreach ($value as $item) $menu[] = $item;
                        $smarty->assign('server', $hotspot);
                       
                    }
                    /**
                     * Var creaservicio se utiliza para saber como tratar los elementos mostrados, ya sea un servicio o un dispositivo
                    */
                    $smarty->assign('creaServicio', true);
                    $smarty->assign('cols', $keys);
                    $smarty->assign('dispositivos', $menu);
                    
                } else { 
                    $result = $database->query("SELECT servicios.id ,servicios.ServerName, COUNT(*) AS dispositivos, (SELECT COUNT(*) FROM syslog WHERE local = servicios.ServerName AND fecha > '".date("Y-m-d H:i:s", strtotime("-30 min"))."' AND (dispositivo IN (SELECT descripcion FROM dispositivos WHERE habilitado = 1 AND id_servicio= servicios.id))) as activos FROM `servicios` LEFT JOIN dispositivos ON dispositivos.id_servicio = servicios.id GROUP BY servicios.id");
                   
                    /**
                    * Cuando entra un admin, se muestran todos los hotspot para que elija uno para ver en profuncidad, pero al entrar otro usuario solo ve sus hotspots sin posiblidad de escoger la antena. Para que el admin vea el hotspot al elegir una
                    * entra en la pagina siguiente dispositivos/id_hotspot
                    */
                    
                    $out = array();
                    if ($result->num_rows > 0) {
                        while ($aux = $result->fetch_assoc()){
                            if ($aux['dispositivos'] > 1) $aux['dispositivos']++;
                            $out[] = $aux;
                        } 
                        $menu = array();
                        foreach ($out as $value) foreach ($value as $key => $item) $menu[] = $item;
                        $smarty->assign('dispositivos', $menu);
                        $smarty->assign('cols', implode(', ', array_keys($out[0])));
                    }
                }
                $result = $database->query('SELECT id, ServerName FROM servicios');
                $servicios = array(); 
                while ($aux = $result->fetch_assoc()) $servicios[] = array($aux['id'],$aux['ServerName']);
                $smarty->assign('servicios', $servicios);
                $result = $database->query('SELECT locales.*, clientes.nombre as cnombre FROM locales LEFT JOIN clientes ON clientes.id = locales.cliente');
                $locales = array(); 
                while ($aux = $result->fetch_assoc()) $locales[] = array($aux['id'],$aux['cnombre'].'.'.$aux['nombre']);
                $smarty->assign('local', $locales);
            } else {
                header('Location: '.DOMAIN);
                die();
            }
            break;    
        default:
            header('Location: '.DOMAIN);
            die();
            break;
    }
} else {
    header('Location: '.DOMAIN);
}

