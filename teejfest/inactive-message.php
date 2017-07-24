<?php
	require_once "inc/admin.php";

	$messageId = $_POST['id'];

	$sql = "UPDATE visitor SET status=0 WHERE id='$messageId'";

	if ($mysqli->query($sql) === TRUE) {
	    echo 1;
	} else {
	    echo 0;
	}
?>