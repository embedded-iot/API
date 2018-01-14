<?php
  function isNameFolder($nameFolder) {
    return is_dir($nameFolder);
  }

  function createFolder($nameFolder){
    if (!isNameFolder($nameFolder))
      mkdir($nameFolder, 0777, true);
  }

  function dirToArray($dir) { 
    
    $result = array(); 
 
    $cdir = scandir($dir); 
    foreach ($cdir as $key => $value) 
    { 
       if (!in_array($value,array(".",".."))) 
       { 
          if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
          { 
             $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
          } 
          else 
          { 
             $result[] = $value; 
          } 
       } 
    } 
    
    return $result; 
 } 

 function getDirectories($path)
 {
		$directories = [];
		if (!isNameFolder($path)) {
			return $directories;
		}
     $items = scandir($path);
     foreach ($items as $item) {
         if($item == '..' || $item == '.')
             continue;
         if(is_dir($path.'/'.$item))
             $directories[] = $item;
     }
     return $directories;
 }
 
function downloadZipperFolder($path){
    $path = $path;
    $zip = new ZipArchive();
    $dir = $path;

    $filename = basename($dir).".zip";
   
    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
     exit("cannot open <$filename>\n");
    }
   
    
   // Create zip
    createZip($zip,$dir);
    
    $zip->close();
    // set example variables
    //$filename = "myzipfile.zip";

    // http headers for zip downloads
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"".$filename."\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($filename));
    // ob_end_flush();
    // @readfile($filename);
    ob_clean();
    flush();
    readfile($filename);
    unlink($filename);
    exit;
 }
 function createZip($zip,$dir){
    
    if (is_dir($dir)){
   
     if ($dh = opendir($dir)){
      while (($file = readdir($dh)) !== false){
    
       // If file
       if (is_file($dir.$file)) {
        if($file != '' && $file != '.' && $file != '..'){
    
         $zip->addFile($dir.$file);
        }
       }else{
        // If directory
        if(is_dir($dir.$file) ){
   
         if($file != '' && $file != '.' && $file != '..'){
   
          // Add empty directory
          $zip->addEmptyDir($dir.$file);
   
          $folder = $dir.$file.'/';
    
          // Read data of the folder
          createZip($zip,$folder);
         }
        }
    
       }
    
      }
      closedir($dh);
     }
    }
}