<?php
    function isNameFile($filename) {
         return file_exists($filename);
    }

   
    function writeLine($nameFile,$str){
        if (isNameFile($nameFile))
         {
            $myfile = fopen($nameFile, "a") or die("Unable to open file!");
            //  fwrite($myfile, $str);
            fwrite($myfile, "\n". $str);
            fclose($myfile);
         }
    }
    function writeLineMode($nameFile, $mode, $str){
        if (isNameFile($nameFile))
         {
            $myfile = fopen($nameFile, $mode) or die("Unable to open file!");
            //  fwrite($myfile, $str);
            fwrite($myfile, $str);
            fclose($myfile);
         }
    }

    function createFile($nameFile){
        if (!isNameFile($nameFile))
            $myfile = fopen($nameFile, "w");
    }
    
    function downloadFile($filename){
        
        $file = $filename;
        if (file_exists($file))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

    function fileAll($filename){
        $file = fopen($filename,"r");
        
        while(!feof($file))
          {
            echo fgets($file). "<br />";
          }
        
        fclose($file);
    }
    
    

    function getFile($path)
    {
        $listFile = [];
        $items = scandir($path);
        foreach ($items as $item) {
            if(is_file($path.'/'.$item))
                $listFile[] = $item;
        }
        return $listFile;
    }
    function dataFile($filename){
        $file = fopen($filename,"r");
        $members = array();
        while (!feof($file)) {
            $mystring = fgets($file); 
            $members[] = rtrim ($mystring, PHP_EOL);
        }
        //var_dump($members);

        fclose($file);
        return $members;
    }
    function dataFile1($filename){
        $file = fopen($filename,"r");
        $stringFile = '';
        while (!feof($file)) {
            $line = '';
            $line = fgets($file);
            $stringFile =  $stringFile. $line;
        }
        //var_dump($members);
        // echo  $stringFile;
        fclose($file);
        $stringFile = $stringFile.'End';
        return str_replace(',End','', $stringFile );
    }

    function readFileAll($filename){
        $file = fopen($filename,"r");
        $stringFile = '';
        while (!feof($file)) {
            $line = '';
            $line = fgets($file);
            $stringFile =  $stringFile. $line;
        }
        fclose($file);
        return $stringFile;
    }