<?php
// Author: EDB
// Created On: 11st Nov 2017
// E-mail: edb@paituo.me
  $bsp_key='4j9i03mm92js83';
  $port=$_POST["port"];
  $pwd=$_POST["pwd"];
  $limit=$_POST["limit"];
  $key=$_POST["key"];
  if ($port!=''&&$pwd!=''&&$key!='') {
          if ($key==md5($bsp_key.$port.$pwd.$limit)) {
                exec("sudo bsp -p ".$port." -P ".$pwd." -s ".$limit." -a -A -j",$output);
                echo "success:true";
          }else{
            echo "success:false";
          }
  }else{
        echo "success:false";
  }
?>