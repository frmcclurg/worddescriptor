<?php
   /**
    * @file errors.php
    */

   // report all PHP errors
   ini_set('display_errors','1');
   ini_set('display_startup_errors','1');
   
   // Do not display 'used before
   // initialized' variables
   error_reporting( E_ALL ^ E_NOTICE );
?>
