<?php
/***********************************
*
*	Index.php
*
************************************/

session_start();

if(isset($_SESSION['dbuser']))
{
	header( "Location: ./php_triller8.php");
	exit();
}
else
{
	header( "Location: ./php_login.php");
}
?>