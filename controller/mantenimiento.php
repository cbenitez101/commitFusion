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
                    
                    /**
                     * INICIO PARTE NUEVA DE DISPOSITIVOS
                     * PASO 2: Obtenemos los dispositivos linkados al local(id) ya sean APs de hotspot u otros dispositivos ya sean Camaras,
                     * TPVs, servidores...
                     */
                //   $result = $database->query("SELECT syslog.*, dispositivos.notas, dispositivos.tipo, dispositivos.habilitado, dispositivos.id as dispid FROM `locales` LEFT JOIN `dispositivos` ON dispositivos.id_hotspot = locales.id LEFT JOIN `syslog` ON (locales.nombre = syslog.local AND syslog.dispositivo = dispositivos.descripcion OR (locales.nombre = syslog.local AND syslog.dispositivo = 'Hotspot')) WHERE locales.id=".$template_data[2]." GROUP BY id");
                
                    $result = $database->query("SELECT syslog.*, dispositivos.notas, dispositivos.tipo, dispositivos.habilitado, dispositivos.id as dispid FROM `locales` LEFT JOIN `dispositivos` ON dispositivos.id_local = locales.id LEFT JOIN `syslog` ON (locales.nombre = syslog.local AND syslog.dispositivo = dispositivos.descripcion OR (locales.nombre = syslog.local AND syslog.dispositivo = 'Hotspot')) WHERE locales.id=".$template_data[2]." GROUP BY id");
                   
                    $out = array();
                    if ($result->num_rows > 0) {
                        // $keys = array("id","estado","habilitado","fecha","ip","dispositivo","notas", "up", "cpu-load", "connected", "active", "trazabilidad"); //CAMBIAR SEGUN EL CASO --> Inicialmente distinto <--
                         $keys = array("id","estado","habilitado","fecha", "ip", "tipo", "dispositivo", "notas");
                        while ($aux = $result->fetch_assoc()) {
                            $hotspot = $aux['local'];
                            if (isset($aux['info'])) foreach (json_decode($aux['info'], true) as $key => $value) if (!in_array($key, $keys)) $keys[] = $key;
                            $out[] = $aux;
                        }
                        $out1 = array();
                        foreach ($out as $value) {
                            $aux1 = array('id'=> ((empty($value['dispid']))?0:$value['dispid']),'estado' => '<button type="button" class="btn btn-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"danger":"success").' btn-circle"><i class="fa fa-'.((strtotime($value['fecha']) < strtotime("-30 min"))?"times":"check").'"></i>','habilitado'=>(($value['dispositivo'] != 'hotspot')?'<input class="checkhabilitado" id="habilitado-'.$value['dispid'].'" type="checkbox"'.(($value['habilitado'])?" checked":"").'>':''),'fecha' => $value['fecha'], "ip"=> $value['ip'], 'tipo' => $value['tipo'], "dispositivo" => $value['dispositivo'], "notas" => $value['notas']);
                            if (isset($value['info'])) {
                                $aux2 = json_decode($value['info'], true);
                                foreach ($keys as $value1) if (($value1 != "id") && ($value1 != "estado") && ($value1 != "fecha") && ($value1 != "ip") && ($value1 != "dispositivo") && ($value1 != "notas") && ($value1 != "habilitado") && ($value1 != "tipo")) $aux1[$value1] = ((array_key_exists($value1, $aux2))?$aux2[$value1]:"");
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
                    $smarty->assign('cols', $keys);
                    $smarty->assign('dispositivos', $menu);
                    
                    /**
                     * FIN PARTE NUEVA DE DISPOSITIVOS
                     */ 

                } else {   
                    /**
                     * INICIO PARTE NUEVA DE DISPOSITIVOS
                     * PASO 1: Buscamos Locales que tengan el campo monitorizacion a TRUE
                    */
                    // $result = $database->query("SELECT locales.id ,locales.nombre as Local, COUNT(*) AS dispositivos, (SELECT COUNT(*) FROM syslog WHERE local = locales.nombre AND fecha > '".date("Y-m-d H:i:s", strtotime("-30 min"))."' AND (dispositivo IN (SELECT descripcion FROM dispositivos WHERE habilitado = 1 AND id_hotspot = locales.id))  OR (dispositivo = 'hotspot' AND local = locales.nombre)) as activos FROM `locales` LEFT JOIN dispositivos ON dispositivos.id_hotspot= locales.id WHERE locales.Monitorizacion = 1 GROUP BY locales.id ");
                    $result = $database->query("SELECT locales.id ,locales.nombre as Local, COUNT(*) AS dispositivos, (SELECT COUNT(*) FROM syslog WHERE local = locales.nombre AND fecha > '".date("Y-m-d H:i:s", strtotime("-30 min"))."' AND (dispositivo IN (SELECT descripcion FROM dispositivos WHERE habilitado = 1 AND id_local = locales.id))  OR (dispositivo = 'hotspot' AND local = locales.nombre)) as activos FROM `locales` LEFT JOIN dispositivos ON dispositivos.id_local= locales.id WHERE locales.Monitorizacion = 1 GROUP BY locales.id ");
                     if ($result->num_rows > 0) {
                        while ($aux = $result->fetch_assoc()){
                            if ($aux['dispositivos'] > 1) $aux['dispositivos']++;
                            $out[] = $aux;
                        } 
                        $menu = array();
                        // Se cambia valor del campo Monitorizacion de 0 o 1 a Si o no
                        foreach ($out as $value) foreach ($value as $key => $item) $menu[] = (($key == "Monitorizacion")?(($value)?"Sí":"No"):$item); 
                        /**
                         * Lista de locales para select option al agregar un nuevo dispositivo desde fuera de un local (tabla de locales)
                         */
                        $result2 = $database->query("SELECT id, nombre FROM locales");
                        if ($result2->num_rows > 0)   while ($aux2 = $result2->fetch_assoc()) $out2[] = $aux2;
                        
                        //Variables smarty. 
                        $smarty->assign('listalocales', $out2);
                        $smarty->assign('dispositivos', $menu);
                        $smarty->assign('cols', implode(', ', array_keys($out[0])));
                    }
                    
                    /**
                     * FIN PARTE NUEVA DE DISPOSITIVOS
                     */ 
                    
                }
            } else {
                header('Location: '.DOMAIN);
                die();
            }
            break;
            
        case 'acciones':
            if ($_SESSION['cliente'] == 'admin') {
                // Obtenemos las tablas que hay tanto en radius como en plataforma
                $result = $radius->query("SHOW TABLES");
                while($aux = $result->fetch_assoc()) $out[] = $aux['Tables_in_radius'];
                
                $result2 = $database->query("SHOW TABLES");
                while($aux2 = $result2->fetch_assoc()) $out2[] = $aux2['Tables_in_plataforma'];
                
                $smarty->assign('tablasrad', $out);
                $smarty->assign('tablasplat', $out2);
            }else{
                header('Location: '.DOMAIN);
                die();
            }
            break;
         
        case 'apilog':
            if ($_SESSION['cliente'] == 'admin') {
                $result = $database->query("SELECT * FROM `apilog`");
                if ($result->num_rows > 0){
                    while($aux = $result->fetch_assoc()){
                        $out[] = $aux['id'];
                        $out[] = $aux['fecha'];
                        $out[] = $aux['ServerName'];
                        $out[] = $aux['apikey'];
                        $out[] = $aux['body'];
                        $out[] = $aux['response'];
                        $out[] = $aux['codigo'];
                        $out[] = $aux['ip'];
                    }
                }
                $smarty->assign('cols', 'id, fecha, ServerName, apikey, body, response, codigo, ip');
                $smarty->assign('apilog', $out);
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

