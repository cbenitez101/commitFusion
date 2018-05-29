<?php
  if (isset($_GET['file'])){
      $file = getcwd()."/".$_GET['file'];
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      header("Content-Disposition: attachment;filename=".basename($file));
      header("Content-Transfer-Encoding: binary ");
      readfile($file);
      register_shutdown_function('unlink', $file);
  }