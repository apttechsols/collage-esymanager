<?php
    /*

    *@filename DirectoryDeleteWithFiles/index.php
    *@des It return Available if Data alredy exixt
    *@Author Arpit sharma
    */

    // Not show any error
    error_reporting(0);
    // Get server port type (exampale - http:// or https://)
    if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) {
        $HeaderSecureType = "https://";
    }else{
        $HeaderSecureType = "http://";
    }
    // Create Domain name and save it in const variable
    define("DomainName",  $HeaderSecureType.$_SERVER['HTTP_HOST']);

    if(!isset($FileAccessCode) || $FileAccessCode !== 'Granted_Permisition_w65!4GsD6t*P_B&BMX2U_E9ZUuRH94GvN_xNbUH'){
        header("Location: " . DomainName . "/PageNotAvailable/index.php");
        die();
        exit();
    }

    function DirDeleteWithFiles($GivenDir){
        if(strlen($GivenDir) == 0){
            return ["status"=>"Error","msg"=>"Process failed! Try again later1"]; exit();
        }

        if (!is_dir($GivenDir)) {
            return ["status"=>"Error","msg"=>"$GivenDir must be a directory","code"=>400]; exit();
        }
        $files = glob($GivenDir.'/*');  
   
        // Deleting all the files in the list 
        foreach($files as $file) { 
           
            if(is_file($file)){  
            
                // Delete the given file 
                unlink($file); 
            }
        }

       rmdir($GivenDir);
       return ["status"=>"Success","msg"=>"Given directory delete successfully","code"=>200]; exit();
    }
?>