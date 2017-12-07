<?php
    include 'source/File.php';
    include 'source/Folder.php';
    include 'source/Common.php';
    include 'source/User.php';

    //include '/connectDatabase.php';
    
    /*{
        "Date":"12-08-2017",
        "Time":"02-05-10",
        "Temperature":"20.15",
        "Radiant":"30.15",
        "UseName":"Den",
        "code":"1321060356"
    }*/
    
    //createFolder('source/Den_1321060356/2017/10/13');

    $Date = "";
    $Time = "";
    $Temperature = "";
    $Radiant = "";
    $UseName = "";
    $code = "";

    //Example : dateTimeNow = 'd/m/Y-H:i:s'
    if (isset($_GET["dateTimeNow"])) {
       $formatDateTime = $_GET["dateTimeNow"];
       echo getDateTimeNow($formatDateTime);
       exit();
    }

    // Main code
    if (login())
    {
        show("Login success!");
        InitData($UseName, $code);
        
        getData();
        writeData();
        echo "OK";
    }
    else echo "False";
    

    function login(){
        GLOBAL $UseName, $code;
        if (isset($_GET["UseName"]) && isset($_GET["code"])){
            $UseName =$_GET["UseName"];
            $code =$_GET["code"];     
            show($UseName);
            show($code);
        }
        return isLogin($UseName, $code);
       
    }
    
    function getData()
    {
        GLOBAL $Date,$Time,$Temperature,$Radiant;
        if (isset($_GET["Date"]))
           $Date =$_GET["Date"];
        if (isset($_GET["Time"]))
           $Time =$_GET["Time"];
        if (isset($_GET["Temperature"]))
           $Temperature =$_GET["Temperature"];
        if (isset($_GET["Radiant"]))
           $Radiant =$_GET["Radiant"]; 
        show($Date);
        show($Time);
        show($Temperature);
        show($Radiant);
    }
    function formatString(){
        GLOBAL $UseName, $code, $Date, $Time, $Temperature, $Radiant; 
        $data="{\"Date\":\"".$Date."\",\"Time\":\"".$Time."\",\"Temperature\":\"".$Temperature."\",\"Radiant\":\"".$Radiant."\",\"UseName\":\"".$UseName."\",\"code\":\"".$code."\"},";
        return $data;
    }
    function writeData(){
        $str = formatString();
        $path = getPathFile();
        if (isNameFile($path) && strlen($str) > 80){
            writeLine($path,$str);
            show("Write".$str);
        }else show("Write not success!");
    }