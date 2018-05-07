<?php
/* Se utiliza la version de MikroTik API de Denis Basta */
require_once('scripts/routeros-api/routeros_api.class.php');

/*------------------------------------------------------------------------------
            MikroTikAPI
    
    Parámetros necesarios:
        - $user: usuario inicial Mikrotik
        - $pass: contraseña inicial Miktrotik
        - $server: nombre del hotspot
        - $id_server: ID del hotspot
        - $ip: IP asignada al Mikrotik (hay que crear DHCP Client en ether1)
------------------------------------------------------------------------------*/

$user = 'admin';

$pass = '';

$server = 'PubliHotspot';
// $server = 'Christo_NOTFORRESALE';

$id_server=63;

$ip = '192.168.45.7';
// $ip = '192.168.45.21';

/* Declaración del objeto RouterosAPI() sobre el cual se hará la conexión y se trabajará */
$API = new RouterosAPI();

/* Deshabilitamos muestreo de información de debug */
$API->debug = false;

/* Se realiza la conexión con los parámetros declarados anteriormente */
if ($API->connect($ip, $user, $pass)) {
    
    print_r("------------------------\n| Conexión establecida |\n------------------------\n\n");
    
    /*Se lee el Serial del MikroTik*/
    $API->write('/system/routerboard/print');
    
    $READ = $API->read();
    
    $hotspotserial = $READ[0]['serial-number'];
    
    /* ¿Qué hacía el script script_hotspot?
    if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/script_hotspot?id_hotspot=$id_server&hotspot_serial=$hotspotserial", "dst-path"=>'flash/hotspot.rsc'))){
    	echo "ok\n";
    } else {
    	echo "fail\n";
    } */
    
    /* Se añade usuario administrador y su contraseña y se elimina el usuario admin */
    print_r("\t---------------\n\tAÑADIR USUARIO\n\t---------------\n");
    
    if (enviaComando('/user/add',array('name'=>'administrador', 'group'=>'full', 'password'=>'sb_A54$x'))){
    
        print_r("==> OK <==\n\n"); 
        
        print_r("\t------------------------\n\tELIMINAR USUARIO ANTIGUO\n\t------------------------\n");
        
        if (enviaComando('/user/remove',array('numbers'=>'admin'))) print_r("==> OK <==\n\n");
        
        else print_r("==> ERROR <== \n\n");
        
    } else print_r("==> ERROR <== \n\n");
        
    
    
    
    /* Se añaden servidores DNS de Google si no hay ninguno añadido */
    print_r("\t----------------------\n\tAÑADIR SERVIDORES DNS\n\t----------------------\n");
    
    $API->write('/ip/dns/print');
    
    $READ = $API->read();
    
    if ($READ[0]['servers'] == ''){
        
        if (enviaComando('/ip/dns/set', array("servers"=>"8.8.8.8, 8.8.4.4", "allow-remote-requests"=>"true"))) print_r("==> OK <==\n\n"); 
            
        else print_r("==> ERROR <== \n\n");
            
    }
    
    
    
    
    
    /* Se establece el system identity */
    print_r("\t----------------------\n\tAÑADIR SYSTEM IDENTITY\n\t----------------------\n");
    
    if (enviaComando('/system/identity/set', array("name"=>$server))) print_r("==> OK <==\n\n");
    
    else print_r("==> ERROR <== \n\n");
    
    
    
    
    
    
    /* Se añade cliente NTP (hora del sistema) */
    print_r("\t------------\n\tCLIENTE NTP\n\t------------\n");
    
    if (enviaComando('/system/ntp/client/set', array('enabled'=>'yes', 'primary-ntp'=>'130.206.3.166'))) print_r("==> OK <==\n\n");
    
    else print_r("==> ERROR <== \n\n");
    
    
    
    
    
    
    
    /* Se establece la zona horaria a 'Atlantic/Canary' */
    print_r("\t-----------------------\n\tESTABLECER ZONA HORARIA\n\t-----------------------\n");
    
    if (enviaComando('/system/clock/set', array("time-zone-name"=>'Atlantic/Canary', "time-zone-autodetect" => "no"))) print_r("==> OK <==\n\n");
        
    else print_r("==> ERROR <== \n\n");
        
    
    
    
    
    
    print_r("\t-----------------------\n\tAÑADIR CONEXION VPN\n\t-----------------------\n");
    if (enviaComando('/interface/pptp-client/add', array("name"=>'Servibyte', "connect-to" => "217.125.25.165", "user"=>$server, "password"=>"A54_sb?8", "disabled"=>"no"))) print_r("==> OK <==\n\n");
    else print_r("==> ERROR <== \n\n");
    
    
    
    
    /***************************************************************
     *                                                              |
     * Segun tengo entendido en la nueva version de routeros        |
     * el discovery no está implicito, teniendo que declarar en     |
     * una lista las interfaces que si que queremos que lo tengan   |
     *  
     * ************************************************************/
    
    
    
    
    
    
    /* CREACION DE BRIDGES */
    print_r("\t--------------------------------\n\tCREACIÓN DE bridge1_hs_clientes1\n\t--------------------------------\n\t");
    
    if (enviaComando('/interface/bridge/add', array("name"=>'bridge1_hs_clientes1', 'protocol-mode'=>'none'))){
        
        print_r("==> OK <==\n\n");
        
        
        /* Discovery no de bridge1_hs_clientes1 */
        // print_r("\t-----------------------------\n\tDISCOVERY NO DE bridge1_hs_clientes1\n\t-----------------------------\n\t");
        
        // if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge1_hs_clientes1','discover'=>'no'))) print_r("==> OK <==\n\n");
            
        // else print_r("==> ERROR <==\n\n");
        
        /* Discovery no de bridge1_hs_clientes1 */
        print_r("\t--------------------------------\n\tCREACIÓN DE bridge2_hs_clientes2\n\t--------------------------------\n\t");
        
        if (enviaComando('/interface/bridge/add', array("name"=>'bridge2_hs_clientes2', 'protocol-mode'=>'none'))){
            
            print_r("==> OK <==\n\n");
            
            // print_r("\t-----------------------------------\n\tDISCOVERY NO DE bridge2_hs_clientes2\n\t-----------------------------------\n\t");
            
            // if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge2_hs_clientes2','discover'=>'no'))){
                
            //     print_r("==> OK <==\n\n");
                
                print_r("\t-----------------------------\n\tCREACIÓN DE bridge3_hs_staff\n\t-----------------------------\n\t");
                 
                if (enviaComando('/interface/bridge/add', array("name"=>'bridge3_hs_staff', 'protocol-mode'=>'none'))){
                    
                      
                    // print_r("\t-----------------------------------\n\tDISCOVERY NO DE bridge3_hs_staff\n\t-----------------------------------\n\t");
            
                    // if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge3_hs_staff','discover'=>'no'))){
                        
                        print_r("==> OK <==\n\n");
                    
                        print_r("\t-----------------------------\n\tCREACIÓN DE INTERFACES WIFI\n\t-----------------------------\n\t");
                        
                        $API->write('/interface/wireless/getall');
                        
                        $READ = $API->read();
                        
                        if(count($READ) > 0){
                            
                            if (!array_key_exists('!trap', $READ)) {
                                
                                print_r("-----------------------------\n\tCREACIÓN DE SECURITY PROFILE\n\t-----------------------------\n\t");
                                if(enviaComando('/interface/wireless/security-profiles/add', array('authentication-types'=>'wpa-psk,wpa2-psk', 'eap-methods'=>"", 'management-protection'=>'allowed', 'mode'=>'dynamic-keys', 'name'=>'profile_staff', 'supplicant-identity'=>'', 'wpa-pre-shared-key'=>$server.'_sb_staff', 'wpa2-pre-shared-key'=>$server.'_sb_staff'))){
                                    print_r("==> OK <==\n\n");
            
                                    
                                    foreach ($READ as $key => $value) {
                                        
                                        print_r("\t-----------------------\n\tCREACIÓN DE INTERFACES\n\t-----------------------\n\t");
                                        
                                        if (isset($value['band']) ){
                                            
                                            if (enviaComando('/interface/wireless/set', array("numbers"=> $key,"disabled"=>"no", "mode"=>"ap-bridge", "band"=>((strstr($value['band'],'2ghz'))?"2ghz-b/g/n":"5ghz-a/n/ac"), "channel-width"=>"20mhz", "frequency"=>((strstr($value['band'],'2ghz'))?2437:5240), "wireless-protocol"=>"802.11", "default-forwarding"=>"no", "ssid"=>$server,"radio-name"=>$server, "name"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5')))){
                                            
                                                print_r("==> OK <==\n\n");
            
                                                // print_r("\t-----------------------------------\n\tDISCOVERY NO DE WIRELESS\n\t-----------------------------------\n\t");
                                                
                                                // if (enviaComando('/ip/neighbor/discovery/set', array('numbers'=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5'),'discover'=>'no'))){
                                                    
                                                    print_r("\t----------------------------------------\n\tSE METE WIRELESS EN bridge1_hs_clientes1\n\t----------------------------------------\n\t");
                                                    if (enviaComando('/interface/bridge/port/add', array("bridge"=> "bridge1_hs_clientes1","interface"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5')))) {
                                                        
                                                        print_r("==> OK <==\n\n");
                                                        
                                                        
                                                        print_r("\t-----------------------------\n\tSE CONFIG. INTERFAZ WIRELESS\n\t-----------------------------\n\t");
                                                        if (enviaComando('/interface/wireless/add', array("disabled"=>'yes', "keepalive-frames"=>"disabled", "master-interface"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5'), "multicast-buffering"=>"disabled", "name"=>$server."_Staff_".((strstr($value['band'],'2ghz'))?"2":"5"), "ssid"=>$server."_Staff", "wds-cost-range"=>0, "wds-default-cost"=>0, "wps-mode"=>"disabled", "mac-address"=>"0".$key.substr($value['mac-address'], 2),'security-profile'=>'profile_staff'))) {
                                                            
                                                            print_r("==> OK <==\n\n");
                
                                                             
                                                            print_r("\t------------------------------------\n\tSE METE WIRELESS EN bridge3_hs_staff\n\t------------------------------------\n\t");
                                                            if (enviaComando('/interface/bridge/port/add', array("bridge"=> "bridge3_hs_staff","interface"=>$server."_Staff_".((strstr($value['band'],'2ghz'))?"2":"5")))) {
                                                                
                                                                print_r("==> OK <==\n\n");
                
                                                                // print_r("--Se ha completado la config del Wireless\n");
                                                                
                                                            }else print_r("==> ERROR <==\n\n");
                                                            
                                                        }else print_r("==> ERROR <==\n\n");
                                                        
                                                    }else print_r("==> ERROR <==\n\n");
                                                    
                                                // }else print_r("==> ERROR <==\n\n");
                                                
                                            }else print_r("==> ERROR <==\n\n");
                                            
                                        }
                                        
                                    }
                                }else print_r("==> ERROR <==\n\n");
                                
                            }else print_r("==> ERROR <==\n\n");
                        }
                        
                        
                        
                        
                           
                        print_r("\t----------------------\n\tSE AÑADE bridge_trunk\n\t----------------------\n\t");
                        if (enviaComando('/interface/bridge/add', array("name"=>'bridge_trunk', 'protocol-mode'=>'none'))){
                            
                            print_r("==> OK <==\n\n");
                            
                            print_r("\t--------------------------------\n\tSE AÑADE bridge4_administracion\n\t--------------------------------\n\t");
                             
                            if(enviaComando('/interface/bridge/add', array("name"=>'bridge4_administracion', 'protocol-mode'=>'none'))){
                                
                                print_r("==> OK <==\n\n");
                                
                                print_r("\t----------------------\n\tSE AÑADE bridge5_WAN\n\t-----------------------\n\t");
                                
                                if(enviaComando('/interface/bridge/add', array("name"=>'bridge5_WAN', 'protocol-mode'=>'none'))){
                                    
                                    print_r("==> OK <==\n\n");
                                    
                                    
                                    // print_r("\t-----------------------------------\n\tDISCOVERY SET NO DE bridge5_WAN\n\t-----------------------------------\n\t");
                                    // if(enviaComando('/ip/neighbor/discovery/set', array('numbers'=>'bridge5_WAN','discover'=>'no'))){
                                        
                                    //     print_r("==> OK <==\n\n");
                                        
                                    // }else print_r("==> ERROR <==\n\n");
                                    
                                    
                                    
                                    print_r("\t---------------------------------------------------\n\tSE CREAN INTERFACES Y SE AÑADEN A LOS BRIDGES CORRESP.\n\t--------------------------------------------------\n");
                                    
                                    
                                    
                                    $res = $API->write('/interface/ethernet/getall');
                                    
                                    $READETHER = $API->read();
                                    
                                    $res = $API->write('/system/routerboard/getall');
                                    
                                    $READ = $API->read();
                                    
                                    // file_put_contents('zZZZ', print_r($READ, true));
                                    //  file_put_contents('zZZZ2', print_r($READETHER, true));
                                    
                                     if(count($READ) > 0){
                                         
                                        if (!array_key_exists('!trap', $READ) && !array_key_exists('!trap', $READETHER)){
                                            
                                            foreach($READETHER as $key=> $value){
                                                
                                                
                                                /********************************************
                                                *                                           *
                                                * Falta añadir comentarios a las interfaces *
                                                *                                           *
                                                *********************************************/
                                                
                                                
                                                switch ((((int)substr($value['name'], -2) == 0)?substr($value['name'], -1):substr($value['name'], -2))) {
                                                    
                                                    case 1:
                                                        // if (strpos($value['name'], "combo") === false){
                                                        
                                                        //   if(enviaComando('/interface/bridge/port/add', array('bridge'=>((strpos($value['name'], "combo") === false || ( (strstr($READ[0]['model'],'1072') > -1) && ($value['name'] == 'ether1')))?'bridge5_WAN':'bridge_trunk'),'interface'=>$value['name']))) {
                                                            
                                                            // MIRAR PARTE DE COMBO, ALOMEJOR NO E SNECESARIO CONTEMPLAR TANTOS MODELOS DE ROUTERBOARD
                                                            
                                                            
                                                            print_r("\t--------------------------------\n\tSE AÑADE ".$value['name']." A bridge5_WAN.\n\t--------------------------------\n\t");
                                                        
                                                            if(enviaComando('/interface/bridge/port/add', array('bridge'=>((strpos($value['name'], "combo") === false)?'bridge5_WAN':'bridge_trunk'),'interface'=>$value['name']))) {
                                                                
                                                              print_r("==> OK <==\n\n");
                                                               
                                                            } else print_r("==> ERROR <==\n\n");
                                                            
                                                            
                                                        // }else {
                                                            
                                                        //     print_r("\t--------------------------------\n\tSE AÑADE ".$value['name']." A bridge_trunk.\n\t--------------------------------\n\t");
                                                        
                                                        //     if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>$value['name']))) {
                                                                
                                                        //       print_r("==> OK <==\n\n");
                                                               
                                                        //     } else print_r("==> ERROR <==\n\n");
                                                            
                                                        // }
                                                        
                                                       break;
                                                        
                                                    case 2:
                                                        
                                                        print_r("\t-------------------------------------\n\tSE AÑADE ".$value['name']." A bridge1_hs_clientes1.\n\t-------------------------------------\n\t");
                                                        
                                                        if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge1_hs_clientes1','interface'=>$value['name']))) {
                                                            
                                                            print_r("==> OK <==\n\n");
                                                            
                                                        } else print_r("==> ERROR <==\n\n");
                                                        
                                                        
                                                        break;
                                                        
                                                    case 3:
                                                        
                                                        print_r("\t-------------------------------------\n\tSE AÑADE ".$value['name']." A ".((strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1)?'bridge2_hs_clientes2':'bridge4_administracion').".\n\t-------------------------------------\n\t");
                                                        
                                                        if(enviaComando('/interface/bridge/port/add', array('bridge'=>((strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1)?'bridge2_hs_clientes2':'bridge4_administracion'),'interface'=>$value['name']))) {
                                                            
                                                            print_r("==> OK <==\n\n");
                                                            
                                                        } else print_r("==> ERROR <==\n\n");
                                                        
                                                        break;
                                                        
                                                    case 4:
                                                        
                                                        print_r("\t-----------------------------------\n\tSE AÑADE ".$value['name']." A ".((strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1)?'bridge3_hs_staff':'bridge_trunk').".\n\t-----------------------------------\n\t");
                                                        
                                                        if(enviaComando('/interface/bridge/port/add', array('bridge'=>((strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1)?'bridge3_hs_staff':'bridge_trunk'),'interface'=>$value['name']))) {
                                                            
                                                            print_r("==> OK <==\n\n");
                                                            
                                                        } else print_r("==> ERROR <==\n\n");
                                                        
                                                        break;
                                                        
                                                    case 5:
                                                        
                                                        print_r("\t-------------------------------\n\tSE AÑADE ".$value['name']." A ".((strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1)?'bridge4_admin':'bridge_trunk').".\n\t-------------------------------\n\t");
                                                        
                                                        if(enviaComando('/interface/bridge/port/add', array('bridge'=>((strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1)?'bridge4_admin':'bridge_trunk'),'interface'=>$value['name']))) {
                                                            
                                                          print_r("==> OK <==\n\n");
                                                           
                                                         } else print_r("==> ERROR <==\n\n");
                                                         
                                                        break;
                                                    
                                                    default:
                                                        
                                                        print_r("\t-----------------------------------\n\tSE AÑADE ".$value['name']." A bridge_trunk.\n\t-----------------------------------\n\t");
                                                        
                                                        if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>$value['name']))) {
                                                             
                                                            print_r("==> OK <==\n\n");
                                                            
                                                        } else print_r("==> ERROR <==\n\n");
                                                         
                                                        break;
                                                        
                                                }
                                               
                                            }
                                             
                                        }
                                         
                                    }
                                    
                                    
                                    print_r("\t-----------------------------------\n\tSE CREAN VLANs \n\t-----------------------------------\n");
                                    
                                    print_r("\t-----------------------------------\n\tvlan1001_br-trunk_clientes1 \n\t-----------------------------------\n\t");
                                    
                                    if (enviaComando('/interface/vlan/add', array('name'=>'vlan1001_br-trunk_clientes1', 'vlan-id'=> '1001', 'interface'=>'bridge_trunk'))){
                                        
                                        print_r("==> OK <==\n\n");
                                        
                                        // AÑADIR A BRIDGE CORRESPONDIENTE
                                            
                                        print_r("\t-----------------------------------\n\tSE AÑADE PUERTO lan1001_br-trunk_clientes1 a bridge1_hs_clientes1 \n\t-----------------------------------\n\t");
                                            
                                        if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge1_hs_clientes1','interface'=>'vlan1001_br-trunk_clientes1'))) {
                                            
                                             print_r("==> OK <==\n\n");
                                             
                                        }else print_r("==> ERROR <==\n\n");
                                        
                                       
                                        
                                        print_r("\t-----------------------------------\n\tvlan1002_br-trunk_clientes2 \n\t-----------------------------------\n\t");
                                        
                                        if (enviaComando('/interface/vlan/add', array('name'=>'vlan1002_br-trunk_clientes2', 'vlan-id'=> '1002', 'interface'=>'bridge_trunk'))){
                                            
                                            
                                            print_r("==> OK <==\n\n");
                                            // AÑADIR A BRIDGE CORRESPONDIENTE
                                                
                                            print_r("\t-----------------------------------\n\tSE AÑADE PUERTO vlan1002_br-trunk_clientes2 a bridge2_hs_clientes2 \n\t-----------------------------------\n\t");
                                                
                                            if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge2_hs_clientes2','interface'=>'vlan1002_br-trunk_clientes2'))) {
                                            
                                                print_r("==> OK <==\n\n");
                                             
                                            }else print_r("==> ERROR <==\n\n");
                                            
                                            
                                            
                                            print_r("\t-----------------------------------\n\tvlan1003_br-trunk_staff\n\t-----------------------------------\n\t");
                                             
                                            if (enviaComando('/interface/vlan/add', array('name'=>'vlan1003_br-trunk_staff', 'vlan-id'=> '1003', 'interface'=>'bridge_trunk'))){
                                                
                                                print_r("==> OK <==\n\n");
                                                
                                                // AÑADIR A BRIDGE CORRESPONDIENTE
                                                    
                                                print_r("\t-----------------------------------\n\tSE AÑADE PUERTO vlan1003_br-trunk_staff a bridge3_hs_staff \n\t-----------------------------------\n\t");
                                                    
                                                if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge3_hs_staff','interface'=>'vlan1003_br-trunk_staff'))) {
                                            
                                                    print_r("==> OK <==\n\n");
                                                 
                                                }else print_r("==> ERROR <==\n\n");
                                                 
                                                
                                                
                                                print_r("\t-----------------------------------\n\tvlan1004_br-trunk_adm \n\t-----------------------------------\n\t");
                                                
                                                if (enviaComando('/interface/vlan/add', array('name'=>'vlan1004_br-trunk_adm', 'vlan-id'=> '1004', 'interface'=>'bridge_trunk'))){
                                                    
                                                    print_r("==> OK <==\n\n");
                                                    
                                                    // AÑADIR A BRIDGE CORRESPONDIENTE
                                                        
                                                    print_r("\t-----------------------------------\n\tvSE AÑADE PUERTO vlan1004_br-trunk_adm a bridge4_administracion \n\t-----------------------------------\n\t");
                                                        
                                                    if(enviaComando('/interface/bridge/port/add', array('bridge'=>'bridge4_administracion','interface'=>'vlan1004_br-trunk_adm'))) {
                                            
                                                        print_r("==> OK <==\n\n");
                                                     
                                                    }else print_r("==> ERROR <==\n\n");
                                                     
                                                } else print_r("==> ERROR <==\n\n");
                                                 
                                            } else print_r("==> ERROR <==\n\n");
                                             
                                        }else print_r("==> ERROR <==\n\n");
                                        
                                    }else print_r("==> ERROR <==\n\n");
                                    
                                }else print_r("==> ERROR <==\n\n");
                                
                            }else print_r("==> ERROR <==\n\n");
                            
                        }else print_r("==> ERROR <==\n\n");
                    
                    // }else print_r("==> ERROR <==\n\n");
                     
                }
            
            // }else print_r("==> ERROR <==\n\n");
             
        }else print_r("==> ERROR <==\n\n");
        
    } else print_r("==> ERROR <==\n\n");
    
    
    
    
    

    print_r("\t-----------------------------------\n\tSE ESTABLECE LOGGING ACTIONS memory 100 lines\n\t-----------------------------------\n\t");
    if(enviaComando('/system/logging/action/set', array('numbers'=>'memory', 'memory-lines'=>'100'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t-----------------------------------\n\tSE ESTABLECE LOGGING ACTIONS disk-lines-per-file 100 lines\n\t-----------------------------------\n\t");
    
    if(enviaComando('/system/logging/action/set', array('numbers'=>'disk', 'disk-lines-per-file'=>'100'))){
         
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL forward establecidas\n\t-----------------------------------\n\t");
    
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'forward','comment'=>'establecidas', 'connection-state'=>'established'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL input established\n\t-----------------------------------\n\t");
    
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'input', 'connection-state'=>'established'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL forward relacionadas\n\t-----------------------------------\n\t");
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'forward','comment'=>'relacionadas', 'connection-state'=>'related'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL input related\n\t-----------------------------------\n\t");
    
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'input', 'connection-state'=>'related'))){
         
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL forward invalidas\n\t-----------------------------------\n\t");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop','chain'=>'forward','comment'=>'invalidas', 'connection-state'=>'invalid'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL input invalidas\n\t-----------------------------------\n\t");
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop', 'chain'=>'input', 'connection-state'=>'invalid'))){
    
        print_r("==> OK <==\n\n");
    
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL tarpit forward invalidas Port Scan Detection\n\t-----------------------------------\n\t");
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'tarpit', 'chain'=>'forward', 'comment'=>'Port Scan Detection', 'protocol'=>'tcp', 'psd'=>'21,3s,3,1'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL input ICMP <10 PPS sino drop \n\t-----------------------------------\n\t");
     
    if(enviaComando('/ip/firewall/filter/add', array('chain'=>'input', 'comment'=>'ICMP <10 PPS sino drop', 'limit'=>'10,0:packet', 'protocol'=>'icmp'))){
         
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t-----------------------------------\n\tFIREWALL input ICMP drop \n\t-----------------------------------\n\t");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop', 'chain'=>'input', 'protocol'=>'icmp'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
   
    print_r("\t-----------------------------------\n\tSE CREA SCRIPT MONITORIZACION\n\t-----------------------------------\n\t");
     
    if(enviaComando('/system/script/add', array('name'=>'Monitorizacion', 'owner'=>"administrador",'policy'=>' ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'source'=>":log warning (\":".$server."::Hotspot::up:\" .[/system resource get uptime] . \";cpu-load:\" . [/system resource get cpu-load] . \";connected:\" . [/interface wireless registration-table print count-only])"))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t-----------------------------------\n\tSCRIPT MONITORIZACION SCHEDULER\n\t-----------------------------------\n\t");
        if(enviaComando('/system/scheduler/add', array('interval'=>'15m', 'name'=>"Monitorizacion",'on-event'=>'Monitorizacion', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/01/2016', 'start-time'=>'00:00:00'))){
            
            print_r("==> OK <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    print_r("\t----------------------\n\tLAYER-7 facebook\n\t----------------------\n\t");
     
    if(enviaComando('/ip/firewall/layer7-protocol/add', array("name"=>"facebook","regexp"=>"^.+(facebook.com).*\$"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t----------------------\n\tLAYER-7 facebook2\n\t----------------------\n\t");
    
    if(enviaComando('/ip/firewall/layer7-protocol/add', array("name"=>"facebook2","regexp"=>".+(facebook.com)*dialog"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tLAYER-7 facebook3\n\t----------------------\n\t");
    
    if(enviaComando('/ip/firewall/layer7-protocol/add', array("name"=>"facebook3","regexp"=>".+(facebook.com)*login"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH certificate.crt\n\t----------------------\n\t");
    
    // if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.ca-crt"))){
    if (enviaComando('/tool/fetch', array("url"=> "http://www.plataforma.openwebcanarias.es/ftp/certificate.ca-crt"))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tIMPORT certificate.crt\n\t----------------------\n\t");
        
        // if(enviaComando('/certificate/import', array("file-name"=> "certificate.crt", "passphrase"=>"PwpXXf8bPwpXXf8b"))){
        if(enviaComando('/certificate/import', array("file-name"=> "certificate.ca-crt", "passphrase"=>""))){
            
            print_r("==> OK <==\n\n");
            
            print_r("\t---------------------\n\tFetch hotspot.key\n\t----------------------\n\t");
            
            // if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.crt"))){
            if (enviaComando('/tool/fetch', array("url"=> "http://www.plataforma.openwebcanarias.es/ftp/certificate.crt"))){
                
                print_r("==> OK <==\n\n");
                
                print_r("\t---------------------\n\tIMPORT hotspot.key\n\t----------------------\n\t");
                
                // if(enviaComando('/certificate/import', array("file-name"=> "hotspot.key", "passphrase"=>"PwpXXf8bPwpXXf8b"))){
                 if(enviaComando('/certificate/import', array("file-name"=> "certificate.crt", "passphrase"=>""))){
                    
                    print_r("==> OK <==\n\n");
                    
                     print_r("\t---------------------\n\tFetch certificate.ca-crt\n\t----------------------\n\t");
                     
                    // if (enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot.key"))){
                    if (enviaComando('/tool/fetch', array("url"=> "http://www.plataforma.openwebcanarias.es/ftp/hotspot.key"))){
                        
                        print_r("==> OK <==\n\n");
                        
                        print_r("\t---------------------\n\tIMPORT certificate.ca-crt\n\t----------------------\n\t");
                        
                        // if(enviaComando('/certificate/import', array("file-name"=> "certificate.ca-crt", "passphrase"=>"PwpXXf8bPwpXXf8b"))){
                            if(enviaComando('/certificate/import', array("file-name"=> "hotspot.key", "passphrase"=>""))){
                            
                            print_r("==> OK <==\n\n");
                            
                            print_r("\t---------------------\n\tPROFILE SET DEFAULT\n\t----------------------\n\t");
                             
                            if(enviaComando('/ip/hotspot/profile/set', array('numbers'=>'default','html-directory'=>'flash/hotspot'))){
                                
                                print_r("==> OK <==\n\n");
                                
                                print_r("\t---------------------\n\tPROFILE ADD hsprof1\n\t----------------------\n\t");
                                
                                if(enviaComando('/ip/hotspot/profile/add', array('dns-name'=>'hotspot.wifipremium.com', 'hotspot-address'=>'172.21.0.1','http-cookie-lifetime'=>'1w', 'login-by'=>'cookie,http-chap,https,mac-cookie','name'=>'hsprof1', 'ssl-certificate'=>'certificate.crt_0', 'use-radius'=>'yes'))){
                                    
                                    print_r("==> OK <==\n\n");
                                    
                                    
                                    // print_r("\t---------------------\n\tPROFILE ADD hsprof1\n\t----------------------\n\t");
                            
                                    // if(enviaComando('/ip/hotspot/profile/add', array('dns-name'=>'hotspot.wifipremium.com', 'hotspot-address'=>'172.21.0.1','http-cookie-lifetime'=>'1w', 'login-by'=>'cookie,http-chap,https,mac-cookie','name'=>'hsprof1', 'ssl-certificate'=>'certificate.crt_0', 'use-radius'=>'yes'))){
                                        
                                    //     print_r("==> OK <==\n\n");
                                        
                                        print_r("\t---------------------\n\tHOTSPOT ADD\n\t----------------------\n\t");
                                        
                                        if(enviaComando('/ip/hotspot/add', array('disabled'=>'no', 'idle-timeout'=>'none','interface'=>'bridge1_hs_clientes1','name'=>$server, 'profile'=>'hsprof1'))){
                                            
                                            print_r("==> OK <==\n\n");  
                                            
                                            print_r("\t---------------------\n\tHOTSPOT IP-BINDING ADD\n\t----------------------\n\t");
                                            
                                            if(enviaComando('/ip/hotspot/ip-binding/add', array('address'=>'172.21.9.171','mac-address'=>'04:18:D6:84:83:1A','server'=>$server, 'to-address'=>'172.21.9.171','type'=>'bypassed'))){
                                                
                                                print_r("==> OK <==\n\n");
                                                
                                            }else print_r("==> ERROR <==\n\n");
                                            
                                            
                                            print_r("\t---------------------\n\tRADIUS ADD\n\t----------------------\n\t");
                                            
                                            if(enviaComando('/radius/add', array("address"=>"176.28.102.26",'secret'=>'tachin','service'=>'hotspot','timeout'=>'5s'))){
                                                
                                                print_r("==> OK <==\n\n");
                                                
                                                
                                                
                                                
                                            }else print_r("==> ERROR <==\n\n");
                                            
                                        }else print_r("==> ERROR <==\n\n");
                                        
                                        
                                        
                                        
                                        
                                        
                                        print_r("\t---------------------\n\tSET DEFAULT USER PROFILE\n\t----------------------\n\t");
                                        
                                        if(enviaComando('/ip/hotspot/user/profile/set', array('numbers'=>'default', 'keepalive-timeout'=>'1w','mac-cookie-timeout'=>'1w','rate-limit'=>'3M/3M', 'shared-users'=>'3'))){
                                             
                                            print_r("==> OK <==\n\n");
                                             
                                        }else print_r("==> ERROR <==\n\n");
                                        
                                        
                                        print_r("\t---------------------\n\tADD TECNICO USER PROFILE\n\t----------------------\n\t");
                                        
                                        if(enviaComando('/ip/hotspot/user/profile/add', array('name'=>'tecnico', 'transparent-proxy'=>'yes','shared-users'=>'5'))){
                                            
                                            print_r("==> OK <==\n\n");
                                            
                                        }else print_r("==> ERROR <==\n\n");
                                        
                                        
                                        print_r("\t---------------------\n\tADD usprof1 USER PROFILE\n\t----------------------\n\t");
                                        
                                        if(enviaComando('/ip/hotspot/user/profile/add', array('keepalive-timeout'=>'1w', 'mac-cookie-timeout'=>'1w','name'=>'uprof1','rate-limit'=>'5M/10M', 'shared-users'=>'3'))){
                                            
                                            print_r("==> OK <==\n\n");
                                         
                                        } else print_r("==> ERROR <==\n\n");
                                        
                                        
                                        
                                        
                                        
                                        
                                        print_r("\t---------------------\n\tADD POOL hs-pool-14\n\t----------------------\n\t");
                                        
                                        if(enviaComando('/ip/pool/add', array('name'=>'hs-pool-14', 'ranges'=>'172.21.0.2-172.21.255.254'))){
                                            
                                            print_r("==> OK <==\n\n");
                                            
                                            print_r("\t---------------------\n\tADD DHCP-SERVER hs-pool-14\n\t----------------------\n\t");
                                            
                                            if(enviaComando('/ip/dhcp-server/add', array('address-pool'=>'hs-pool-14', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge1_hs_clientes1','lease-time'=>'1w','name'=>'dhcp1'))){
                                                
                                                print_r("==> OK <==\n\n");
                                                
                                                print_r("\t---------------------\n\tADD DHCP-SERVER NETWORK \n\t----------------------\n\t");                   
                                                if(enviaComando('/ip/dhcp-server/network/add', array('address'=>'172.21.0.0/16', 'comment'=>'hotspot network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'172.21.0.1','netmask'=>'32'))){
                                                    
                                                    print_r("==> OK <==\n\n");
                                                    
                                                }else print_r("==> ERROR <==\n\n");
                                                 
                                            }else print_r("==> ERROR <==\n\n");
                                            
                                        } else print_r("==> ERROR <==\n\n");
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                    // }else print_r("==> ERROR <==\n\n");
                                    
                                }else print_r("==> ERROR <==\n\n");
                                
                            }else print_r("==> ERROR <==\n\n");
                            
                        }else print_r("==> ERROR <==\n\n");
                        
                    }else print_r("==> ERROR <==\n\n");
                
                }else print_r("==> ERROR <==\n\n");
                
            }else print_r("==> ERROR <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
         
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    print_r("\t---------------------\n\tCOMUNNITY CREATION \n\t----------------------\n\t");  
    
    if(enviaComando('/snmp/community/add', array("name"=> "servibyte", "addresses"=> "217.125.25.165", "security"=>"none", "read-access"=>"yes", "write-access"=>"no", "authentication-protocol"=>"MD5", "encryption-protocol"=>"DES", "authentication-password"=>"sbyte", "encryption-password"=>"sbyte" ))){
        
        print_r("==> OK <==\n\n");
        
        
        print_r("\t---------------------\n\tSNMP SET \n\t----------------------\n\t");   
        if(enviaComando('/snmp/set', array("enabled"=> "yes", "contact"=> "info@servibyte.com", "location"=>"Maspalomas", "trap-community"=>"servibyte", "trap-version"=>"2", "trap-generators"=>"interfaces", "trap-interfaces"=>"all" ))){
            
            print_r("==> OK <==\n\n");
            
            print_r("\t---------------------\n\tE-MAIL SET \n\t----------------------\n\t");   
             
            if(enviaComando('/tool/e-mail/set', array("address"=> "74.125.206.108", "port"=> "587", "start-tls"=>"yes", "from"=>"servibyte.log@gmail.com", "user"=>"Servibyte.log", "password"=>"sbyte_14_Mxz"))){
                
                print_r("==> OK <==\n\n");
                
                print_r("\t---------------------\n\tADD LOGGING ACTION email\n\t----------------------\n\t"); 
                
                if(enviaComando('/system/logging/action/add', array("name"=> "email", "target"=> "email", "email-to"=>"servibyte.log@gmail.com", "email-start-tls"=>"yes"))){
                    
                    print_r("==> OK <==\n\n");
                     
                }else print_r("==> ERROR <==\n\n");
                
            }else print_r("==> ERROR <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
   
    
    
    
    print_r("\t---------------------\n\tFETCH DEL SYSNOTE\n\t----------------------\n\t"); 
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/sys-note.txt"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    print_r("\t---------------------\n\tIP SERVICE SET TELNET\n\t----------------------\n\t");   
     
    if(enviaComando('/ip/service/set', array("numbers"=>"telnet",'disabled'=>'yes'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    print_r("\t---------------------\n\tIP SERVICE SET FTP\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/service/set', array("numbers"=>"ftp",'disabled'=>'yes'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    print_r("\t---------------------\n\tIP SERVICE SET WWW\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/service/set', array("numbers"=>"www",'disabled'=>'yes'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    print_r("\t---------------------\n\tIP SERVICE SET WWW-SSL\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/service/set', array("numbers"=>"www-ssl",'certificate'=>'certificate.crt_0','disabled'=>'no'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tADD POOL POOL_ADM\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/pool/add', array('name'=>'pool_adm', 'ranges'=>'172.20.0.2-172.20.0.254'))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tADD DHCP-SERVER POOL_ADM\n\t----------------------\n\t"); 
        
        if(enviaComando('/ip/dhcp-server/add', array('address-pool'=>'pool_adm', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge4_administracion','name'=>'dhcp_adm'))){
            
            print_r("==> OK <==\n\n");
            
            print_r("\t---------------------\n\tADD DHCP-SERVER NETWORK\n\t----------------------\n\t"); 
            
            /*Añadir aqui las networks?*/ 
            if(enviaComando('/ip/dhcp-server/network/add', array('address'=>'172.20.0.0/22', 'comment'=>'admin network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'172.20.0.1','netmask'=>'22'))){
                
                print_r("==> OK <==\n\n");
                
            } else print_r("==> ERROR <==\n\n");
            
        } else print_r("==> ERROR <==\n\n");
        
    } else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tIP POOL ADD POOL_STAFF\n\t----------------------\n\t"); 
      
    if(enviaComando('/ip/pool/add', array('name'=>'pool_staff', 'ranges'=>'192.168.50.2-192.168.50.254'))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tIP POOL ADD POOL_STAFF\n\t----------------------\n\t"); 
        if(enviaComando('/ip/dhcp-server/add', array('address-pool'=>'pool_staff', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge3_hs_staff','name'=>'dhcp_staff'))){
            
            print_r("==> OK <==\n\n");
            
            /*Añadir aqui las networks?*/
            print_r("\t---------------------\n\tIP DHCP-SERVER NETWORK ADD\n\t----------------------\n\t"); 
            
            if(enviaComando('/ip/dhcp-server/network/add', array('address'=>'192.168.50.0/24', 'comment'=>'staff network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'192.168.50.1','netmask'=>'24'))){
                
                print_r("==> OK <==\n\n");
                
            }else print_r("==> ERROR <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    } else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    print_r("\t---------------------\n\tSYSTEM LOGGING ACTION ADD SBREMOTE\n\t----------------------\n\t"); 
     
    if(enviaComando('/system/logging/action/add', array('name'=>'SBRemote', 'remote'=>'217.125.25.165','target'=>'remote'))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tSYSTEM LOGGING ADD SBREMOTE\n\t----------------------\n\t"); 
        
        if(enviaComando('/system/logging/add', array('action'=>'SBRemote', 'prefix'=>'Monitor', 'topics'=>'warning,script'))){
            
            print_r("==> OK <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    print_r("\t---------------------\n\tSYSTEM LOGGING ACTION ADD HOTSPOTINFO\n\t----------------------\n\t"); 
      
    if(enviaComando('/system/logging/action/add', array('name'=>'HotspotInfo', 'memory-lines'=>'3000','target'=>'memory'))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tSYSTEM LOGGING ADD HOTSPOTINFO\n\t----------------------\n\t"); 
        
        if(enviaComando('/system/logging/add', array('action'=>'HotspotInfo', 'topics'=>'hotspot,info'))){
             
            print_r("==> OK <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t---------------------\n\tSYSTEM LOGGING ACTION ADD HOTSPOTDEBUG\n\t----------------------\n\t"); 
     
    if(enviaComando('/system/logging/action/add', array('name'=>'HotspotDebug', 'memory-lines'=>'3000','target'=>'memory'))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tSYSTEM LOGGING ADD HOTSPOTDEBUG\n\t----------------------\n\t"); 
        
        if(enviaComando('/system/logging/add', array('action'=>'HotspotDebug', 'topics'=>'hotspot,debug'))){
             
            print_r("==> OK <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tIPSEC PROPOSAL SET\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/ipsec/proposal/set', array('numbers'=>'default', 'enc-algorithms'=>'aes-128-cbc'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");

    
    
    
    
    
    
    
      
    print_r("\t---------------------\n\tDNS STATIC ADD EXIT.COM\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/dns/static/add', array('address'=>'172.21.0.1','name'=>'exit.com'))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tDNS STATIC ADD 172.21.0.1\n\t----------------------\n\t"); 
        
        if(enviaComando('/ip/dns/static/add', array('address'=>'172.21.0.1','comment'=>'Capturador DNS cuando no hay internet', 'disabled'=>'yes','regexp'=>".*\\..*"))){
            
            print_r("==> OK <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    
      

    print_r("\t---------------------\n\tIP ADDRESS ADD HOTSPOT NETWORK\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/address/add', array('address'=>'172.21.0.1/16','comment'=>'hotspot network', 'interface'=>'bridge1_hs_clientes1','network'=>'172.21.0.0'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    print_r("\t---------------------\n\tIP ADDRESS ADD 172.20.0.1/22\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/address/add', array('address'=>'172.20.0.1/22', 'interface'=>'bridge4_administracion','network'=>'172.20.0.0'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    print_r("\t---------------------\n\tIP ADDRESS ADD Red Staff/IPTV\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/address/add', array('address'=>'192.168.50.1/24','comment'=>'Red Staff/IPTV', 'interface'=>'bridge3_hs_staff','network'=>'192.168.50.0'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\t ADD ADDRESS LISTS\n\t----------------------\n\t"); 
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'204.15.20.0/22','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/20','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.144.0/20','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.144.0/21','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.184.0/21','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/21','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'74.119.76.0/22','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.255.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.64.0/18','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.224.0/19','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.224.0/20','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'103.4.96.0/22','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.64.0/19','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.70.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/18','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.24.0/21','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.152.0/21','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'66.220.159.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.239.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.240.0/20','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/19','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.65.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.67.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.68.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.69.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.70.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.71.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.72.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.73.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.74.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.75.0/24','list'=>'FacebookIPs'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.76.0/24','list'=>'FacebookIPs'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.77.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.96.0/19','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.66.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'173.252.96.0/19','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.178.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.78.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.79.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.80.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.82.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.83.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.84.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.85.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.86.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.87.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.88.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.89.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.90.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.91.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.92.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.93.0/24','list'=>'FacebookIPs'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.94.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.95.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.171.253.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'69.63.186.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'31.13.81.0/24','list'=>'FacebookIPs'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.192.0/22','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.192.0/24','list'=>'FacebookIPs'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.193.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.194.0/24','list'=>'FacebookIPs'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'179.60.195.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.216.0/22','list'=>'FacebookIPs'))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'45.64.40.0/22','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.216.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.217.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.218.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    if (enviaComando('/ip/firewall/address-list/add', array('address'=>'185.60.219.0/24','list'=>'FacebookIPs'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tADD FIREWALL FILTER FB Port Knocking 3min access window\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'add-src-to-address-list','address-list'=>'facebook login','address-list-timeout'=>'3m','chain'=>'input', 'comment'=>'FB Port Knocking 3min access window','dst-port'=>'8090','protocol'=>'tcp'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tADD FIREWALL FILTER FB Block no auth customers\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'drop','chain'=>'input', 'comment'=>'FB Block no auth customers','connection-mark'=>'FBConexion','hotspot'=>'!auth','src-address-list'=>'!facebook login'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tADD FIREWALL FILTER place hotspot rules here\n\t----------------------\n\t");
    
    if(enviaComando('/ip/firewall/filter/add', array('action'=>'passthrough','chain'=>'unused-hs-chain', 'comment'=>'place hotspot rules here','disabled'=>'yes'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
  
  
    print_r("\t---------------------\n\tADD FIREWALL MANGLE FB Connection Mark\n\t----------------------\n\t");
    
    if(enviaComando('/ip/firewall/mangle/add', array('action'=>'mark-connection','chain'=>'prerouting', 'comment'=>'FB Connection Mark ','dst-address-list'=>'FacebookIPs','new-connection-mark'=>'FBConexion'))){
        
      print_r("==> OK <==\n\n");
       
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tADD FIREWALL NAT place hotspot rules here\n\t----------------------\n\t");
    
    if(enviaComando('/ip/firewall/nat/add', array('action'=>'passthrough','chain'=>'unused-hs-chain', 'comment'=>'place hotspot rules here','disabled'=>'yes'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tADD FIREWALL NAT masquerade hotspot network\n\t----------------------\n\t");
    
    if(enviaComando('/ip/firewall/nat/add', array('action'=>'masquerade','chain'=>'srcnat', 'comment'=>'masquerade hotspot network','out-interface'=>'bridge5_WAN'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tADD FIREWALL NAT Drop conexiones https cuando unAuth\n\t----------------------\n\t");
    
    if(enviaComando('/ip/firewall/nat/add', array('action'=>'add-dst-to-address-list','address-list'=>'fb','chain'=>'pre-hotspot', 'comment'=>'Drop conexiones https cuando unAuth','dst-address'=>'!176.28.102.26','dst-address-list'=>'!FacebookIPs','dst-address-type'=>'!local','dst-port'=>'443','hotspot'=>'!auth','protocol'=>'tcp', 'to-ports'=>'80'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    /********************************************
     * ¿METER EN PARTE DE HOTSPOT MAS ARRIBA?   |
     * *****************************************/
    
    
    print_r("\t------------------------------------------\n\tHOTSPOT USER ADD SBBOSCOSOS PROFILE TECNICO\n\t-------------------------------------------\n\t");
    
    if(enviaComando('/ip/hotspot/user/add', array('name'=>$server.'_SBBOSCOSOS','password'=>'SBBOSCOSOS','profile'=>'tecnico', 'server'=>$server))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
     print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD www.apple.com\n\t----------------------\n\t"); 
     
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.apple.com"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD www.airport.us\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.airport.us"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD www.itools.info\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.itools.info"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD www.appleiphonecell.com\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.appleiphonecell.com"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD captive.apple.com\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"captive.apple.com"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD www.thinkdifferent.us\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.thinkdifferent.us"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD wifipremium.com\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"wifipremium.com", "dst-port"=>"443"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD www.ibook.info\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.ibook.info"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("---ERROR: No se ha podido añadir www.ibook.info\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD *akamai*\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"*akamai*"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD *fbcdn*\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"*fbcdn*"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN ADD *facebook*\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/add', array("dst-host"=>"*facebook*"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tHOTSPOT WALLED GARDEN IP ADD VPS\n\t----------------------\n\t"); 
    
    if(enviaComando('/ip/hotspot/walled-garden/ip/add', array("action"=>"accept",'comment'=>'VPS','disabled'=>'no','dst-address'=>'176.28.102.26'))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    

    
    
    
    
        /* Borrado de ficheros del router */
    $API->write('/file/getall');
    $READ = $API->read();
    // print_r($READ);
    foreach($READ as $key => $value){
        if(strpos($value['name'], 'backup') == false){
            $API->comm('/file/remove', array("numbers"=>$value['.id']));
        }
    }
    
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/alogin.html\n\t----------------------\n\t"); 
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/alogin.html","dst-path"=>"hotspot/alogin.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/averia.jpg\n\t----------------------\n\t"); 
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/averia.jpg","dst-path"=>"hotspot/averia.jpg"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    


    print_r("\t---------------------\n\tFETCH hotspot/error.html\n\t----------------------\n\t"); 
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/error.html","dst-path"=>"hotspot/error.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/errors.txt\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/errors.txt","dst-path"=>"hotspot/errors.txt"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/interneterror.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/interneterror.html","dst-path"=>"hotspot/interneterror.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspotserial-login.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/".$hotspotserial."-login.html","dst-path"=>"hotspot/login.html"))){
        
         print_r("==> OK <==\n\n");
         
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/logoservibyte.png\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logoservibyte.png","dst-path"=>"hotspot/logoservibyte.png"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/logout.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logout.html","dst-path"=>"hotspot/logout.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/md5.js\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/md5.js","dst-path"=>"hotspot/md5.js"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/radvert.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/radvert.html","dst-path"=>"hotspot/radvert.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    print_r("\t---------------------\n\tFETCH hotspot/redirect.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/redirect.html","dst-path"=>"hotspot/redirect.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/rlogin.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/rlogin.html","dst-path"=>"hotspot/rlogin.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/status.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/status.html","dst-path"=>"hotspot/status.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/testinternet.txt\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/testinternet.txt","dst-path"=>"hotspot/testinternet.txt"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/img/logobottom.png\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/img/logobottom.png","dst-path"=>"hotspot/img/logobottom.png"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/lv/alogin.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/alogin.html","dst-path"=>"hotspot/lv/alogin.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/lv/errors.txt\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/errors.txt","dst-path"=>"hotspot/lv/errors.txt"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/lv/login.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/login.html","dst-path"=>"hotspot/lv/login.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/lv/logout.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/logout.html","dst-path"=>"hotspot/lv/logout.html"))){
        
      print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/lv/radvert.html\n\t----------------------\n\t");
    
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/radvert.html","dst-path"=>"hotspot/lv/radvert.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/lv/status.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/status.html","dst-path"=>"hotspot/lv/status.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/xml/alogin.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/alogin.html","dst-path"=>"hotspot/xml/alogin.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/xml/error.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/error.html","dst-path"=>"hotspot/xml/error.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/xml/flogout.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/flogout.html","dst-path"=>"hotspot/xml/flogout.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/xml/login.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/login.html","dst-path"=>"hotspot/xml/login.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/xml/logout.htmll\n\t----------------------\n\t");
   
    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/logout.html","dst-path"=>"hotspot/xml/logout.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/xml/rlogin.html\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/rlogin.html","dst-path"=>"hotspot/xml/rlogin.html"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    print_r("\t---------------------\n\tFETCH hotspot/xml/WISPAccessGatewayParam.xsd\n\t----------------------\n\t");

    if(enviaComando('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/WISPAccessGatewayParam.xsd","dst-path"=>"hotspot/xml/WISPAccessGatewayParam.xsd"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tSYTEM NOTE SET\n\t----------------------\n\t");
    
    if(enviaComando('/system/note/set', array('note'=>"\r \********************************************************\ \r\r\r\r    _____                 _ __          __     \r   / ___/___  ______   __(_) /_  __  __/ /____  \r   \\__ \\/ _ \\/ ___/ | / / / __ \\/ / / / __/ _ \\  \r  ___/ /  __/ /   | |/ / / /_/ / /_/ / /_/  __/  \r /____/\\___/_/    |___/_/_.___/\\__, /\\__/\\___/ \r                              /____/           \r \r http://www.servibyte.com         info@servibyte.com\r\r CC Meloneras Playa Local 201-202, 35100 Maspalomas,\r Las Palmas, Canary Islands, Spain\r\r\r UNAUTHORIZED ACCESS TO THIS DEVICE IS PROHIBITED\r\r You must have explicit, authorized permission to access or\r configure this device.\r Unauthorized attempts and actions to access or use this system\r may result in civil and/or criminal penalties.\r ALL activities performed on this device are logged and monitored.\r\r\r"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    /*******************************************************************
     * NO FUNCIONA EN TODOS LOS MODELOS, EN ALGUOS NO ESTA ESTA OPCION |
     * ****************************************************************/
    

    print_r("\t---------------------\n\tSET PROTECTED-ROUTERBOOT\n\t----------------------\n\t");
    
    if(enviaComando('/system/routerboard/settings/set', array("protected-routerboot"=> "enabled"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tADD SCRIPT TESTINTERNET\n\t----------------------\n\t");

    if(enviaComando('/system/script/add', array("name"=> "testinternet", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":global internetactivo;\r if (\$internetactivo!=0 && \$internetactivo!=1) do={\r:set internetactivo 0;:log error \"Comienza Test Internet\";/file print file=\$myfile; /file set \$file contents=\"interneterror.html\";/ip dns static enable [find comment~\"Capturador\"]}:local myfile \"hotspot/testinternet\";:local file (\$myfile);:local pingresultado [/ping 4.2.2.4 count=5];:if (\$pingresultado>0) do={:if (\$internetactivo=0) do={:log error \"Internet funcionando\";:set internetactivo 1;/file print file=\$myfile /file set \$file contents=\"https:wifipremium.com/login.php\";/ip dns static disable [find comment~\"Capturador\"] } :if (\$pingresultado=0) do={:if (\$internetactivo=1) do={:log error \"Internet caido\";:set internetactivo 0;/file print file=\$myfile /file set \$file contents=\"interneterror.html\"; /ip dns static enable [find comment~\"Capturador\"] }}"))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tADD SCHEDULER TESTINTERNET\n\t----------------------\n\t");
        
        if(enviaComando('/system/scheduler/add', array("disabled"=> "yes", 'interval'=>'5s', 'name'=>'testinternet', 'on-event'=>'testinternet,', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jun/30/2016', 'start-time'=>'07:39:10'))){
            
            print_r("==> OK <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tADD SCRIPT HOTSPOT\n\t----------------------\n\t");
    
    if(enviaComando('/system/script/add', array("name"=> "hotspot", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>"execute \"/tool fetch mode=http address=checkip.dyndns.org src-path=/ dst-path=d yndns.checkip.html\" :local result [/file get dyndns.checkip.html contents] :local resultLen [:len \$result] :local startLoc [:find \$result \": \" -1] :set startLoc (\$startLoc + 2) :local endLoc [:find \$result \"</body>\" -1] :local currentIP [:pick \$result \$startLoc \$endLoc] { :local activo 0; :foreach i in=[/system logging find] do={ :if ([/system logging get \$i topics]=\"firewall\") do={ :set activo 1 } }; :log warning (\":coronablanca::hotspot::up:\" . [/system resource get uptime] . \";cpu-load:\" . [/system resource get cpu-load] . \";active:\" . [/ip hotspot active print count-only]  . \";trazabilidad:\" . \$activo. \";ip:\" . \$currentIP)}"))){
        
        print_r("==> OK <==\n\n");
        
        print_r("\t---------------------\n\tADD SCHEDULER HOTSPOT\n\t----------------------\n\t");
        
        if(enviaComando('/system/scheduler/add', array('interval'=>'15m', 'name'=>'hotspot', 'on-event'=>'hotspot,', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'))){
            
            print_r("==> OK <==\n\n");
            
        }else print_r("==> ERROR <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
     
    print_r("\t---------------------\n\tADD SCRIPT delete_user_test\n\t----------------------\n\t");
    
    if(enviaComando('/system/script/add', array("name"=> "delete_user_test", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":local usertoremove \"VEQODE68\";:local banuser \"noname\";:local banuseridle 00:00:00;:local banusermac \"00:00:00:00:00:00\";:local banuserip \"0.0.0.0\"; :foreach i in [/ip hotspot active find where user~\$usertoremove] do={ :local idle [/ip hotspot active get \$i idle-time]; :if (\$idle>=\$banuseridle) do={:set banuser \$i;:set banuseridle \$idle;:set banusermac [/ip hotspot active get \$i mac-address];:set banuserip [/ip hotspot active get \$i address];}}:if (\$banuser != \"noname\") do={:log warning (\"Usuario \".\$usertoremove.\" con Sesion ID: \".\$banuser.\" y Idle-Time: \".\$banuseridle.\" ha sido banneado\");:log warning (\"MAC: \".\$banusermac);:log warning (\"IP: \".\$banuserip); #:ip hotspot active remove \$banuser;}"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tADD SCRIPT find_no_more_sessions_test\n\t----------------------\n\t");
    
    if(enviaComando('/system/script/add', array("name"=> "find_no_more_sessions_test", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>" :global lastTime; :local currentBuf [ :toarray [ /log find message~\"no more sessions\" ]] ; :local currentLineCount [ :len \$currentBuf ] ; if (\$currentLineCount > 0) do={ :local currentTime \"\$[ /log get [ :pick \$currentBuf (\$currentLineCount -1) ] time ]\"; :if ([:len \$currentTime] = 15 ) do={  :set currentTime [ :pick \$currentTime 7 15 ];} :local output \"\$currentTime \$[/log get [ :pick \$currentBuf (\$currentLineCount-1) ] message ]\"; :if ([:len \$lastTime] < 1 ) do={ :set lastTime \$currentTime ; if ( [:find \$output \"Moises logged in\" -1] != 0) do={ :log warning (\$currentTime . \" No more sessions encontrado\"); } } else={ :if ( \$lastTime != \$currentTime ) do={ :set lastTime \$currentTime ; if ( [:find \$output \"Moises logged in\" -1] != 0) do={ :log warning (\$currentTime . \" No more sessions encontrado\"); }}}"))){
        
        print_r("==> OK <==\n\n");
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    
    
    
    print_r("\t---------------------\n\tADD SCRIPT genera_no_more_sessions\n\t----------------------\n\t");
    
    if(enviaComando('/system/script/add', array("name"=> "genera_no_more_sessions", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>":log warning \"coronablanca_KUBAGE59 (172.21.32.170): login failed: no more sessions are allowed for user\";"))){
        
        print_r("==> OK <==\n\n");  
        
    }else print_r("==> ERROR <==\n\n");
    
    
    
    
    
    
    
    // print_r("\t---------------------\n\tDELETE DHCP-CLIENT ON ETHER1\n\t----------------------\n\t");
    
    // $API->write('/ip/dhcp-client/print');
    // $READ = $API->read();
    // print_r($READ);
    
    // foreach ($READ as $key => $value) {
    //     if(enviaComando('/ip/dhcp-client/', array("numbers"=> $value['.id']))){
        
    //         print_r("==> OK <==\n\n");  
            
    //     }else print_r("==> ERROR <==\n\n");
    // }
  
    
    
    
    
    
    
    
    
    
    
    $API->disconnect();
    
}else{
    
    print_r("Hay problemas con la conexión. Revise los parámetros y la conectividad.\n");
    
}


/*------------------------------------------------------------------------------
    enviaComando(): función que recibe como parámetros un comando (string) 
                    y sus opciones (array). Ejecuta el comando como máximo
                    dos veces antes de salir y enviar mensaje de error.
    
    Parámetros necesarios:
        - $comando: string que represena el comando a ejecutar
        - $opciones: array de parámetros que se pasan con el comando
        - $server: nombre del hotspot
        - $id_server: ID del hotspot
        - $ip: IP asignada al Mikrotik (hay que crear DHCP Client en ether1)
------------------------------------------------------------------------------*/

function enviaComando($comando, $opciones){
    
    global $API;
    
    print_r("\t\tEjecutando comando... Intento 1...  ");
    
    $res = $API->comm($comando, $opciones);
    
    // COMPROBAR POR QUE A VECES DEVUELVE ARRAYS Y OTRAS STRINGS
    if (!empty($res) && (gettype($res) == 'array') && (array_key_exists ('!trap',$res))){
        
        print_r("\t\tERROR: Ha ocurrido un problema, volviendo a intentar...\n");
        
        sleep(1);
        
        print_r("\t\tEjecutando comando... Intento 2...  ");
        
        $res = $API->comm($comando, $opciones);
        
        if (!empty($res) && (gettype($res) == 'array') && (array_key_exists ('!trap',$res))){
        
            print_r("\t\tERROR: No se ha podido realizar la operación.\n\n");
        
            file_put_contents("MikroTikAPIerrorLog", "Error: ".$comando." => ".print_r($opciones, true)."\r\n".print_r($res, true)."\r\n", FILE_APPEND);
        
            return false;
            
        } else return true;
        
    } else return true;
    
}

?>