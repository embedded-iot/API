<?php

  $AdminUseName = "admin";
  $Admincode ="12345678";


  function isLogin($UseName, $code){
    if (isNameFolder("data/".$UseName."_".$code))
      return true;
    return false;
  }

  function isAdmin($UseName, $code){
    GLOBAL $AdminUseName, $Admincode;
    if (strcmp($UseName, $AdminUseName) == 0 && strcmp($code, $Admincode) == 0) 
      return true;
      
    return false;
  }

  function createUse($UseName, $code){
    if (!isNameFolder("data/".$UseName."_".$code))
      createFolder("data/".$UseName."_".$code);

  }
  

  