<?php
  include('functions.php');
  $data['port']=$_POST["port"];
  $data['t']=$_POST["t"];
  $data['key']=$_POST["key"];
  echo ut($data);
?>