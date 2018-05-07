<?php

/* Se utiliza la version de Denis Basta */
require_once('scripts/routeros-api/routeros_api.class.php');

$ip = '192.168.45.26';
$user = 'admin';
$pass = '';
$API = new RouterosAPI();
$API->debug = false;
if ($API->connect($ip, $user, $pass)) {
    
    print_r("---> SE AÑADE address add address=192.168.1.5/24 interface=ether1\n");
    // $API->comm('/ip/address/add', array("address"=>"192.168.45.38/24", "interface"=>"ether1"));
    
    
    
    print_r("---> SE AÑADE /ip dns print :if ( [get servers] = '' ) do={/ip dns set servers=8.8.8.8,8.8.4.4 allow-remote-requests=yes}\n");
    $API->write('/ip/dns/print');
    $READ = $API->read();
    print_r($READ);
    if($READ[0]['servers'] == '') $API->comm('/ip/dns/set', array("servers"=>"8.8.8.8, 8.8.4.4", "allow-remote-requests"=>"true"));
    $API->write('/ip/dns/getall');
    $READ = $API->read();
    print_r($READ);



    print_r("----SE AÑADE /ip route add dst-address=0.0.0.0/0 gateway=192.168.1.1-------\n");
    $API->comm('/ip/route/add', array("dst-address"=>"0.0.0.0/0", "gateway"=>"192.168.1.1"));
    
    
    
    print_r("----SE AÑADE /ip dhcp-client :if ([:len [find interface=ether2 ]] = 0 ) do={/ip dhcp-client add interface=ether2 disabled=no}--------------------------\n"); 
    $API->write('/ip/dhcp-client/getall');
    $READ = $API->read();
    print_r($READ);
    $esta=false;
    foreach($READ as $key => $value){
        if($READ[$key]['interface'] == 'ether2') $esta=true;
    }
    if(!$esta) $API->comm('/ip/dhcp-client/add', array("interface"=>"ether2", "disabled"=>"no"));
    $API->write('/ip/dhcp-client/getall');
    $READ = $API->read();
    print_r($READ);
    
    
    
    print_r("-----------------------COMIENZO /system identity set name=hostpotname.--------------------------\n");
    $API->comm('/system/identity/set', array("name"=>'PRUEBA PLATAFORMA'));
    $API->write('/system/identity/getall');
    $READ = $API->read();
    print_r($READ);
    
    
    
    print_r("-----------------------COMIENZO /interface bridge add name=bridge_hotspot--------------------------\n");
    $API->comm('/interface/bridge/add', array("name"=>'bridge_hotspot'));
    $API->write('/interface/bridge/getall');
    $READ = $API->read();
    print_r($READ);
    
    
    
    print_r("-----------------------:if ([:len [/interface wireless find ]]>0) do={/interface wireless set wlan1 disabled=no mode=ap-bridge band=2ghz-b/g/n channel-width=20mhz frequency=2437 wireless-protocol=802.11 default-forwarding=no ssid=SERVERNAME';/interface bridge port add bridge=bridge_hotspot interface=wlan1}--------------------------\n");
    $API->write('/interface/wireless/getall');
    $READ = $API->read();
    print_r($READ);
    if(count($READ) > 0){
        $API->comm('/interface/wireless/set', array("numbers"=> 0,"disabled"=>"no", "mode"=>"ap-bridge", "band"=>"2ghz-b/g/n", "channel-width"=>"20mhz", "frequency"=>2437, "wireless-protocol"=>"802.11", "default-forwarding"=>"no", "ssid"=>"MIKROTIKAPI"));
        $API->comm('/interface/bridge/port/add', array("bridge"=> "bridge_hotspot","interface"=>"wlan1"));
    }
    $API->write('/interface/wireless/getall');
    $READ = $API->read();
    print_r($READ);
    $API->write('/interface/bridge/port/getall');
    $READ = $API->read();
    print_r($READ);
    
    
    
    // print_r("-----------------------COMIENZO delay 3 seg--------------------------\n");
    // sleep(3);
    // print_r("Han pasado 3 seg\n");

    print_r("-----------------------COMIENZO eliminar ficheros antes de hacer fetch----------------------------\n");
    $API->write('/file/getall');
    $READ = $API->read();
    print_r($READ);
    foreach($READ as $key => $value){
        if(strpos($value['name'], 'backup') == false){
            $API->comm('/file/remove', array("numbers"=>$value['.id']));
        }
    }
    $API->comm('/file/remove', array("numbers"=>$value['.id']));
    print_r("-----------------------COMIENZO fetch urls----------------------------\n");
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/alogin.html","dst-path"=>"hotspot/alogin.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/averia.jpg","dst-path"=>"hotspot/averia.jpg"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/error.html","dst-path"=>"hotspot/error.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/errors.txt","dst-path"=>"hotspot/errors.txt"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/interneterror.html","dst-path"=>"hotspot/interneterror.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/GETSERIALNAME-login.html","dst-path"=>"hotspot/login.html"));

    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logoservibyte.png","dst-path"=>"hotspot/logoservibyte.png"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/logout.html","dst-path"=>"hotspot/logout.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/md5.js","dst-path"=>"hotspot/md5.js"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/radvert.html","dst-path"=>"hotspot/radvert.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/redirect.html","dst-path"=>"hotspot/redirect.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/rlogin.html","dst-path"=>"hotspot/rlogin.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/status.html","dst-path"=>"hotspot/status.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/testinternet.txt","dst-path"=>"hotspot/testinternet.txt"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/img/logobottom.png","dst-path"=>"hotspot/img/logobottom.png"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/alogin.html","dst-path"=>"hotspot/lv/alogin.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/errors.txt","dst-path"=>"hotspot/lv/errors.txt"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/login.html","dst-path"=>"hotspot/lv/login.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/logout.html","dst-path"=>"hotspot/lv/logout.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/radvert.html","dst-path"=>"hotspot/lv/radvert.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/lv/status.html","dst-path"=>"hotspot/lv/status.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/alogin.html","dst-path"=>"hotspot/xml/alogin.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/error.html","dst-path"=>"hotspot/xml/error.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/flogout.html","dst-path"=>"hotspot/xml/flogout.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/login.html","dst-path"=>"hotspot/xml/login.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/logout.html","dst-path"=>"hotspot/xml/logout.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/rlogin.html","dst-path"=>"hotspot/xml/rlogin.html"));
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot/xml/WISPAccessGatewayParam.xsd","dst-path"=>"hotspot/xml/WISPAccessGatewayParam.xsd"));

    
    
    print_r("-----------------------COMIENZO /ip hotspot add interface=bridge_hotspot disabled=no----------------------------\n");
    $API->comm('/ip/hotspot/add', array("interface"=> "bridge_hotspot","disabled"=>"no"));
    
    
    
    print_r("-----------------------COMIENZO /ip address add interface=bridge_hotspot address=172.21.0.1/22----------------------------\n");
    $API->comm('/ip/address/add', array("interface"=> "bridge_hotspot","address"=>"172.21.0.1/22"));
    
    
 
    print_r("-----------------------COMIENZO /ip pool add name=hs-pool-14 ranges=172.21.0.2-172.21.3.254----------------------------\n");
    $API->comm('/ip/pool/add', array("name"=> "hs-pool-14","ranges"=>"172.21.0.2-172.21.3.254"));
    
    

    print_r("-----------------------COMIENZO /ip dns set servers=8.8.8.8,8.8.4.4----------------------------\n");
    $API->comm('/ip/dns/set', array("servers"=> "8.8.8.8,8.8.4.4"));
    
   

    print_r("-----------------------COMIENZO /ip dns static add name=hotspot.wifipremium.com address=172.21.0.1 ttl=5m----------------------------\n");
    $API->comm('/ip/dns/static/add', array("name"=> "hotspot.wifipremium.com", "address"=>"172.21.0.1", "ttl"=>"5m"));
    
    
    
    print_r("-----------------------COMIENZO /ip hotspot profile add dns-name=hotspot.wifipremium.com hotspot-address=172.21.0.1 name=hsprof1----------------------------\n");
    $API->comm('/ip/hotspot/profile/add', array("dns-name"=> "hotspot.wifipremium.com", "hotspot-address"=>"172.21.0.1", "name"=>"hsprof1"));

   
   
    print_r("-----------------------COMIENZO /ip dhcp-server add address-pool=hs-pool-14 authoritative=yes bootp-support=static disabled=no interface=bridge_hotspot lease-time=24h name=dhcp1----------------\n");
    $API->comm('/ip/dhcp-server/add', array("address-pool"=> "hs-pool-14", "authoritative"=>"yes", "bootp-support"=>"static", "disabled"=>"no", "interface"=>"bridge_hotspot", "lease-time"=>"24h", "name"=>"dhcp1"));

    
    
    print_r("-----------------------COMIENZO /ip hotspot user add name=HOTSPOT[SERVERNAME]_SBYTE password=sbboscosos----------------------------\n");
    $API->comm('/ip/hotspot/user/add', array("name"=> "HOTSPOT[SERVERNAME]_SBYTE", "password"=>"sbboscosos"));



    print_r("-----------------------COMIENZO /ip firewall filter add action=passthrough chain=unused-hs-chain comment='place hotspot rules here' disabled=yes----------------------------\n");
    $API->comm('/ip/firewall/filter/add', array("action"=> "passthrough", "chain"=>"unused-hs-chain", "comment"=>"place hotspot rules here", "disabled"=>"yes"));



    print_r("-----------------------COMIENZO /ip firewall nat add action=passthrough chain=unused-hs-chain comment= 'place hotspot rules here' disabled=yes----------------------------\n");
    $API->comm('/ip/firewall/nat/add', array("action"=> "passthrough", "chain"=>"unused-hs-chain", "comment"=>"place hotspot rules here", "disabled"=>"yes"));



    // print_r("-----------------------COMIENZO :delay 1s;----------------------------\n");
    // sleep(3);
    // print_r("Han pasado 3 seg\n");



    print_r("-----------------------COMIENZO /ip firewall nat add action=masquerade chain=srcnat comment= 'masquerade hotspot network' src-address=172.21.0.0/22----------------------------\n");
    $API->comm('/ip/firewall/nat/add', array("action"=> "masquerade", "chain"=>"srcnat", "comment"=>"masquerade hotspot network", "src-address"=>"172.21.0.0/22"));



    print_r("-----------------------COMIENZO /ip hotspot set hotspot1 name=HOTSPOT[SERVERNAME]----------------------------\n");
    $API->comm('/ip/hotspot/set', array("numbers"=>"hotspot1", "name"=> "HOTSPOT[SERVERNAME]"));



    print_r("-----------------------COMIENZO /ip hotspot user profile add name=tecnico shared-users=5----------------------------\n");
    $API->comm('/ip/hotspot/user/profile/add', array("name"=>"tecnico", "shared-users"=> 5));



    print_r("-----------------------COMIENZO /ip hotspot user profile set default shared-users=1 rate-limit=380k/2M idle-timeout=none keepalive-timeout=20m status-autorefresh=1m mac-cookie-timeout=7d session-timeout=0s----------------------------\n");
    $API->comm('/ip/hotspot/user/profile/set', array("numbers"=>"default", "shared-users"=>1, "rate-limit"=> "380k/2M", "idle-timeout"=>"none", "keepalive-timeout"=>"20m", "status-autorefresh"=>"1m", "mac-cookie-timeout"=>"7d", "session-timeout"=>"0s"));
   
   
   
    print_r("-----------------------COMIENZO /ip hotspot user set HOTSPOT[SERVERNAME]_SBYTE profile=tecnico----------------------------\n");
    $API->comm('/ip/hotspot/user/set', array("numbers"=>"HOTSPOT[SERVERNAME]_SBYTE", "profile"=>"tecnico"));



    print_r("-----------------------COMIENZO /ip hotspot walled-garden add dst-host=*----------------------------\n");
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.apple.com"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.airport.us"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.itools.info"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.appleiphonecell.com"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"captive.apple.com"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.thinkdifferent.us"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"www.ibook.info"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"wifipremium.com", "dst-port"=>"443"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"*akamai*"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"*fbcdn*"));
    $API->comm('/ip/hotspot/walled-garden/add', array("dst-host"=>"*facebook*"));
    
    $API->comm('/ip/hotspot/walled-garden/ip/add', array("action"=>"accept","comment"=>"Acepta conexiones al VPS","disabled"=>"no","dst-address"=>"176.28.102.26"));

    
    
    print_r("-----------------------COMIENZO /ip dhcp-server network add address=172.21.0.0/16 gateway=172.21.0.1 netmask=32----------------------------\n");
    $API->comm('/ip/dhcp-server/network/add', array("address"=>"172.21.0.0/16","gateway"=>"172.21.0.1","netmask"=>"32"));



    print_r("-----------------------COMIENZO /ip firewall filter add action=add-src-to-address-list address-list='facebook login' address-list-timeout=3m chain=input comment= 'FB Port Knocking 3min access window' dst-port=8090 protocol=tcp place-before=0----------------------------\n");
    $API->comm('/ip/firewall/filter/add', array("action"=>"add-src-to-address-list","address-list"=>"facebook login","address-list-timeout"=>"3m", "chain"=>"input ", "comment"=>"FB Port Knocking 3min access window", "dst-port"=>"8090", "protocol"=>"tcp", "place-before"=>"0"));



    print_r("-----------------------COMIENZO /ip firewall filter add action=drop chain=input comment='FB Block no auth customers' connection-mark=FBConexion hotspot=!auth src-address-list='!facebook login' place-before=0----------------------------\n");
    $API->comm('/ip/firewall/filter/add', array("action"=>"drop","chain"=>"input","comment"=>"FB Block no auth customers", "connection-mark"=>"FBConexion", "hotspot"=>"!auth", "src-address-list"=>"!facebook login", "place-before"=>"0"));



    print_r("-----------------------COMIENZO /ip firewall nat add action=add-dst-to-address-list address-list=fb chain=pre-hotspot comment= 'Drop conexiones https cuando unAuth' dst-address=!176.28.102.26 dst-address-list=!FacebookIPs dst-address-type=!local dst-port=443 hotspot=!auth protocol=tcp to-ports=80----------------------------\n");
    $API->comm('/ip/firewall/nat/add', array("action"=>"add-dst-to-address-list","address-list"=>"fb","chain"=>"pre-hotspot", "comment"=>"Drop conexiones https cuando unAuth", "dst-address"=>"!176.28.102.26", "dst-address-list"=>"!FacebookIPs", "dst-address-type"=>"!local", "dst-port"=>"443", "hotspot"=>"!auth", "protocol"=>"tcp", "to-ports"=>"80"));



    print_r("-----------------------COMIENZO /ip firewall nat set [find action=masquerade] out-interface=ether1----------------------------\n");
    // $API->comm('/ip/firewall/nat/print', array("?action"=> "masquerade"));
    // $API->write('?=action=masquerade');
    // $API->write('=.proplist=.id'); 
    $API->write('/ip/firewall/nat/getall');
    $READ = $API->read();
    print_r($READ);
    foreach($READ as $key => $value){
        if($value['action'] == 'masquerade')  $API->comm('/ip/firewall/nat/set', array("numbers"=>$value['.id'],"out-interface"=>"ether1"));
    }
   
    
    
    print_r("-----------------------COMIENZO /ip firewall nat unset [find action=masquerade] src-address----------------------------\n");
    $API->write('/ip/firewall/nat/getall');
    $READ = $API->read();
    foreach($READ as $key => $value){
        if($value['action'] == 'masquerade')  $API->comm('/ip/firewall/nat/unset', array("numbers"=>$value['.id'], "value-name"=>"src-address"));
    }
    
    
    
    print_r("-----------------------COMIENZO /ip firewall mangle add action=mark-connection chain=prerouting comment='FB Connection Mark ' dst-address-list=FacebookIPs new-connection-mark=FBConexion----------------------------\n");
    $API->comm('/ip/firewall/mangle/add', array("action"=>"mark-connection","chain"=>"prerouting","comment"=>"FB Connection Mark ", "dst-address-list"=>"FacebookIPs", "new-connection-mark"=>"FBConexion"));



    print_r("-----------------------COMIENZO /ip firewall layer7-protocol add name=facebook regexp='^.+(facebook.com).*\$'----------------------------\n");
    $API->comm('/ip/firewall/layer7-protocol/add', array("name"=>"facebook","regexp"=>"^.+(facebook.com).*\$"));



    print_r("-----------------------COMIENZO /ip firewall layer7-protocol add name=facebook2 regexp='.+(facebook.com)*dialog'----------------------------\n");
    $API->comm('/ip/firewall/layer7-protocol/add', array("name"=>"facebook2","regexp"=>".+(facebook.com)*dialog"));
     
     
     
    print_r("-----------------------COMIENZO /ip firewall layer7-protocol add name=facebook3 regexp='.+(facebook.com)*login'----------------------------\n");
    $API->comm('/ip/firewall/layer7-protocol/add', array("name"=>"facebook3","regexp"=>".+(facebook.com)*login"));
     
     
     
     
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=204.15.20.0/22 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"204.15.20.0/22","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.63.176.0/20 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.63.176.0/20","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=66.220.144.0/20 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"66.220.144.0/20","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=66.220.144.0/21 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"66.220.144.0/21","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.63.184.0/21 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.63.184.0/21","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.63.176.0/21 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.63.176.0/21","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=74.119.76.0/22 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"74.119.76.0/22","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.171.255.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.171.255.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=173.252.64.0/18 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"173.252.64.0/18","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.171.224.0/19 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.171.224.0/19","list"=>"FacebookIPs"));
         
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.171.224.0/20 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.171.224.0/20","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=103.4.96.0/22 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"103.4.96.0/22","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.63.176.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.63.176.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=173.252.64.0/19 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"173.252.64.0/19","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=173.252.70.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"173.252.70.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.64.0/18 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.64.0/18","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.24.0/21 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.24.0/21","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=66.220.152.0/21 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"66.220.152.0/21","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=66.220.159.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"66.220.159.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.171.239.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.171.239.0/24","list"=>"FacebookIPs"));
         
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.171.240.0/20 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.171.240.0/20","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.64.0/19 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.64.0/19","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.64.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.64.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.65.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.65.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.67.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.67.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.68.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.68.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.69.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.69.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.70.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.70.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.71.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.71.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.72.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.72.0/24","list"=>"FacebookIPs"));
         
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.73.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.73.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.74.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.74.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.75.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.75.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.76.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.76.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.77.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.77.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.96.0/19 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.96.0/19","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.66.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.66.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=173.252.96.0/19 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"173.252.96.0/19","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.63.178.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.63.178.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.78.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.78.0/24","list"=>"FacebookIPs"));
         
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.79.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.79.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.80.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.80.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.82.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.82.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.83.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.83.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.84.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.84.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.85.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.85.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.86.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.86.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.87.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.87.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.88.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.88.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.89.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.89.0/24","list"=>"FacebookIPs"));
         
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.90.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.90.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.91.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.91.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.92.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.92.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.93.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.93.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.94.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.94.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.95.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.95.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.171.253.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.171.253.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=69.63.186.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"69.63.186.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=31.13.81.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"31.13.81.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=179.60.192.0/22 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"179.60.192.0/22","list"=>"FacebookIPs"));
         
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=179.60.192.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"179.60.192.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=179.60.193.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"179.60.193.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=179.60.194.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"179.60.194.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=179.60.195.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"179.60.195.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=185.60.216.0/22 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"185.60.216.0/22","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=45.64.40.0/22 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"45.64.40.0/22","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=185.60.216.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"185.60.216.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=185.60.217.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"185.60.217.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=185.60.218.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"185.60.218.0/24","list"=>"FacebookIPs"));
    
    print_r("-----------------------COMIENZO VARIOS /ip firewall address-list add address=185.60.219.0/24 list=FacebookIPs----------------------------\n");
    $API->comm('/ip/firewall/address-list/add', array("address"=>"185.60.219.0/24","list"=>"FacebookIPs"));



    print_r("-----------------------COMIENZO /tool fetch url='http://servibyte.net/ftp/certificate.crt'----------------------------\n");
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.crt"));



    print_r("-----------------------COMIENZO /tool fetch url='http://servibyte.net/ftp/certificate.ca-crt'----------------------------\n");
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/certificate.ca-crt"));
    
    
    
    print_r("-----------------------COMIENZO /tool fetch url='http://servibyte.net/ftp/hotspot.key'----------------------------\n");
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/hotspot.key"));



    print_r("-----------------------COMIENZO /certificate import file-name=certificate.crt passphrase=PwpXXf8bPwpXXf8b----------------------------\n");
    $API->comm('/certificate/import', array("file-name"=> "certificate.crt", "passphrase"=>"PwpXXf8bPwpXXf8b"));
    
    
    
    print_r("-----------------------COMIENZO /certificate import file-name=hotspot.key passphrase=PwpXXf8bPwpXXf8b----------------------------\n");
    $API->comm('/certificate/import', array("file-name"=> "hotspot.key", "passphrase"=>"PwpXXf8bPwpXXf8b"));
   
   
   
    print_r("-----------------------COMIENZO /certificate import file-name=certificate.ca-crt passphrase=PwpXXf8bPwpXXf8b----------------------------\n");
    $API->comm('/certificate/import', array("file-name"=> "certificate.ca-crt", "passphrase"=>"PwpXXf8bPwpXXf8b"));
    
    
    
    print_r("-----------------------COMIENZO /ip service enable www-ssl----------------------------\n");
    $API->comm('/ip/service/enable', array("numbers"=> "www-ssl"));
    
    
    
    print_r("-----------------------COMIENZO /ip service set www-ssl certificate=certificate.crt_0----------------------------\n");
    $API->comm('/ip/service/set', array("numbers"=> "www-ssl", "certificate"=> "certificate.crt_0"));
    
    
    
    print_r("-----------------------COMIENZO /radius add service=hotspot address=176.28.102.26 secret=tachin timeout=4000ms src-address=0.0.0.0----------------------------\n");
    $API->comm('/radius/add', array("service"=> "hotspot", "address"=> "176.28.102.26", "secret"=>"tachin", "timeout"=>"4000ms", "src-address"=>"0.0.0.0"));
    
    
    
    
    
    print_r("-----------------------COMIENZO /ip hotspot profile set hsprof1 use-radius=yes nas-port-type=wireless-802.11----------------------------\n");
    $API->comm('/ip/hotspot/profile/set', array("numbers"=> "hsprof1", "use-radius"=> "yes", "nas-port-type"=>"wireless-802.11"));

    
    
    
    print_r("-----------------------COMIENZO /ip hotspot profile set hsprof1 login-by=http-chap,https,cookie,mac-cookie http-cookie-lifetime=7d ssl-certificate=certificate.crt_0----------------------------\n");
    $API->comm('/ip/hotspot/profile/set', array("numbers"=> "hsprof1", "login-by"=> "http-chap,https,cookie,mac-cookie", "http-cookie-lifetime"=>"7d", "ssl-certificate"=>"certificate.crt_0"));

    
    
    
    print_r("-----------------------COMIENZO /system script add name=testinternet LARGO----------------------------\n");
   
    $script=":global internetactivo;\n if (\$internetactivo!=0 && \$internetactivo!=1) do={\r\    \n    :set internetactivo 0;\r\    \n        :log error \"Comienza Test Internet\";\r\    \n        /file print file=\$myfile\r\    \n        /file set \$file contents=\"interneterror.html\";\r\    \n        /ip dns static enable [find comment~\"Capturador\"] \r\    \n\r\    \n}\r\    \n\r\    \n:local myfile \"hotspot/testinternet\";\r\    \n:local file (\$myfile);\r\    \n\r\    \n:local pingresultado [/ping 4.2.2.4 count=5];\r\    \n\r\    \n:if (\$pingresultado>0) do={\r\    \n    :if (\$internetactivo=0) do={\r\    \n        :log error \"Internet funcionando\";\r\    \n        :set internetactivo 1;\r\    \n        /file print file=\$myfile\r\    \n        /file set \$file contents=\"https://wifipremium.com/login.php\";\r\    \n        /ip dns static disable [find comment~\"Capturador\"] \r\    \n    }\r\    \n}\r\    \n\r\    \n:if (\$pingresultado=0) do={\r\    \n    :if (\$internetactivo=1) do={\r\    \n        :log error \"Internet caido\";\r\    \n        :set internetactivo 0;\r\    \n        /file print file=\$myfile\r\    \n        /file set \$file contents=\"interneterror.html\";\r\    \n        /ip dns static enable [find comment~\"Capturador\"] \r\    \n    }\r\    \n}";
    
 $API->comm('/system/script/add', array("name"=> "testinternet", "owner"=> "administrador", "policy"=>"ftp,reboot,read,write,policy,test,password,sniff,sensitive", "source"=>$script));
    
    
    
    print_r("-----------------------COMIENZO /system scheduler add name=testinternet interval=5s on-event=testinternet----------------------------\n");
    $API->comm('/system/scheduler/add', array("name"=> "testinternet", "interval"=> "5s", "on-event"=>"testinternet"));




    print_r("-----------------------COMIENZO /ip dns static add name=exit.com address=172.21.0.1 ttl=1d----------------------------\n");
    $API->comm('/ip/dns/static/add', array("name"=> "exit.com", "address"=> "172.21.0.1", "ttl"=>"1d"));
    
    
    
    
    
    print_r("-----------------------COMIENZO /ip dns static add name='.*\\\..*' address=172.21.0.1 ttl=1d disabled=yes comment='Capturador DNS cuando no hay internet'----------------------------\n");
    $API->comm('/ip/dns/static/add', array("name"=> ".*\\\..*", "address"=> "172.21.0.1", "ttl"=>"1d", "disabled"=>"yes", "comment"=>"Capturador DNS cuando no hay internet"));
    
    
    
    
    print_r("-----------------------COMIENZO /system ntp client set enabled=yes primary-ntp=129.67.1.160 secondary-ntp=129.67.1.164----------------------------\n");  
    $API->comm('/system/ntp/client/set', array("enabled"=> "yes", "primary-ntp"=> "129.67.1.160", "secondary-ntp"=>"129.67.1.164"));
    
    
    
    
    print_r("-----------------------COMIENZO /system clock set time-zone-name=Atlantic/Canary----------------------------\n");
    $API->comm('/system/clock/set', array("time-zone-name"=> "Atlantic/Canary"));




    print_r("-----------------------COMIENZO /interface pptp-client add connect-to=217.125.25.165 user=HOTSPOT[SERVERNAME] password='A54_sb\?8' profile=default-encryption disabled=no----------------------------\n");
    $API->comm('/interface/pptp-client/add', array("connect-to"=> "217.125.25.165", "user"=> "HOTSPOT[SERVERNAME]", "password"=>"A54_sb\?8", "profile"=>"default-encryption", "disabled"=>"no"));
    
    
    
    // print_r("-----------------------COMIENZO :delay 3s;----------------------------\n");
    // sleep(3);
    // print_r("Han pasado 3 seg\n");
    
    
    
    print_r("-----------------------COMIENZO /snmp set enabled=yes contact='info@servibyte.com' location='Maspalomas' trap-community=public trap-version=2 trap-generators=interfaces trap-interfaces=all----------------------------\n");
    $API->comm('/snmp/set', array("enabled"=> "yes", "contact"=> "info@servibyte.com", "location"=>"Maspalomas", "trap-community"=>"public", "trap-version"=>"2", "trap-generators"=>"interfaces", "trap-interfaces"=>"all" ));
    
    
    
    
    
    print_r("-----------------------COMIENZO /tool e-mail set address=74.125.206.108 port=587 start-tls=yes from='servibyte.log@gmail.com' user=Servibyte.log password=sbyte_14_Mxz----------------------------\n");
    $API->comm('/tool/e-mail/set', array("address"=> "74.125.206.108", "port"=> "587", "start-tls"=>"yes", "from"=>"servibyte.log@gmail.com", "user"=>"Servibyte.log", "password"=>"sbyte_14_Mxz"));
    


    print_r("-----------------------COMIENZO /system logging action add name=email target=email email-to=servibyte.log@gmail.com email-start-tls=yes----------------------------\n");
    $API->comm('/system/logging/action/add', array("name"=> "email", "target"=> "email", "email-to"=>"servibyte.log@gmail.com", "email-start-tls"=>"yes"));
    
    
    
    
    print_r("-----------------------COMIENZO /system logging add topics=hotspot----------------------------\n");
    $API->comm('/system/logging/add', array("topics"=> "hotspot"));

    
    
    
    print_r("-----------------------COMIENZO /user group add name=tecnico policy=reboot,write,test,read,web----------------------------\n");
    $API->comm('/user/group/add', array("name"=> "tecnico", "policy"=>"reboot,write,test,read,web"));

    
    
    
    
    print_r("-----------------------COMIENZO /user add name=tecnico group=tecnico password=sbboscosos----------------------------\n");
    $API->comm('/user/add', array("name"=> "tecnico", "group"=>"tecnico", "password"=>"sbboscosos"));




    print_r("-----------------------COMIENZO /tool fetch url='http://servibyte.net/ftp/sys-note.txt'----------------------------\n");
    $API->comm('/tool/fetch', array("url"=> "http://servibyte.net/ftp/sys-note.txt"));
    
    
    
    
    print_r("-----------------------COMIENZO /file remove flash/hotspot.rsc----------------------------\n");
    $API->comm('/file/remove', array("numbers"=> "flash/hotspot.rsc"));



    
    $API->disconnect();

}

?>