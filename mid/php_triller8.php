<?php  

session_start();

if(!isset($_SESSION["dbUser"]))
{
	header("Location: ./php_login.php");
	exit();
}

	$GLOBALS['triller'] = $_SESSION['dbUser']; 
?>			

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link 	rel="stylesheet" 
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
			integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
			crossorigin="anonymous">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,500;0,600;1,600;1,700&display=swap" rel="stylesheet">

  <title>Group 1 - Midterm Challenge</title>
</head>

<body style="font-family:'Archivo', sans-serif;" class="bg-light">

	<script type="text/javascript">
		function notify(msg)
		{
			x = document.getElementById("trillMsg");
			if(x)
			{
				x.innerHTML = "<b>" + msg + "</b>";
				x.style.display = "block";
				setTimeout(function(){ x.style.display="none"; }, 2000)
			}
		}
	</script>

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
				<?php 
				 if ($_SESSION["dbUser"] != 'sysadmin') {
					echo '<a href="#" onclick="notify(' . '`You do not have access to upload files!`' . ')" class="dropdown-item">Upload File</a>';
				 } else {
					 echo '<a href="php_fileupload.php" class="dropdown-item">Upload File</a>';
				 }
					
				?>	
					<div class="divider dropdown-divider"></div>
               <a href="php_searchposts.php" class="dropdown-item">Search</a>
           <div class="divider dropdown-divider"></div>
					<a href='php_logout.php' onclick="notify('Logout Successfull')" class="dropdown-item">Logout</a>
				</div>
			</div>
		</nav>
   		<div class="col col-lg-6">
        	<p style="color:CornflowerBlue; font-size: 25px;">Welcome : Following tasks assigned to you!</p>
   		</div>
   		
	<?php

		require_once("dbTriller.php");
   
		function displayPosts($db)
		{
			$posts = $db->getUserPosts();
			if($posts && count($posts) > 0)
			{
				foreach($posts as $row => $col)
				{
					$action = "?id=" . $col['id'];

echo <<<HERE
<div class='pb-3 mb-0 medium lh-sm border-bottom w-100'>
{$col['pdate']}
<div class='d-flex justify-content-between'>
<strong class='text-gray-dark'>>>{$col['name']}</strong>
<a href={$action}>Remove Post {$col['id']}</a>
</div>
<span class='d-block'>{$col['post']}</span>
</div>
HERE;
				}
			}
		}

		$htmlTab = "&emsp;";
		
		$trillDB = new dbTriller();
		if( !$trillDB->connected() ) exit("Databas Error");

echo <<<EOT
<div style="font-size: 25px;" class="my-3 p-3 bg-white rounded box-shadow">
<div class="row">
<div class="col-lg-6"><b>Hi !</b>{$htmlTab}<a href='#'>{$triller}</a><br><br></div>
<div class="col-lg-6">
<form method="post">
<div class="col-auto">
<input type="text" class="form-control mb-2" id="trillPost" name="trillPost" placeholder="Let's get it...">
<button type="submit" onclick="if(document.getElementById('trillPost').value == '') notify('You gotta say somethin...');" class="btn btn-primary mb-2">A S S I G N</button>
</div>
</form>
</div>
</div>
</div>
<div class="my-3 p-3 bg-white rounded box-shadow">
EOT;
          
          if(isset($_POST['trillPost']) && $_POST['trillPost'] != '')
          		{
             
          			$trillDB->postTrill($_SESSION['dbUser'], htmlentities(addslashes($_POST['trillPost'])));
          			unset($_POST);
                }
                
      		if(!empty($_GET['id']))
      		{
      			$trillDB->removeTrill($_GET["id"]);
      			unset($_GET);
      			header( "Location: {$_SERVER['PHP_SELF']}");
      		}
      
      		displayPosts($trillDB);
?>

	</div>

	<footer class="fixed-bottom text-white bg-primary">
	    <div class="container text-center">
	        <span>&copy; <?php echo date("Y"); ?> Group 1 </span>
	    </div>
	    <div class="alert alert-success alert-dismissable" style="display:none" id="trillMsg"></div>
	</footer>

</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>
