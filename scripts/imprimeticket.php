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
                    echo '@page {size: A4;margin: 0;} @media print {html, body {width: 210mm;height: 297mm;}} .logo{display:none;} .data{ padding-top: 175px; margin-left: -30px;} .border {border: 1px solid black;display: inline-block}'.((file_exists(getcwd().'/../images/'.$_GET['full']))?' body{background-image: url("/images/'.$_GET['full'].'"); height: 29cm; width: 21cm; background-repeat: no-repeat; background-size: 21cm 29cm;}':'');
                } else {
                    echo '@media print {html, body {width: 80mm;}} body {width: 8cm; text-align: center; font-size: 30px;}';
                }
                function secondsToTime($seconds) {
                    $dtF = new \DateTime('@0');
                    $dtT = new \DateTime("@$seconds");
                    return $dtF->diff($dtT)->format((($seconds >= 86400)?'%a days':'%h hours'));
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
                <?php if (!empty($_GET['pass'])): ?>
                    <p>Pass: <?php echo $_GET['pass']; ?></p>
                <?php endif; ?>
                <?php if (!empty($_GET['identificador'])): ?>
                    <p>
                        Id: <?php echo $_GET['identificador']; ?>
                        &nbsp;Date: 
                        <?php if (!empty($_GET['fecha'])): ?>
                            <?php echo $_GET['fecha']; ?>
                        <?php else: ?>
                            <?php echo date("d-m-y") ?>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($_GET['precio'])): ?>
                    <p>
                        <?php echo $_GET['precio']; ?>€
                         &nbsp;<?php echo secondsToTime($_GET['duracion']); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>
