<?php

  $AdminUseName = "admin";
  $Admincode ="12345678";


  function isLogin($model, $UseName, $code){
    if (isNameFolder('Data/'.$UseName."_".$code.$model))
      return true;
    return false;
  }

  function isAdmin($UseName, $code){
    GLOBAL $AdminUseName, $Admincode;
    if (strcmp($UseName, $AdminUseName) == 0 && strcmp($code, $Admincode) == 0) 
      return true;
      
    return false;
  }

  function createUse($model, $UseName, $code){
    if (!isNameFolder('Data/'.$UseName."_".$code.$model)) {
      createFolder('Data/'.$UseName."_".$code.$model);
    }
  }


  