<?php
  include('functions.php');
  $data['port']=$_POST["port"];
  $data['key']=$_POST["key"];
  echo gt($data);
?>