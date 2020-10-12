<?php
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        
        return false;
    }


    $errstr = htmlspecialchars($errstr);

    switch ($errno) {
    case E_USER_ERROR:
      
        exit(1);

    case E_USER_WARNING:
      
        break;

    case E_USER_NOTICE:
      
        break;

    default:
       
        break;
    }
    error_log("Warning : $errstr \n", 3, "upload/error_log.txt");

    
    return true;
}
?>