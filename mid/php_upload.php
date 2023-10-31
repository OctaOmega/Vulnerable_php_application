<?php
	
	date_default_timezone_set('America/Toronto');
	session_start();
	if(!isset($_SESSION["dbUser"]))
	{
		header( "Location: ./php_login.php");
		exit();
	} elseif ($_SESSION["dbUser"] != 'sysadmin') {
		echo '<script>alert("You do not have access to upload files!");</script>';
		header( "Location: ./php_triller8.php");
	}
	
	$GLOBALS['triller'] = $_SESSION['dbUser']; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,500;0,600;1,600;1,700&display=swap" rel="stylesheet">
    <title>Group 1 - Midterm Challenge</title>
</head>



<body style="font-family:'Archivo', sans-serif;" class="bg-light">

	<main role="main" class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-white">
			<a class="navbar-brand" href="#">
    			<img src="group1.png" width="110" alt=""></a>
			<p style="color:#ac3f10; font-size: 30px; text-align:center;">INTERNAL TASK ASSIGNMENT APP</p>
  			

			<div class="dropdown ml-auto">
				<a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle user-action">
					<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
					  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
					  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
					</svg>
					 <?= $triller ?>
					 <b class="caret"></b>
				</a>
				<div class="dropdown-menu">
					<a href="./php_triller8.php" class="dropdown-item">Home</a>
					<div class="divider dropdown-divider"></div>
					<a href='php_logout.php' onclick="notify('Logout Successfull')" class="dropdown-item">Logout</a>
				</div>
			</div>
		</nav>

<?php
	
$targetDir = "upload/";

if (isset($_POST["submit"])) {
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
		
echo <<<EOT
<div class="card">
<div class="card-body"> 
<h2>The file has been uploaded.</h2>
<div><a class="btn btn-secondary" type="button" href="php_fileupload.php">Back</a></div></div></div>
EOT;
		
    } else {
echo <<<FILEUPLOAD
<div class="card">
<div class="card-body">
<h2>Sorry, there was an error uploading your file</h2>
<div>
<button class="btn btn-secondary" type="button" onclick="window.location.href='php_fileupload.php'">Back</button>
</div>
</div>
</div>
FILEUPLOAD;
    }
}
?>

</main>	

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
