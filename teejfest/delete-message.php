<?php

	require_once "inc/admin.php";
	$messageId = $_POST['id'];
	$a = $_POST['a'];
	$b = $_POST['b'];

	if( $_SESSION[token_id] != $_POST['a'] ) {
      header("location: dashboard.php");
      exit();
    }

    if( $_SESSION[token_value] != $_POST['b'] ) {
      header("location: dashboard.php");
      exit();
    }

	$sql = "UPDATE visitor SET deleted=1 WHERE id='$messageId'";

	if ($mysqli->query($sql) === TRUE) {
	    echo 1;
	} else {
	    echo 0;
	}
?>