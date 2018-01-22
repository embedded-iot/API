<html>
    <header>
        <title>Test get list data</title>
    </header>
    <body>
    <style>
        td{ border: 1px solid #bbb;    
            vertical-align: top;
            overflow: scroll;
        }
        table{ margin: 0 auto;}
    </style>
    <?php
            include 'file/txtFile.php';
            $fileDownload = "";

            $UseName ="Den";
            $code = "1321060356";
            $folder =  'Data/'.$UseName."_".$code;

            function view(){
                GLOBAL $folder, $UseName, $code;
                // echo $folder ;
                foreach (array_filter(glob('file/'.$folder.'/*'), 'is_file') as $file)
                {
                    // echo $file."<br/>";
                    if(array_key_exists(basename($file, ".txt"),$_POST)){
                        $NameFile = basename($file, ".txt");
                        $Action =$_POST[$NameFile];
                        // echo $Action;
                        if ($Action == "View") 
                            fileAll($file);
                        else               
                            downloadFile($file);
    
                    }
                }
            }
            
            function getListFile(){
                GLOBAL $folder, $UseName, $code;
                $namefolder = 'file/'.$folder;
                
                foreach (array_filter(glob($namefolder.'/*'), 'is_file') as $file)
                {
                    // echo "+ ".basename($file, ".txt")."  ";
                    echo $file;
                    echo "<input type=\"submit\" name=\"".basename($file, ".txt")."\" value=\"View\" />";
                    echo "<input type=\"submit\" name=\"".basename($file, ".txt")."\" value=\"Download\" /><br/>";
                }
            }
        ?>
        <form method="post">
            
            <table>
                <tr>
                    <td width="30%">
                        <h2>List file</h2>
                        <?php getListFile();?>
                    </td>
                    <td width="70%">
                        <h2>View file</h2>
                        <?php view();?>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>