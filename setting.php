<?php
 
    include 'source/File.php';
    include 'source/Folder.php';
    include 'source/Common.php';
    include 'source/User.php';

    //include '/connectDatabase.php';
    
    /*{
        "name":"",
        "lastupdate":"02-05-10",
        "devices":[
          {"id": 0, "state": true}
        ]
    }*/
    

    $Date = "";
    $Time = "";
		$Data = "";
		$Model = "/Default";
    $UseName = "";
		$code = "";
		
    if (isset($_REQUEST['Model'])) {
			$Model = '/'.$_REQUEST['Model'];
    }
    
    // Main code
    if (login())
    {
        show("Login success!");
        InitConfig($Model, $UseName, $code);
        getData();
        // writeData();
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
				//Make sure that it is a POST request.
        if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') == 0){
          // POST config
          if (isset($_GET["action"])) {
            if ($_GET["action"] == 'initDevices' && isset($_GET["totalDevices"])) {
              $totalDevices = $_GET["totalDevices"];
              initDevices((int)$totalDevices);
            } else {
              echo "false";
            }
          }
          else {
            postConfig();
          }
        } else if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') == 0) {
          // GET config
          getConfig(); 
        }
				
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
        } else show("Write not success!");
    }


    function getConfig() {
      GLOBAL $UseName, $code, $Model;
      $createFolder= 'Data/'.$UseName.'_'.$code.$Model;
      $path = $createFolder.'/config.json';
      echo readFileAll($path);
    }

    function postConfig() {
      //Make sure that the content type of the POST request has been set to application/json
      $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
      if(strcasecmp($contentType, 'application/json') != 0){
          throw new Exception('Content type must be: application/json');
      }
      
      //Receive the RAW post data.
      $content = trim(file_get_contents("php://input"));
      
      //Attempt to decode the incoming RAW post data from JSON.
      $decoded = json_decode($content);
      
      //If json_decode failed, the JSON is invalid.
      if(!is_object($decoded)){
          throw new Exception('Received content contained invalid JSON!');
      }
      $dateNow =  getDateTimeNow('d:m:Y-H:i:s');
      $decoded->lastupdate = $dateNow;
      GLOBAL $UseName, $code, $Model;
      $createFolder= 'Data/'.$UseName.'_'.$code.$Model;
      $path = $createFolder.'/config.json';
      writeLineMode($path, 'w+', json_encode($decoded, JSON_UNESCAPED_UNICODE));
      echo "true";
    }
 
    function initDevices($totalDevices) {
      GLOBAL $UseName, $code, $Model;
      $createFolder= 'Data/'.$UseName.'_'.$code.$Model;
      $path = $createFolder.'/config.json';
      $str_config = readFileAll($path);
      $decoded = json_decode($str_config);
      $decoded->name="";
      $dateNow =  getDateTimeNow('d:m:Y-H:i:s');
      $decoded->lastupdate = $dateNow;
      $decoded->devices = [];
      $decoded->totalDevices = $totalDevices;
      for ($index = 0 ; $index < $totalDevices; $index++) {
        $obj = new stdClass;
        $obj->id = $index;
        $obj->state = false;
        array_push($decoded->devices, $obj);
      }
     
      writeLineMode($path, 'w+', json_encode($decoded, JSON_UNESCAPED_UNICODE));
      echo "true";
    }