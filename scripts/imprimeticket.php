<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style type="text/css">
            <?php
                if (isset($_GET['full'])) {
                    echo '@page {size: A4;margin: 0;} @media print {html, body {width: 210mm;height: 297mm;}} .logo{display:none;} .data{ padding-top: 175px;} .border {border: 1px solid black;display: inline-block}'.((file_exists('/var/www/vhosts/servibyte.com/servibyte.net/images/'.$_GET['full']))?' body{background-image: url("/images/'.$_GET['full'].'"); height: 29cm; width: 21cm; background-repeat: no-repeat; background-size: 21cm 29cm;}':'');
                } else {
                    echo '@media print {html, body {width: 80mm;}} body {width: 8cm; text-align: center; font-size: 30px;}';
                }
            ?>
            .logo {
                text-align: center;
            }
            .data {
                text-align: center;
            }
            .border {
                text-align: center;
                width: 300px;
            }
        </style>
    </head>
    <body>
        <div class='logo'>
            <img src="/images/logo.png">
        </div>
        <div class='data'>
            <div class='border'>
                <p>User: <?php echo $_GET['user']; ?></p>
                <p>Pass: <?php echo $_GET['pass']; ?></p>
            </div>
        </div>
    </body>
</html>
