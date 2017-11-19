<?php
// Author: EDB
// Created On: 11st Nov 2017
// E-mail: edb@paituo.me
  $result = include "config.php";
  $con = mysql_connect("localhost",$result['db_user'],$result['db_pwd']);
  function init() {
    	global $con;
      if (!$con){
  	  die('Could not connect: ' . mysql_error());
  	  }else{
  	  	if (mysql_query("CREATE DATABASE bsp_db",$con)){
  		  ipt();
  		}
  		else{
  		  echo "Error creating database: " . mysql_error();
  		}
  	  }
  }
  function ipt(){
    	global $result;
    	$_sql = file_get_contents('bsp_db.sql');
  	  $_arr = explode(';', $_sql);
  	  $_mysqli = new mysqli("localhost",$result['db_user'],$result['db_pwd']);
    	if (mysqli_connect_errno()) {
    	  exit('连接数据库出错');
    	}else{
        foreach ($_arr as $_value) {
          $_mysqli->query($_value.';');
        }
        $_mysqli->close();
        $_mysqli = null;
        Header("Location:success.html"); 
      }
  }
  function ss_set($ip,$port,$pwd,$limit,$dt){
      global $result;
      $bsp_key=$result['bsp_key'];
      $data['port']=$port;
      $data['pwd']=$pwd;
      $data['limit']=$limit;
      $data['dt']=$dt;
      $data['key']=md5($bsp_key.$data['port'].$data['pwd'].$data['limit'].$data['dt']);
      return b_post('http://'.$ip.'/bsp/api-n/ss_set.php',$data);
  }
  function ss_del($ip,$port){
      global $result;
      $bsp_key=$result['bsp_key'];
      $data['port']=$port;
      $data['key']=md5($bsp_key.$data['port']);
      return b_post('http://'.$ip.'/bsp/api-n/ss_del.php',$data);
  }
  function au($data){
    	global $con;
    	global $result;
    	mysql_select_db("bsp_db", $con);
    	$sql = "SELECT * FROM bsp_servers";
    	$res = mysql_query($sql,$con);
    	$results = m_arr($res);
    	if (count($results)==0) {
    		$results['msg']='there is no any servers';
    	}else{ 
    		if (!is_empty($data)&&$data['key']==c_arr($data)) {
    			$time=time();
    			mysql_query("INSERT INTO bsp_user (port, pwd, total, due_time, create_time) VALUES ('$data[port]','$data[pwd]','$data[total]','$data[due_time]','$time')");
          foreach ($results as $k => $v) {
             ss_set($results[$k]['ip'],$data['port'],$data['pwd'],$data['total'],$data['due_time']);
          }
          $results='';
          if (mysql_error()=='') {
            $results['msg']='success';
          }else{
            $results['msg']=mysql_error();
          }
    		}else{
            $results['msg']='no auth or lack of value';
    		}
    	}
      // $json = json_encode($results);
      // $jj = json_decode($json,true);
      // echo $jj[0]['due_time'];
      // echo count($results);
      return json_encode($results);
  }
  function adds($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
        $results = '';
        if (!is_empty($data)&&$data['key']==c_arr($data)) {
          mysql_query("INSERT INTO bsp_servers (ip) VALUES ('$data[ip]')");
          if (mysql_error()=='') {
            $results['msg']='success';
          }else{
            $results['msg']=mysql_error();
          }
        }else{
            $results['msg']='permission denied or lack of value';
        }
      // $json = json_encode($results);
      // $jj = json_decode($json,true);
      // echo $jj[0]['due_time'];
      // echo count($results);
      return json_encode($results);
    }
  function gt($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
      if (!is_empty($data)&&$data['key']==c_arr($data)) {
          $sql="SELECT * FROM `bsp_user` WHERE `port` = $data[port]";
          $res = mysql_query($sql,$con);
          $results = m_arr($res);
          $results = $results[0]['used'];
          if (mysql_error()=='') {
            if ($results=='') {
              $results['msg']='no such port';
              $results=json_encode($results);
            }
          }else{
            $results['msg']=mysql_error();
            $results=json_encode($results);
          }
          // $results='sdfsdf';
      }else{
          $results['msg']='permission denied or lack of value';
          $results=json_encode($results);
      }
      return $results;
  }
  function lu($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
      if (!is_empty($data)&&$data['key']==c_arr($data)) {
          $sql="SELECT * FROM `bsp_user` WHERE `port` = $data[port]";
          $res = mysql_query($sql,$con);
          $results = m_arr($res);
          if (mysql_error()=='') {
            if (is_null($results)) {
              $results['msg']='no such port';
              $results=json_encode($results);
            }
          }else{
            $results['msg']=mysql_error();
            $results=json_encode($results);
          }
          // $results='sdfsdf';
      }else{
          $results['msg']='permission denied or lack of value';
          $results=json_encode($results);
      }
      return $results;
  }
  function du($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
      $sql = "SELECT * FROM bsp_servers";
      $res = mysql_query($sql,$con);
      $results = m_arr($res);
      if (!is_empty($data)&&$data['key']==c_arr($data)) {
          mysql_query("DELETE FROM bsp_user WHERE `port` = $data[port]");
          foreach ($results as $k => $v) {
            ss_del($results[$k]['ip'],$data['port']);
          }
          $results='';
          if (mysql_error()=='') {
            $results['msg']='success';
          }else{
            $results['msg']=mysql_error();
          }
      }else{
          $results['msg']='permission denied or lack of value';
      }
      return json_encode($results);
  }
  function ls($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
      if (!is_empty($data)&&$data['key']==c_arr($data)) {
          $sql = "SELECT * FROM bsp_servers";
          $res = mysql_query($sql,$con);
          $results = m_arr($res);
          if (mysql_error()=='') {
            $results['msg']='success';
          }else{
            $results['msg']=mysql_error();
          }
          // $results='sdfsdf';
      }else{
          $results['msg']='permission denied or lack of value';
      }
      return json_encode($results);
  }
  function ds($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
      if (!is_empty($data)&&$data['key']==c_arr($data)) {
          mysql_query("DELETE FROM bsp_servers WHERE `id` = $data[id]");
          if (mysql_error()=='') {
            $results['msg']='success';
          }else{
            $results['msg']=mysql_error();
          }
          // $results='sdfsdf';
      }else{
          $results['msg']='permission denied or lack of value';
      }
      return json_encode($results);
  }
  function ut($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
      if (!is_empty($data)&&$data['key']==c_arr($data)&&$data['t']>0) {
          mysql_query("UPDATE bsp_user SET used = used + $data[t] WHERE `port` = $data[port]");
          if (mysql_error()=='') {
            $results['msg']='success';
          }else{
            $results['msg']=mysql_error();
          }
      }else{
          $results['msg']='permission denied or value of t is illegal';
      }
      return json_encode($results);
  }
  function mu($data){
      global $con;
      global $result;
      mysql_select_db("bsp_db", $con);
      if (!is_empty($data)&&$data['key']==c_arr($data)) {
          $err='';
          if (!is_null($data['pwd'])) {
            mysql_query("UPDATE bsp_user SET pwd = $data[pwd] WHERE `port` = $data[port]");
            $err=mysql_error();
          }
          if (!is_null($data['used'])) {
            mysql_query("UPDATE bsp_user SET used = $data[used] WHERE `port` = $data[port]");
            $err=mysql_error();
          }
          if (!is_null($data['total'])) {
            mysql_query("UPDATE bsp_user SET total = $data[total] WHERE `port` = $data[port]");
            $err=mysql_error();
          }
          if (!is_null($data['due_time'])) {
            mysql_query("UPDATE bsp_user SET due_time = $data[due_time] WHERE `port` = $data[port]");
            $err=mysql_error();
          }
          $sql = "SELECT * FROM bsp_servers";
          $res = mysql_query($sql,$con);
          $results = m_arr($res);
          $sql1="SELECT * FROM `bsp_user` WHERE `port` = $data[port]";
          $res1 = mysql_query($sql1,$con);
          $results1 = m_arr($res1);
          foreach ($results as $k => $v) {
             ss_set($results[$k]['ip'],$results1['port'],$results1['pwd'],$results1['total'],$results1['due_time']);
          }
          $results='';
          if ($err=='') {
            $results['msg']='success';
          }else{
            $results['msg']=$err;
          }
      }else{
          $results['msg']='permission denied or or lack of value';
      }
      return json_encode($results);
  }
  function c_arr($arr){
    	global $result;
    	array_pop($arr);
    	$str = $result['bsp_key'];
    	foreach ($arr as $k => $v) {
    		if ($arr[$k]!=='key') {
    			$str = $str . $arr[$k];
    		}
    	}
    	return md5($str);
  }
  function is_empty($arr){
    	  $empty = true;
    	  foreach($arr as $k=>$v){
          if (!is_null($arr[$k])) {
          	$empty = false;
          	break;
          }
        }
        return $empty;
  }
  function m_arr($result){
    	$results = array();
  	while ($row = mysql_fetch_assoc($result)) {
  	$results[] = $row;
  	}
  	return $results;
  }