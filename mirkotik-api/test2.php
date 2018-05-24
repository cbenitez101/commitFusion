<?php
/* Se utiliza la version de Denis Basta */
require_once('scripts/routeros-api/routeros_api.class.php');


// $ip = '192.168.45.62';   //941
// $ip = '192.168.45.94';   //951
// $ip = '192.168.45.69';   //2011
// $ip = '192.168.45.75';   //952
$user = 'admin';
$pass = '';
$API = new RouterosAPI();
$API->debug = false;
if ($API->connect($ip, $user, $pass)) {
    
    
    
    // /* Resetea MikroTik y ejecuta el script inicio */
    // // print_r("->Resetea MikroTik y ejecuta el script inicio\n");
    // // $res = $API->comm('/system/reset-configuration', array('no-defaults'=>'yes','skip-backup'=>'yes', 'run-after-reset'=>'inicio.rsc'));
    
    
    
    // // print_r("->Poner Servidores google");
    // $API->write('/ip/dns/print');
    // $READ = $API->read();
    // if ($READ[0]['servers'] == ''){
    //     $res = $API->comm('/ip/dns/set', array("servers"=>"8.8.8.8, 8.8.4.4", "allow-remote-requests"=>"true"));
    //      // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    // } 
   
   
    // print_r("-> Dar nombre al system identity\n");
    // $res = $API->comm('/system/identity/set', array("name"=>'Christo_API'));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");

    
    // print_r("-> Añadir cliente NTP y establecer zona horaria\n");
    // // SE AÑADE Cliente NTP
    // $res = $API->comm('/system/ntp/client/set', array('enabled'=>'yes', 'primary-ntp'=>'130.206.3.166'));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    // $res = $API->comm('/system/clock/set', array("time-zone-name"=>'Atlantic/Canary', "time-zone-autodetect" => "no"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    
    // print_r("-> Se crean los bridges\n");
    // $res = $API->comm('/interface/bridge/add', array("name"=>'bridge1_hs_clientes1', 'protocol-mode'=>'none'));
    // $res = $API->comm('/interface/bridge/add', array("name"=>'bridge2_hs_clientes2', 'protocol-mode'=>'none'));
    // $res = $API->comm('/interface/bridge/add', array("name"=>'bridge3_hs_staff', 'protocol-mode'=>'none'));
    // $res = $API->comm('/interface/bridge/add', array("name"=>'bridge4_administracion', 'protocol-mode'=>'none'));
    // $res = $API->comm('/interface/bridge/add', array("name"=>'bridge5_WAN', 'protocol-mode'=>'none'));
    // $res = $API->comm('/interface/bridge/add', array("name"=>'bridge_trunk', 'protocol-mode'=>'none'));
    
    // print_r("-> Se crean las VLAN's\n");
    // $res = $API->comm('/interface/vlan/add', array('name'=>'vlan1001_br-trunk_clientes1', 'vlan-id'=> '1001', 'interface'=>'bridge_trunk'));
    // $res = $API->comm('/interface/vlan/add', array('name'=>'vlan1002_br-trunk_clientes2', 'vlan-id'=> '1002', 'interface'=>'bridge_trunk'));
    // $res = $API->comm('/interface/vlan/add', array('name'=>'vlan1003_br-trunk_staff', 'vlan-id'=> '1003', 'interface'=>'bridge_trunk'));
    // $res = $API->comm('/interface/vlan/add', array('name'=>'vlan1004_br-trunk_adm', 'vlan-id'=> '1004', 'interface'=>'bridge_trunk'));
    
    // print_r("-> Interfaces Wifi\n");
    // $API->write('/interface/wireless/getall');
    // $READ = $API->read();
    // print_r($READ);
    // if(count($READ) > 0){
    //     // Comprueba que haya interfaz wifi
    //     if (!array_key_exists('!trap', $READ)) {
    //         $res = $API->comm('/interface/wireless/security-profiles/add', array('authentication-types'=>'wpa-psk,wpa2-psk', 'eap-methods'=>"", 'management-protection'=>'allowed', 'mode'=>'dynamic-keys', 'name'=>'profile_staff', 'supplicant-identity'=>'', 'wpa-pre-shared-key'=>'API_sb_staff', 'wpa2-pre-shared-key'=>'API_sb_staff'));
    //         foreach ($READ as $key => $value) {
    //             $res = $API->comm('/interface/wireless/set', array("numbers"=> $key,"disabled"=>"no", "mode"=>"ap-bridge", "band"=>((strstr($value['band'],'2ghz'))?"2ghz-b/g/n":"5ghz-a/n/ac"), "channel-width"=>"20mhz", "frequency"=>((strstr($value['band'],'2ghz'))?2437:5240), "wireless-protocol"=>"802.11", "default-forwarding"=>"no", "ssid"=>"MIKROTIKAPI","radio-name"=>"MIKROTIKAPI", "name"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5')));
                
    //             /* Ponemos ya el discovery=no */
    //             $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5'),'discover'=>'no'));
                
    //             $res = $API->comm('/interface/bridge/port/add', array("bridge"=> "bridge1_hs_clientes1","interface"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5')));
    //             //Se añaden los Ap virtuales deshabilitados
    //             $res = $API->comm('/interface/wireless/add', array("disabled"=>'yes', "keepalive-frames"=>"disabled", "master-interface"=>((strstr($value['band'],'2ghz'))?'wireless2':'wireless5'), "multicast-buffering"=>"disabled", "name"=>"MIKROTIKAPI_Staff_".((strstr($value['band'],'2ghz'))?"2":"5"), "ssid"=>"MIKROTIKAPI_Staff", "wds-cost-range"=>0, "wds-default-cost"=>0, "wps-mode"=>"disabled", "mac-address"=>"0".$key.substr($value['mac-address'], 2),'security-profile'=>'profile_staff'));
    //             $res = $API->comm('/interface/bridge/port/add', array("bridge"=> "bridge3_hs_staff","interface"=>"MIKROTIKAPI_Staff_".((strstr($value['band'],'2ghz'))?"2":"5")));
    //         }
            
    //     }
    //  }
   
   


    // print_r("-> Agregamos comentarios a las interfaces y añadimos los puertos a los bridges corresp.\n");
    // $res = $API->write('/interface/ethernet/getall');
    // $READETHER = $API->read();
    
    // $res = $API->write('/system/routerboard/getall');
    // $READ = $API->read();
    
    // if(count($READ) > 0){
    //     if (!array_key_exists('!trap', $READ) && !array_key_exists('!trap', $READETHER)){
    //         print_r("MODEL: ".$READ[0]['model']."\n");
    //         // $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge5_WAN','interface'=>'ether1'));
    //         $res = $API->comm('/interface/set', array('numbers'=>'ether2','comment'=>'ether2_clientes1'));
    //         /* Se añaden comentarios a las distintas interfaces */
    //         if (strstr($READ[0]['model'],'941') > -1 || strstr($READ[0]['model'],'951') > -1 || strstr($READ[0]['model'],'952') > -1) {
    
    //             $res = $API->comm('/interface/set', array('numbers'=>'ether3','comment'=>'ether3_adm'));
    //             $res = $API->comm('/interface/set', array('numbers'=>'ether4','comment'=>'ether4_trunk'));
    //             /* Se añaden los puertos al bridge correspondiente */
    //             $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge1_hs_clientes1','interface'=>'ether2'));
    //             $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge4_administracion','interface'=>'ether3'));
    //             $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>'ether4'));
    //             /* Se deshabilita interface de admin */
    //             $res = $API->comm('/interface/disable', array('numbers'=>'ether3'));
    //             /* Dependiendo del modelo con el que estemos operando realizamos */ 
    //             if (strstr($READ[0]['model'],'951') > -1 || strstr($READ[0]['model'],'952') > -1){
    //                 /* Si estamos trabajando con los modelos 951 o 952 incluimos tambien ether5*/
    //                 $res = $API->comm('/interface/set', array('numbers'=>'ether5','comment'=>'ether5_trunk'));
    //                 $res = $API->comm('/interface/disable', array('numbers'=>'ether5'));
    //                 $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>'ether5'));
    //             }
    //         } else if(strstr($READ[0]['model'],'1009') > -1 || strstr($READ[0]['model'],'1100') > -1 || strstr($READ[0]['model'],'2011') > -1 || strstr($READ[0]['model'],'3011') > -1){
                
    //             $res = $API->comm('/interface/set', array('numbers'=>'ether3','comment'=>'ether3_clientes2'));
    //             $res = $API->comm('/interface/set', array('numbers'=>'ether4','comment'=>'ether4_staff'));
    //             $res = $API->comm('/interface/set', array('numbers'=>'ether5','comment'=>'ether5_adm'));
                
    //             $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge1_hs_clientes1','interface'=>'ether2'));
    //             $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge2_hs_clientes2','interface'=>'ether3'));
    //             $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge3_hs_staff','interface'=>'ether4'));
    //             $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge4_administracion','interface'=>'ether5'));
                
    //             $res = $API->comm('/interface/disable', array('numbers'=>'ether5'));
       
    //             for($i=5; $i <= (count($READETHER) - 1); $i++){
        
    //                     // METODO 1: Se utiliza contador para acceder a las distintas ether
    //                     // $res = $API->comm('/interface/set', array('numbers'=>'ether'.($i + 1),'comment'=>'ether'.($i + 1).'_trunk'));
    //                     // $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>'ether'.($i + 1)));
                        
                        
    //             //         // METODO 2: Se utiliza el name para acceder a las ether
    //             // if ($READETHER[$i]['name'] == 'ether11') {
    //                 // $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge5_WAN','interface'=>$READETHER[$i]['name']));
    //             // } else {
    //                 $res = $API->comm('/interface/set', array('numbers'=>$READETHER[$i]['name'],'comment'=>$READETHER[$i]['name'].'_trunk'));
    //                 $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>$READETHER[$i]['name'])); 
    //             // }
                  
                      
                        
    //             //         // METODO 3: Se utiliza el default-name para acceder a las ether
    //             //         $res = $API->comm('/interface/set', array('numbers'=>$READETHER[$i]['default-name'],'comment'=>$READETHER[$i]['default-name'].'_trunk'));
    //             //         $res = $API->comm('/interface/bridge/port/add', array('bridge'=>'bridge_trunk','interface'=>$READETHER[$i]['default-name'])); 
    //             }
    
                   
    //         }
       
            
    //     }
        
           
        
        
    // }
    
    // print_r("-> Conexion a VPN.\n");
    // // $res = $API->comm('/interface/pptp-client/add', array('connect-to'=>'217.125.25.165','disabled'=>'no', 'mrru'=>'1600', 'name'=>'Servibyte VPN', 'password'=>'sbyte', 'user'=>'PantallaSB'));

    // print_r("-> Deshabilitar discovery de las interfaces\n");
    // /* PARTE DE DISCOVERY=NO DE LAS INTERFACES */
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'ether1','discover'=>'no'));
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'bridge1_hs_clientes1','discover'=>'no'));
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'bridge2_hs_clientes2','discover'=>'no'));
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'bridge3_hs_staff','discover'=>'no'));
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'vlan1001_br-trunk_clientes1','discover'=>'no'));
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'vlan1002_br-trunk_clientes2','discover'=>'no'));
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'vlan1003_br-trunk_staff','discover'=>'no'));
    // $res = $API->comm('/ip/neighbor/discovery/set', array('numbers'=>'vlan1004_br-trunk_adm','discover'=>'no'));
    // /* FIN PARTE DE DISCOVERY=NO DE LAS INTERFACES */        
   
    
    // print_r("-> Logging - Action\n");
    // /* PARTE DE LOGGING --DUPLICADO--*/
    // $res = $API->comm('/system/logging/action/set', array('numbers'=>'memory', 'memory-lines'=>'100'));
    // $res = $API->comm('/system/logging/action/set', array('numbers'=>'disk', 'disk-lines-per-file'=>'100'));
    // $res = $API->comm('/system/logging/action/add', array('name'=>'SBRemote', 'remote'=>'217.125.25.165', 'target'=>'remote'));
    // /* FIN PARTE DE LOGGING */
   
    
    // print_r("-> Filter\n");
    // /*PARTE DE FILTER*/
    // $res = $API->comm('/ip/firewall/filter/add', array('chain'=>'forward','comment'=>'establecidas', 'connection-state'=>'established'));
    // $res = $API->comm('/ip/firewall/filter/add', array('chain'=>'input', 'connection-state'=>'established'));
    // $res = $API->comm('/ip/firewall/filter/add', array('chain'=>'forward','comment'=>'relacionadas', 'connection-state'=>'related'));
    // $res = $API->comm('/ip/firewall/filter/add', array('chain'=>'input', 'connection-state'=>'related'));
    // $res = $API->comm('/ip/firewall/filter/add', array('action'=>'drop','chain'=>'forward','comment'=>'invalidas', 'connection-state'=>'invalid'));
    // $res = $API->comm('/ip/firewall/filter/add', array('action'=>'drop', 'chain'=>'input', 'connection-state'=>'invalid'));
    // $res = $API->comm('/ip/firewall/filter/add', array('action'=>'tarpit', 'chain'=>'forward', 'comment'=>'Port Scan Detection', 'protocol'=>'tcp', 'psd'=>'21,3s,3,1'));
    // $res = $API->comm('/ip/firewall/filter/add', array('chain'=>'input', 'comment'=>'ICMP <10 PPS sino drop', 'limit'=>'10,0:packet', 'protocol'=>'icmp'));
    // $res = $API->comm('/ip/firewall/filter/add', array('action'=>'drop', 'chain'=>'input', 'protocol'=>'icmp'));
    // /*FIN PARTE DE FILTER*/
    
    
    
    
    
    
    // print_r("-> Scripts y Scheduler para script Monitorizacion\n");
    // /*PARTE DE SCRIPTS Y SCHEDULER ---FALTAN SCRIPTS---- */
    // $res = $API->comm('/system/scheduler/add', array('interval'=>'15m', 'name'=>"Monitorizacion",'on-event'=>'Monitorizacion', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/01/2016', 'start-time'=>'00:00:00'));
    // $res = $API->comm('/system/script/add', array('name'=>'Monitorizacion', 'owner'=>"administrador",'policy'=>' ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'source'=>":log warning (\":API::Air1::up:\" .[/system resource get uptime] . \";cpu-load:\" . [/system resource get cpu-load] . \";connected:\" . [/interface wireless registration-table print count-only])"));
    // /*FIN PARTE DE SCRIPTS Y SCHEDULER*/
    
    
    
    
    
    
    
    
    
    
    // print_r("-> Añadimos layer7 protocol en Firewall\n");
    // /* PARTE FALTANTE DE PRIMER SCRIPT */

    // $res = $API->comm('/ip/firewall/layer7-protocol/add', array("name"=>"facebook","regexp"=>"^.+(facebook.com).*\$"));
    // // print_r($res);
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");



    // $res = $API->comm('/ip/firewall/layer7-protocol/add', array("name"=>"facebook2","regexp"=>".+(facebook.com)*dialog"));
    // // print_r($res);
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
     
     
     

    // $res = $res = $API->comm('/ip/firewall/layer7-protocol/add', array("name"=>"facebook3","regexp"=>".+(facebook.com)*login"));
    // // print_r($res);
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
     
    
    // print_r("-> Fetch de los certificados\n");
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.crt"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");



    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.ca-crt"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    
    
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot.key"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");







    // print_r("-> Import de los certificados\n");
    // $res = $API->comm('/certificate/import', array("file-name"=> "certificate.crt", "passphrase"=>"PwpXXf8bPwpXXf8b"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    
    
    // $res = $API->comm('/certificate/import', array("file-name"=> "hotspot.key", "passphrase"=>"PwpXXf8bPwpXXf8b"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
   
   
   
    // $res = $API->comm('/certificate/import', array("file-name"=> "certificate.ca-crt", "passphrase"=>"PwpXXf8bPwpXXf8b"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    
    
    
    // print_r("-> SNMP.\n");     

    // $res = $API->comm('/snmp/set', array("enabled"=> "yes", "contact"=> "info@servibyte.com", "location"=>"Maspalomas", "trap-community"=>"public", "trap-version"=>"2", "trap-generators"=>"interfaces", "trap-interfaces"=>"all" ));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    
    // print_r("-> Config. de tool email.\n"); 
    // $res = $API->comm('/tool/e-mail/set', array("address"=> "74.125.206.108", "port"=> "587", "start-tls"=>"yes", "from"=>"servibyte.log@gmail.com", "user"=>"Servibyte.log", "password"=>"sbyte_14_Mxz"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    
    // $res = $API->comm('/system/logging/action/add', array("name"=> "email", "target"=> "email", "email-to"=>"servibyte.log@gmail.com", "email-start-tls"=>"yes"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/sys-note.txt"));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    
    // /* FIN PARTE FALTANTE PRIMER SCRIPT */
    
    
    
 
    // print_r("-> Ip services\n");   
    // $res = $API->comm('/ip/service/set', array("numbers"=>"telnet",'disabled'=>'yes'));
    // $res = $API->comm('/ip/service/set', array("numbers"=>"ftp",'disabled'=>'yes'));
    // $res = $API->comm('/ip/service/set', array("numbers"=>"www",'disabled'=>'yes'));
    // $API->comm('/ip/service/set', array("numbers"=>"www-ssl",'certificate'=>'certificate.crt_0','disabled'=>'no'));
    
    
    
    
    //  print_r("-> Perfiles y usuarios del hotspot\n");     
    // /* PARTE HOTSPOT */
    // $res = $API->comm('/ip/hotspot/profile/set', array('numbers'=>'default','html-directory'=>'flash/hotspot'));
    
    // $res = $API->comm('/ip/hotspot/profile/add', array('dns-name'=>'hotspot.wifipremium.com', 'hotspot-address'=>'172.21.0.1','http-cookie-lifetime'=>'1w', 'login-by'=>'cookie,http-chap,https,mac-cookie','name'=>'hsprof1'/*, 'ssl-certificate'=>'certificate.crt_0'*/, 'use-radius'=>'yes'));
    
    // $res = $API->comm('/ip/hotspot/add', array('disabled'=>'no', 'idle-timeout'=>'none','interface'=>'bridge1_hs_clientes1','name'=>'API', 'profile'=>'hsprof1'));
    // $res = $API->comm('/ip/hotspot/user/profile/set', array('numbers'=>'default', 'keepalive-timeout'=>'1w','mac-cookie-timeout'=>'1w','rate-limit'=>'3M/3M', 'shared-users'=>'3'));
    // $res = $API->comm('/ip/hotspot/user/profile/add', array('name'=>'tecnico', 'transparent-proxy'=>'yes','shared-users'=>'5'));
    // $res = $API->comm('/ip/hotspot/user/profile/add', array('keepalive-timeout'=>'1w', 'mac-cookie-timeout'=>'1w','name'=>'uprof1','rate-limit'=>'5M/10M', 'shared-users'=>'3'));
    // /* FIN PARTE HOTSPOT */
    
    
    
    // print_r("-> Se añaden las pool\n");  
    // /*PARTE POOL */
    // $res = $API->comm('/ip/pool/add', array('name'=>'hs-pool-14', 'ranges'=>'172.21.0.2-172.21.255.254'));
    // $res = $API->comm('/ip/pool/add', array('name'=>'pool_adm', 'ranges'=>'172.20.0.2-172.20.0.254'));
    // $res = $API->comm('/ip/pool/add', array('name'=>'pool_staff', 'ranges'=>'192.168.50.2-192.168.50.254'));
    // /*FIN PARTE POOL */
    
    
    
    // print_r("-> Se añaden acciones a logging\n");  
    // /*PARTE LOGGING */
    // /*ACTIONS*/
    // // $res = $API->comm('/system/logging/action/set', array('numbers'=>'0', 'memory-lines'=>'3000'));
    // $res = $API->comm('/system/logging/action/add', array('name'=>'SBRemote', 'remote'=>'217.125.25.165','target'=>'remote'));
    // $res = $API->comm('/system/logging/action/add', array('name'=>'HotspotInfo', 'memory-lines'=>'3000','target'=>'memory'));
    // $res = $API->comm('/system/logging/action/add', array('name'=>'HotspotDebug', 'memory-lines'=>'3000','target'=>'memory'));
    
    // /*NOACTIONS*/
    
    //      /*COMIENZO LOGGING */
    //     $res = $API->comm('/system/logging/add', array('action'=>'SBRemote', 'prefix'=>'Monitor', 'topics'=>'warning,script'));
    //     $res = $API->comm('/system/logging/add', array('action'=>'HotspotInfo', 'topics'=>'hotspot,info'));
    //     $res = $API->comm('/system/logging/add', array('action'=>'HotspotDebug', 'topics'=>'hotspot,debug'));
    //     /*FIN COMIENZO LOGGING */
    // /*FIN PARTE LOGGING */
    
    
    
    
    
    // print_r("-> Creacion de los servidores DHCP\n");  
    // /*PARTE DHCP SERVER */
    // $res = $API->comm('/ip/dhcp-server/add', array('address-pool'=>'hs-pool-14', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge1_hs_clientes1','lease-time'=>'1w','name'=>'dhcp1'));
    // $res = $API->comm('/ip/dhcp-server/add', array('address-pool'=>'pool_adm', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge4_administracion','name'=>'dhcp_adm'));
    // $res = $API->comm('/ip/dhcp-server/add', array('address-pool'=>'pool_staff', 'authoritative'=>'yes','disabled'=>'no','interface'=>'bridge3_hs_staff','name'=>'dhcp_staff'));
    // /*FIN PARTE DHCP SERVER */
    
    
    
    
    // print_r("-> Se establece enc-algorithm a IP > Proposal\n"); 
    // /* PRINCIPIO IPSEC PROPOSAL */
    // $res = $API->comm('/ip/ipsec/proposal/set', array('numbers'=>'default', 'enc-algorithms'=>'aes-128-cbc'));
    // /* PRINCIPIO IPSEC PROPOSAL */
    
    
    
    // print_r("-> Se añaden direcciones estáticas\n"); 
    // /* PRINCIPIO IP ADDRESS */
    // $res = $API->comm('/ip/address/add', array('address'=>'172.21.0.1/16','comment'=>'hotspot network', 'interface'=>'bridge1_hs_clientes1','network'=>'172.21.0.0'));
    // $res = $API->comm('/ip/address/add', array('address'=>'172.20.0.1/22', 'interface'=>'bridge4_administracion','network'=>'172.20.0.0'));
    // $res = $API->comm('/ip/address/add', array('address'=>'192.168.50.1/24','comment'=>'Red Staff/IPTV', 'interface'=>'bridge3_hs_staff','network'=>'192.168.50.0'));
    // /* PRINCIPIO IP ADDRESS */
    
    
    
    
    // /*PARTE DHCP CLIENT */
    // // $res = $API->comm('/ip/dhcp-client/add', array('dhcp-options'=>'hostname,clientid','disabled'=>'no','interface'=>'bridge5_WAN'));
    // // if (!empty($res) && array_key_exists ('!trap',$res)) foreach($res['!trap'] as $key=> $value) print_r('Error '.($key + 1).': '.$res['!trap'][$key]['message']."\n");
    
    // /*FIN PARTE DHCP CLIENT*/
    
    
    
    // print_r("-> Se añaden las network a los DHCP servers\n"); 
    // /*PARTE ADD NETWORKS DHCPSERVER*/
    // $res = $API->comm('/ip/dhcp-server/network/add', array('address'=>'172.20.0.0/22', 'comment'=>'admin network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'172.20.0.1','netmask'=>'22'));
    // $res = $API->comm('/ip/dhcp-server/network/add', array('address'=>'172.21.0.0/16', 'comment'=>'hotspot network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'172.21.0.1','netmask'=>'32'));
    // $res = $API->comm('/ip/dhcp-server/network/add', array('address'=>'192.168.50.0/24', 'comment'=>'staff network','dns-server'=>'8.8.8.8,8.8.4.4','gateway'=>'192.168.50.1','netmask'=>'24'));
    // /*FIN PARTE ADD NETWORKS DHCPSERVER*/
    
    
    
    
    // print_r("-> Entradas estaticas para el DNS\n"); 
    // /*PARTE IP DNS STATIC*/
    // $res = $API->comm('/ip/dns/static/add', array('address'=>'172.21.0.1','name'=>'exit.com'));   
    // $res = $API->comm('/ip/dns/static/add', array('address'=>'172.21.0.1','comment'=>'Capturador DNS cuando no hay internet', 'disabled'=>'yes','regexp'=>".*\\..*"));  
    // /*FIN PARTE IP DNS*/
    
    
    
    
    
    
    
    
    // print_r("-> Se añaden las Adrerss-list\n"); 
    // /*PARTE FIREWALL ADDRESS LIST*/
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'204.15.20.0/22','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/20','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'66.220.144.0/20','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'66.220.144.0/21','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.63.184.0/21','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/21','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'74.119.76.0/22','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.171.255.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'173.252.64.0/18','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.171.224.0/19','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.171.224.0/20','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'103.4.96.0/22','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.63.176.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'173.252.64.0/19','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'173.252.70.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/18','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.24.0/21','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'66.220.152.0/21','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'66.220.159.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.171.239.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.171.240.0/20','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/19','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.64.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.65.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.67.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.68.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.69.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.70.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.71.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.72.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.73.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.74.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.75.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.76.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.77.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.96.0/19','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.66.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'173.252.96.0/19','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.63.178.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.78.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.79.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.80.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.82.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.83.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.84.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.85.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.86.0/24','list'=>'FacebookIPs')); 
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.87.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.88.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.89.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.90.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.91.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.92.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.93.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.94.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.95.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.171.253.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'69.63.186.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'31.13.81.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'179.60.192.0/22','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'179.60.192.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'179.60.193.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'179.60.194.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'179.60.195.0/24','list'=>'FacebookIPs'));    
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'185.60.216.0/22','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'45.64.40.0/22','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'185.60.216.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'185.60.217.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'185.60.218.0/24','list'=>'FacebookIPs'));
    // $res = $API->comm('/ip/firewall/address-list/add', array('address'=>'185.60.219.0/24','list'=>'FacebookIPs'));
    // /*FINPARTE FIREWALL ADDRESS LIST*/   
    
    
    
    // print_r("-> Se añaden entradas del firewall (FILTER, NAT Y MANGLE)\n"); 
    // /* FIREWALL RULES */
    // $res = $API->comm('/ip/firewall/filter/add', array('action'=>'add-src-to-address-list','address-list'=>'facebook login','address-list-timeout'=>'3m','chain'=>'input', 'comment'=>'FB Port Knocking 3min access window','dst-port'=>'8090','protocol'=>'tcp'));
    // $res = $API->comm('/ip/firewall/filter/add', array('action'=>'drop','chain'=>'input', 'comment'=>'FB Block no auth customers','connection-mark'=>'FBConexion','hotspot'=>'!auth','src-address-list'=>'!facebook login'));
    // $res = $API->comm('/ip/firewall/filter/add', array('action'=>'passthrough','chain'=>'unused-hs-chain', 'comment'=>'place hotspot rules here','disabled'=>'yes'));
    
    // $res = $API->comm('/ip/firewall/mangle/add', array('action'=>'mark-connection','chain'=>'prerouting', 'comment'=>'FB Connection Mark ','dst-address-list'=>'FacebookIPs','new-connection-mark'=>'FBConexion'));
    // $res = $API->comm('/ip/firewall/nat/add', array('action'=>'passthrough','chain'=>'unused-hs-chain', 'comment'=>'place hotspot rules here','disabled'=>'yes'));
    // /*bridge5_WAN NO EXISTE*/
    // $res = $API->comm('/ip/firewall/nat/add', array('action'=>'masquerade','chain'=>'srcnat', 'comment'=>'masquerade hotspot network','out-interface'=>'bridge5_WAN'));
    // $res = $API->comm('/ip/firewall/nat/add', array('action'=>'add-dst-to-address-list','address-list'=>'fb','chain'=>'pre-hotspot', 'comment'=>'Drop conexiones https cuando unAuth','dst-address'=>'!176.28.102.26','dst-address-list'=>'!FacebookIPs','dst-address-type'=>'!local','dst-port'=>'443','hotspot'=>'!auth','protocol'=>'tcp', 'to-ports'=>'80'));
    // /* FIN FIREWALL RULES  */
    
    
    
    // print_r("-> IP bindings\n");     
    // /* HOTSPOT IP BINDINGS --COMPROBAR SERVER--*/
    // $res = $API->comm('/ip/hotspot/ip-binding/add', array('address'=>'172.21.9.171','mac-address'=>'04:18:D6:84:83:1A','server'=>'API', 'to-address'=>'172.21.9.171','type'=>'bypassed'));
    // /* FIN HOTSPOT IP BINDINGS */
    
    
    // print_r("-> Se añaden usuarios para el hotspot\n"); 
    // /*PARTE ADD USER A HOTSPOT*/
    // $res = $API->comm('/ip/hotspot/user/add', array('name'=>'API_SBBOSCOSOS','password'=>'SBBOSCOSOS','profile'=>'tecnico', 'server'=>'API'));
    // $res = $API->comm('/ip/hotspot/user/add', array('name'=>'API_AKR_HAB612','password'=>'AKR_HAB612', 'server'=>'API'));
    // $res = $API->comm('/ip/hotspot/user/add', array('name'=>'API_URK0GONZALEZ','password'=>'URK0GONZALEZ','profile'=>'uprof1', 'server'=>'API'));
    // /*FIN PARTE ADD USER A HOTSPOT*/
    
    
    
    
    
    
    // print_r("-> Se añaden entradas para el walled-garden\n"); 
    // /* WALLED GARDEN */
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.apple.com"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.airport.us"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.itools.info"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.appleiphonecell.com"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"captive.apple.com"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.thinkdifferent.us"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.ibook.info"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"wifipremium.com", "dst-port"=>"443"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"*akamai*"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"*fbcdn*"));
    // $res = $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"*facebook*"));
    
    // $res = $API->comm('/ip/hotspot/walled-garden/ip/add', array("action"=>"accept",'comment'=>'VPS','disabled'=>'no','dst-address'=>'176.28.102.26'));
    // /* FIN WALLED GARDEN */
    
    
    
    // print_r("-> Se añade radius\n"); 
    // /* RADIUS */
    // $res = $API->comm('/radius/add', array("address"=>"176.28.102.26",'secret'=>'tachin','service'=>'hotspot','timeout'=>'5s'));
    // /* FIN RADIUS */
    
    
    
    
    
    
    // // /* Borrado de ficheros del router */
    // // $API->write('/file/getall');
    // // $READ = $API->read();
    // // print_r($READ);
    // // foreach($READ as $key => $value){
    // //     if(strpos($value['name'], 'backup') == false){
    // //         $API->comm('/file/remove', array("numbers"=>$value['.id']));
    // //     }
    // // }
    
    
    
    
    // print_r("-> Se realiza el fetch de los ficheros necesarios\n"); 
    // /* PRINCIPIO FETCH */
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/alogin.html","dst-path"=>"hotspot/alogin.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/averia.jpg","dst-path"=>"hotspot/averia.jpg"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/error.html","dst-path"=>"hotspot/error.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/errors.txt","dst-path"=>"hotspot/errors.txt"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/interneterror.html","dst-path"=>"hotspot/interneterror.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/GETSERIALNAME-login.html","dst-path"=>"hotspot/login.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logoservibyte.png","dst-path"=>"hotspot/logoservibyte.png"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logout.html","dst-path"=>"hotspot/logout.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/md5.js","dst-path"=>"hotspot/md5.js"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/radvert.html","dst-path"=>"hotspot/radvert.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/redirect.html","dst-path"=>"hotspot/redirect.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/rlogin.html","dst-path"=>"hotspot/rlogin.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/status.html","dst-path"=>"hotspot/status.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/testinternet.txt","dst-path"=>"hotspot/testinternet.txt"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/img/logobottom.png","dst-path"=>"hotspot/img/logobottom.png"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/alogin.html","dst-path"=>"hotspot/lv/alogin.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/errors.txt","dst-path"=>"hotspot/lv/errors.txt"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/login.html","dst-path"=>"hotspot/lv/login.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/logout.html","dst-path"=>"hotspot/lv/logout.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/radvert.html","dst-path"=>"hotspot/lv/radvert.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/status.html","dst-path"=>"hotspot/lv/status.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/alogin.html","dst-path"=>"hotspot/xml/alogin.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/error.html","dst-path"=>"hotspot/xml/error.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/flogout.html","dst-path"=>"hotspot/xml/flogout.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/login.html","dst-path"=>"hotspot/xml/login.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/logout.html","dst-path"=>"hotspot/xml/logout.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/rlogin.html","dst-path"=>"hotspot/xml/rlogin.html"));
    // $res = $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/WISPAccessGatewayParam.xsd","dst-path"=>"hotspot/xml/WISPAccessGatewayParam.xsd"));
    // /* PRINCIPIO FETCH */
    
    
    
    
    
    
    
    // print_r("-> Se añaden note\n"); 
    // /* PARTE DE NOTE */
     
    // $res = $API->comm('/system/note/set', array('note'=>"\r \********************************************************\ \r\r\r\r    _____                 _ __          __     \r   / ___/___  ______   __(_) /_  __  __/ /____  \r   \\__ \\/ _ \\/ ___/ | / / / __ \\/ / / / __/ _ \\  \r  ___/ /  __/ /   | |/ / / /_/ / /_/ / /_/  __/  \r /____/\\___/_/    |___/_/_.___/\\__, /\\__/\\___/ \r                              /____/           \r \r http://www.servibyte.com         info@servibyte.com\r\r CC Meloneras Playa Local 201-202, 35100 Maspalomas,\r Las Palmas, Canary Islands, Spain\r\r\r UNAUTHORIZED ACCESS TO THIS DEVICE IS PROHIBITED\r\r You must have explicit, authorized permission to access or\r configure this device.\r Unauthorized attempts and actions to access or use this system\r may result in civil and/or criminal penalties.\r ALL activities performed on this device are logged and monitored.\r\r\r"));
    
    
    
    
    
    
    
    // print_r("-> Se establece como protected routerboot\n"); 
    // /*PARTE ROUTERBOARD SETTINGS --FUNCIONA SEGURO EN 952, EN 951 NO FUNCIONA Y EN 1100 PARA ARRIBA CREO QUE TAMBIEN--*/
    // $res = $API->comm('/system/routerboard/settings/set', array("protected-routerboot"=> "enabled"));
    // $res = $API->write('/system/routerboard/getall');
    // $READ = $API->read();
    // print_r($READ);
    // /* FIN PARTE ROUTERBOARD SETTINGS*/




    // print_r("-> Se añaden scripts al scheduler\n"); 
    // /*PARTE SCHEDULER*/
    // $res = $API->comm('/system/scheduler/add', array("disabled"=> "yes", 'interval'=>'5s', 'name'=>'testinternet', 'on-event'=>'testinternet,', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jun/30/2016', 'start-time'=>'07:39:10'));
    // $res = $API->comm('/system/scheduler/add', array('interval'=>'15m', 'name'=>'hotspot', 'on-event'=>'hotspot,', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'));
    // $res = $API->comm('/system/scheduler/add', array("disabled"=> "yes",'interval'=>'14m59s', 'name'=>'AP10', 'on-event'=>'AP10', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'));
    // $res = $API->comm('/system/scheduler/add', array("disabled"=> "yes",'interval'=>'14m58s', 'name'=>'AP11', 'on-event'=>'AP11', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'));
    // $res = $API->comm('/system/scheduler/add', array("disabled"=> "yes", 'interval'=>'14m57s', 'name'=>'AP12', 'on-event'=>'AP12', 'policy'=>'ftp,reboot,read,write,policy,test,password,sniff,sensitive', 'start-date'=>'jul/26/2016', 'start-time'=>'21:44:20'));
    // /*FIN PARTE SCHEDULER*/




    // print_r("-> Se añaden scripts \n"); 
    // /*PARTE SCRIPTS*/
    // $script=":global internetactivo;\r if (\$internetactivo!=0 && \$internetactivo!=1) do={\r:set internetactivo 0;:log error \"Comienza Test Internet\";/file print file=\$myfile; /file set \$file contents=\"interneterror.html\";/ip dns static enable [find comment~\"Capturador\"]}:local myfile \"hotspot/testinternet\";:local file (\$myfile);:local pingresultado [/ping 4.2.2.4 count=5];:if (\$pingresultado>0) do={:if (\$internetactivo=0) do={:log error \"Internet funcionando\";:set internetactivo 1;/file print file=\$myfile /file set \$file contents=\"https:wifipremium.com/login.php\";/ip dns static disable [find comment~\"Capturador\"] } :if (\$pingresultado=0) do={:if (\$internetactivo=1) do={:log error \"Internet caido\";:set internetactivo 0;/file print file=\$myfile /file set \$file contents=\"interneterror.html\"; /ip dns static enable [find comment~\"Capturador\"] }}";
    // $res = $API->comm('/system/script/add', array("name"=> "testinternet", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));

    // $script="execute \"/tool fetch mode=http address=checkip.dyndns.org src-path=/ dst-path=d yndns.checkip.html\" :local result [/file get dyndns.checkip.html contents] :local resultLen [:len \$result] :local startLoc [:find \$result \": \" -1] :set startLoc (\$startLoc + 2) :local endLoc [:find \$result \"</body>\" -1] :local currentIP [:pick \$result \$startLoc \$endLoc] { :local activo 0; :foreach i in=[/system logging find] do={ :if ([/system logging get \$i topics]=\"firewall\") do={ :set activo 1 } }; :log warning (\":coronablanca::hotspot::up:\" . [/system resource get uptime] . \";cpu-load:\" . [/system resource get cpu-load] . \";active:\" . [/ip hotspot active print count-only]  . \";trazabilidad:\" . \$activo. \";ip:\" . \$currentIP)}";
    // $res = $API->comm('/system/script/add', array("name"=> "hotspot", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));
    
    // $script=":if ([/ip neighbor get [find identity=\"AP-10\"]] != \"no such item\") do={:log warning (\":coronablanca::AP-10:: up:00:00:00cpu-load:0\")}";
    // $res = $API->comm('/system/script/add', array("name"=> "AP10", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));

    // $script=":if ([/ip neighbor get [find identity=\"AP-11\"]] != \"no such item\") do={:log warning (\":coronablanca::AP-11:: up:00:00:00cpu-load:0\")}";
    // $res = $API->comm('/system/script/add', array("name"=> "AP11", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));
     
    // $script=":if ([/ip neighbor get [find identity=\"AP-12\"]] != \"no such item\") do={:log warning (\":coronablanca::AP-12:: up:00:00:00cpu-load:0\")}";
    // $res = $API->comm('/system/script/add', array("name"=> "AP12", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));

    // $script=":local usertoremove \"VEQODE68\";:local banuser \"noname\";:local banuseridle 00:00:00;:local banusermac \"00:00:00:00:00:00\";:local banuserip \"0.0.0.0\"; :foreach i in [/ip hotspot active find where user~\$usertoremove] do={ :local idle [/ip hotspot active get \$i idle-time]; :if (\$idle>=\$banuseridle) do={:set banuser \$i;:set banuseridle \$idle;:set banusermac [/ip hotspot active get \$i mac-address];:set banuserip [/ip hotspot active get \$i address];}}:if (\$banuser != \"noname\") do={:log warning (\"Usuario \".\$usertoremove.\" con Sesion ID: \".\$banuser.\" y Idle-Time: \".\$banuseridle.\" ha sido banneado\");:log warning (\"MAC: \".\$banusermac);:log warning (\"IP: \".\$banuserip); #:ip hotspot active remove \$banuser;}";
    // $res = $API->comm('/system/script/add', array("name"=> "delete_user_test", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));

    // $script=" :global lastTime; :local currentBuf [ :toarray [ /log find message~\"no more sessions\" ]] ; :local currentLineCount [ :len \$currentBuf ] ; if (\$currentLineCount > 0) do={ :local currentTime \"\$[ /log get [ :pick \$currentBuf (\$currentLineCount -1) ] time ]\"; :if ([:len \$currentTime] = 15 ) do={  :set currentTime [ :pick \$currentTime 7 15 ];} :local output \"\$currentTime \$[/log get [ :pick \$currentBuf (\$currentLineCount-1) ] message ]\"; :if ([:len \$lastTime] < 1 ) do={ :set lastTime \$currentTime ; if ( [:find \$output \"Moises logged in\" -1] != 0) do={ :log warning (\$currentTime . \" No more sessions encontrado\"); } } else={ :if ( \$lastTime != \$currentTime ) do={ :set lastTime \$currentTime ; if ( [:find \$output \"Moises logged in\" -1] != 0) do={ :log warning (\$currentTime . \" No more sessions encontrado\"); }}}";
    // $res = $API->comm('/system/script/add', array("name"=> "find_no_more_sessions_test", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));

    // $script=":log warning \"coronablanca_KUBAGE59 (172.21.32.170): login failed: no more sessions are allowed for user\";";
    // $res = $API->comm('/system/script/add', array("name"=> "genera_no_more_sessions", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));

    // /*FIN PARTE SCRIPTS*/



   

    $API->disconnect();

}

?>