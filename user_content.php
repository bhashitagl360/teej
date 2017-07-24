<?php
	require_once 'inc/config.php';

	$json=array();
	$user_id = $_POST['id'];

	if( !empty( $user_id ) ) { 

    $userQuery = "SELECT id, firstname, email, message, image, document_type FROM visitor WHERE id=?";
    if ($user = $mysqli->prepare($userQuery)) {

        if($user === false) {
            die('Wrong User content SQL: ' . $userQuery . ' Error: ' . $mysqli->errno . ' ' . $mysqli->error);
        }

        /* bind param */
        $user->bind_param("i", $user_id);

        /* execute query */
        $user->execute();

        /* store result */
        $user->store_result();

        /* Get the number of rows */
        $num_of_rows = $user->num_rows;

        /* Bind the result to variables */
        $user->bind_result($id, $firstname, $email, $message, $image, $document_type);

        if ($num_of_rows >= "1") { 
            while ($user->fetch()) {
               $json['id'] = $id;
               $json['firstname'] = substr( $firstname, 0, 15 );
               $json['email'] = $email;
               $json['message'] = stripslashes( $message );
               $json['image'] = $image;
               $json['document_type'] = $document_type;
            }
        }else{
            $json['error'] = "User Popup Query Issue: There is some issue with the user query!";
        }  

        /* free results */
        $user->free_result();

    }
	} else {
		$json['error'] = "User Popup Query Issue: Id is empty!";
	}

	echo json_encode($json);

	die();
?>