<?php 
/* -----------------------------------------------------------------------------------------
   Adglobal360 - Vipin Yadav - http://www.adglobal360.com/
   -----------------------------------------------------------------------------------------
*/
    require_once 'config/config.php';

 

    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
        session_destroy();
    } 
    header('Location: '. siteUrl);
    exit();
?>
