<?php
	require_once "../inc/config.php";
    $uid = $_SESSION['login_user'];
    if(!(isset($uid))){
         header("location: index.php");
         exit();
    }

    $role_id = $_SESSION['role_id'];

    $roleQuery = "SELECT type FROM role WHERE id=?";
    if ($role = $mysqli->prepare($roleQuery)) {

    	/* bind param */
        $role->bind_param("i", $role_id);

        /* execute query */
        $role->execute();

        /* store result */
        $role->store_result();

        /* Get the number of rows */
        $num_of_rows = $role->num_rows;

        /* Bind the result to variables */
        $role->bind_result($type);

        if ($num_of_rows >= "1") { 
            while ($role->fetch()) {
                $_SESSION['user_type'] = $type;
            }
        } else {
        	$_SESSION['user_type'] = ''	;
        }
        
        /* free results */
        $role->free_result();

    }
?>
