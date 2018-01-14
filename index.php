<?php

  include 'source/File.php';
  include 'source/Folder.php';
  include 'source/Common.php';
  include 'source/User.php';
  include 'source/Json.php';

  $UseName = "";
  $code = "";
  $idAction = -1;
  $Model = "Test/";


  /* Function MAIN*/
  getUse();

  if (isset($_REQUEST['Model'])) {
    $md = $_GET['Model'];
    if (strcmp($md, "Inventer") == 0) {
      $Model = "Inventer/";
    }
  }
  show($Model);
  // check admin
  if (isAdmin($UseName, $code)){
    
    show("Admin account");
    checkCreateUse();
    exit();
  }else {
    show("User account");
    
    $idAction = getAction();
    functionAction($idAction);


  }
  // END MAIN 


  function getUse(){
    GLOBAL $UseName,$code;
    if (isset($_REQUEST['UseName'])  && isset($_REQUEST['code'])){
      $UseName = $_REQUEST['UseName'];
      $code = $_REQUEST['code'];
      show($UseName);
      show($code);
    }
  }

  function getAction(){
    
    if (isset($_REQUEST['action']))
    {
      $action = $_REQUEST['action'];
      if (strcmp($action, "isCheckLogin") == 0)
        return 0;
      else if (strcmp($action, "getYearOfUser") == 0)
        return 1;
      else if (strcmp($action, "getMonthOfYear") == 0)
        return 2;
      else if (strcmp($action, "getDayOfMonth") == 0)
        return 3;
      else if (strcmp($action, "getFileOfDay") == 0)
        return 4;
      else if (strcmp($action, "getDataOfFile") == 0)
        return 5;
      else if (strcmp($action, "downloadMonthOfYear") == 0)
        return 6;
      else if (strcmp($action, "downloadDayOfMonth") == 0)
        return 7;
      else if (strcmp($action, "getInforAccount") == 0)
        return 8;
      else if (strcmp($action, "getCurrentData") == 0)
        return 9;
      
    }
    return -1;
  }
  function functionAction($idaction){
    switch ($idaction){
      case 0: ischeckLogin(); break;
      case 1: getYearOfUser(); break;
      case 2: getMonthOfYear(); break;
      case 3: getDayOfMonth(); break;
      case 4: getFileOfDay(); break;
      case 5: getDataOfFile(); break;
      case 6: downloadMonthOfYear(); break;
      case 7: downloadDayOfMonth(); break;
      case 8: getInforAccount(); break;
      case 9: getCurrentData(); break;
      
    }
  }

  function checkCreateUse(){
    GLOBAL $Model;
    $createUseName = "";
    $createcode = "";
    if (isset($_REQUEST['createUseName'])  && isset($_REQUEST['createcode'])){
      $createUseName = $_REQUEST['createUseName'];
      $createcode = $_REQUEST['createcode'];
      InitData($Model, $createUseName, $createcode);
      echo "OK";
    }
  }

  function ischeckLogin(){
    GLOBAL $UseName, $code, $Model;
    if (isLogin($Model, $UseName, $code)){
      InitData($Model, $UseName, $code);
      echo 'true' ;
    }else echo 'false' ;
  }
  
  function  getYearOfUser(){
    GLOBAL $UseName, $code, $Model;
    $path = $Model. $UseName."_".$code;
    echo convertArrayToJson(getDirectories($path)) ;
  }

  function  getMonthOfYear(){
    GLOBAL $UseName, $code, $Model;
    if (isset($_REQUEST['Year'])){
      $Year = $_REQUEST['Year'];
      $path = $Model. $UseName."_".$code.'/'.$Year;
      echo convertArrayToJson(getDirectories($path)) ;
    }
    else echo "False";
  }

  function  getDayOfMonth(){
    GLOBAL $UseName, $code, $Model;
    if (isset($_REQUEST['Year']) && isset($_REQUEST['Month'])){
      $Year = $_REQUEST['Year'];
      $Month = $_REQUEST['Month'];      
      $path = $Model. $UseName."_".$code.'/'.$Year.'/'.$Month;
      echo convertArrayToJson(getDirectories($path)) ;
    } else echo "False";
  }
  
  function  getFileOfDay(){
    GLOBAL $UseName, $code, $Model;
    if (isset($_REQUEST['Year']) && isset($_REQUEST['Month']) && $_REQUEST['Day']){
      $Year = $_REQUEST['Year'];
      $Month = $_REQUEST['Month'];      
      $Day = $_REQUEST['Day'];      
      
      $path = $Model.$UseName."_".$code.'/'.$Year.'/'.$Month.'/'.$Day;
      if (isNameFolder($path)){
        echo convertArrayToJson(getFile($path)) ;
      } else echo "[]"; 
    } else echo "False";
  }

  function  getDataOfFile(){
    GLOBAL $UseName, $code, $Model;
    if ( isset($_REQUEST['Year']) && isset($_REQUEST['Month']) && isset($_REQUEST['Day']) ) {
      $Year = $_REQUEST['Year'];
      $Month = $_REQUEST['Month'];      
      $Day = $_REQUEST['Day'];      
      $NameFile = $Day."_".$Month."_".$Year.".txt";      
      
      $path = $Model. $UseName."_".$code.'/'.$Year.'/'.$Month.'/'.$Day."/".$NameFile;
    
      if (isNameFile($path)){

        //$books1 = json_decode(dataFile1($path));
       
        $jsonTest ='';
        if (strlen(dataFile1($path)) > 5)
        {
          $jsonTest = '['.dataFile1($path).']';
         
        }
        else  $jsonTest = '[]';
        show($jsonTest);
        // echo json_decode($jsonTest);
       // echo $jsonTest ; 
        $book2 = json_decode($jsonTest);
        //echo convertArrayToJson($books1);
        echo convertArrayToJson($book2) ;
      } else echo "[]";
    } else echo "False";
  }
  function downloadMonthOfYear(){
    GLOBAL $UseName, $code, $Model;
    if (isset($_REQUEST['Year']) && isset($_REQUEST['Month'])){
      $Year = $_REQUEST['Year'];
      $Month = $_REQUEST['Month'];      
     
      $path = $Model.$UseName."_".$code.'/'.$Year.'/'.$Month.'/';
      downloadZipperFolder($path);
    } else echo "False";
  }
  function downloadDayOfMonth(){
    GLOBAL $UseName, $code, $Model;
    if (isset($_REQUEST['Year']) && isset($_REQUEST['Month']) && $_REQUEST['Day']){
      $Year = $_REQUEST['Year'];
      $Month = $_REQUEST['Month'];      
      $Day = $_REQUEST['Day'];      
      
      $path = $Model. $UseName."_".$code.'/'.$Year.'/'.$Month.'/'.$Day.'/'.$Day.'_'.$Month.'_'.$Year.'.txt';
      show($path);
      downloadFile($path);
    } else echo "False";
  }
  
  function getInforAccount(){
    GLOBAL $UseName, $code, $Model;
    $path = $Model."account.txt";
    if (isNameFile($path)){
      if (strlen(dataFile1($path)) > 5)
      {
        $jsonTest = '['.dataFile1($path).']';

      }
      else  $jsonTest = '[]';
      show($jsonTest);
      // echo json_decode($jsonTest);
      // echo $jsonTest ; 
      $book2 = json_decode($jsonTest);
      //echo convertArrayToJson($books1);
      //echo $book2;
      $inforAccount;
      $index = 0;
      for ($index = 0; $index < count($book2); $index++)
      {
        $item = $book2[$index];
        if (strcmp($UseName, $item->UseName) == 0 && strcmp($code, $item->code) == 0) {
          $inforAccount = $item;
          echo convertArrayToJson($inforAccount) ;
          exit();
        }
      }
      $inforAccount = json_decode('{}');
      echo convertArrayToJson($inforAccount) ;
    } else {
      $inforAccount = json_decode('{}');
      echo convertArrayToJson($inforAccount) ;
    }
  }
  
  function getCurrentData(){
    GLOBAL $UseName, $code, $Model;
    if ( isset($_REQUEST['Year']) && isset($_REQUEST['Month']) && isset($_REQUEST['Day']) ) {
      $Year = $_REQUEST['Year'];
      $Month = $_REQUEST['Month'];      
      $Day = $_REQUEST['Day'];      
      $NameFile = $Day."_".$Month."_".$Year.".txt";      
      
      $path = $Model. $UseName."_".$code.'/'.$Year.'/'.$Month.'/'.$Day."/".$NameFile;
    
      if (isNameFile($path)){

        //$books1 = json_decode(dataFile1($path));
       
        $jsonTest ='';
        if (strlen(dataFile1($path)) > 5)
        {
          $jsonTest = '['.dataFile1($path).']';
        }
        else  $jsonTest = '[]';
        // echo json_decode($jsonTest);
       // echo $jsonTest ; 
        $book2 = json_decode($jsonTest);
        //echo convertArrayToJson($books1);
        $len = count($book2);
        if ($len  > 0) {
          echo convertArrayToJson($book2[$len-1]);
          exit();
        }
        $inforAccount = json_decode('{}');
        echo convertArrayToJson($inforAccount) ;
      }else {
        $inforAccount = json_decode('{}');
        echo convertArrayToJson($inforAccount) ;
      }
    } else echo "False";
  }

  
 