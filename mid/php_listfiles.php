<?php

	date_default_timezone_set('America/Toronto');
	session_start();
	if(!isset($_SESSION["dbUser"]))
	{
		header( "Location: ./php_login.php");
		exit();
	} elseif ($_SESSION["dbUser"] != 'sysadmin') {
		header( "Location: ./php_triller8.php");
	}
	
	$GLOBALS['triller'] = $_SESSION['dbUser']; 

$targetDir = "upload/";
$files = scandir($targetDir);

foreach ($files as $file) {
    if ($file != "." && $file != "..") {
        $fileLink = "upload/{$file}";
        echo "<li><a id='{$file}' href='{$fileLink}'>" . htmlspecialchars($file) . "&nbsp;</a> <button class='copy-button' data-clipboard-text='{$fileLink}'>Copy Link</button></li>";
    }
}
?>

