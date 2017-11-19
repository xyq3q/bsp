<?php
// Author: EDB
// Created On: 11st Nov 2017
// E-mail: edb@paituo.me
  $bsp_key='4j9i03mm92js83';
  $port=$_POST["port"];
  $key=$_POST["key"];
  if ($port!=''&&$key!='') {
          if ($key==md5($bsp_key.$port)) {
                exec("sudo bsp -p ".$port." -d -D -R",$output);
                echo "success:true";
          }else{
            echo "success:false";
          }
  }else{
        echo "success:false";
  }
?>