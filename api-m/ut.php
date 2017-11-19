<?php
// Author: EDB
// Created On: 11st Nov 2017
// E-mail: edb@paituo.me
  include('functions.php');
  $data['port']=$_GET["port"];
  $data['t']=$_GET["t"];
  $data['key']=$_GET["key"];
  echo ut($data);
?>