<?php
// Author: EDB
// Created On: 11st Nov 2017
// E-mail: edb@paituo.me
  include('functions.php');
  $operation=$_POST["operation"];
  switch ($operation) {
  	case 'au':
      $data['port']=$_POST["port"];
      $data['pwd']=$_POST["pwd"];
      $data['total']=$_POST["total"];
      $data['due_time']=$_POST["due_time"];
      $data['key']=$_POST["key"];
  		echo au($data);
  		break;
    case 'mu':
      $data['port']=$_POST["port"];
      $data['pwd']=$_POST["pwd"];
      $data['used']=$_POST["used"];
      $data['total']=$_POST["total"];
      $data['due_time']=$_POST["due_time"];
      $data['key']=$_POST["key"];
      echo mu($data);
      break;
    case 'as':
      $data['ip']=$_POST["ip"];
      $data['key']=$_POST["key"];
      echo adds($data);
      break;
    case 'gt':
      $data['port']=$_POST["port"];
      $data['key']=$_POST["key"];
      echo gt($data);
      break;
    case 'lu':
      $data['port']=$_POST["port"];
      $data['key']=$_POST["key"];
      echo lu($data);
      break;
    case 'listusers':
      $data['key']=$_POST["key"];
      echo listusers($data);
      break;
    case 'du':
      $data['port']=$_POST["port"];
      $data['key']=$_POST["key"];
      echo du($data);
      break;
    case 'ut':
      $data['port']=$_POST["port"];
      $data['t']=$_POST["t"];
      $data['key']=$_POST["key"];
      echo ut($data);
      break;
    case 'ls':
      $data['key']=$_POST["key"];
      echo ls($data);
      break;  
    case 'ds':
      $data['id']=$_POST["id"];
      $data['key']=$_POST["key"];
      echo ds($data);
      break;  
  	default:
  		echo "edboffical - carpe diem!";
  		break;
  }
?>