<?php
	session_start();
	unset($_SESSION['login_user']);
	unset($_SESSION['role_id']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_type']);
	session_destroy();

	header("Location: index.php");
	exit;
?>