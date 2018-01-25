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
		$Data = "";
		$Model = "/Default";
    $UseName = "";
		$code = "";
		

    //Example : dateTimeNow = 'd/m/Y-H:i:s'
    if (isset($_GET["dateTimeNow"])) {
       $formatDateTime = $_GET["dateTimeNow"];
       echo getDateTimeNow($formatDateTime);
       exit();
    }

    if (isset($_REQUEST['Model'])) {
			$Model = '/'.$_REQUEST['Model'];
    }
    
    // Main code
    if (login())
    {
        show("Login success!");
        InitData($Model, $UseName, $code);

        getData();
        writeData();
        echo "OK";
    }
    else echo "False";
    

    function login(){
			GLOBAL $UseName, $code, $Model;
			if (isset($_GET["UseName"]) && isset($_GET["code"])){
					$UseName =$_GET["UseName"];
					$code =$_GET["code"];     
					show($UseName);
					show($code);
			}
			return isLogin("" , $UseName, $code);
    }
    
    function getData()
    {
        GLOBAL $Date,$Time,$Data;
					$Date =getDateTimeNow("d-m-Y");
					$Time =getDateTimeNow("H:i:s");
        if (isset($_GET["Data"]))
					$Data =$_GET["Data"];
				show($Date );
        show($Time);
        show($Data);
				
    }
    function formatString(){
        GLOBAL $UseName, $code, $Date, $Time, $Data;
        $strData="{\"Date\":\"".$Date."\",\"Time\":\"".$Time."\",".$Data."},";
				show($strData);
				return $strData;
    }
    function writeData(){
        $str = formatString();
        $path = getPathFile();
        if (isNameFile($path)){
            writeLine($path,$str);
            show("Write".$str);
        }else show("Write not success!");
    }