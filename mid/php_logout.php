<?php
/***********************************
*
*	php_logout.php
*
************************************/

session_start();

	$_SESSION = array();
	session_destroy();
	header( "Location: ./");
?>