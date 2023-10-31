<?php

    require_once("dbTriller.php");
    
    session_start();
    
    if(isset($_SESSION['dbUser']))
    {
    	header( "Location: ./php_triller8.php");
    	exit();
    }
    
    $trillDB = new dbtriller();
    
    if( !$trillDB->connected() ) exit("Database Error");
    
    if(isset($_POST['user']))
    {
    	$usr = trim($_POST["user"]);
    	$pas = trim($_POST["pass"]);
    
    	$res = $trillDB->authenticate(1, $usr, $pas);  
 
    if($res)
    {
    $_SESSION['dbUser']	= $res['name'];	
    $_SESSION['dbPass'] = $res['pass'];
    $_SESSION['htUser'] = $usr;
    
    if(!empty($_POST["remem"]))
    {

    	setcookie('triller', $usr . '|' . $pas, 0, '/');
    }
    else {
    	setcookie('triller','', 0, '/');
    }
    
    header("Location: ./php_triller8.php");
    unset($_POST);
    exit();
    
    }
    
    else
      {
      	echo("<script> var note = 1; </script>");
      }
    }
 ?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" 
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
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
			<a class="navbar-brand" href="#"><img src="group1.png" width="110" alt=""></a>

  	  		<div class="col col-lg-10">
  			<p style="color:#ac3f10; font-size: 40px; text-align:center;">INTERNAL TASK ASSIGNMENT APP</p>
  			</div>
  		</nav>

  		<div class="container">
  			<div class="row">
  				<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
  					<div class="card card-signin my-5" style="border-radius: 1rem;box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);">
  						<div class="card-body">
  							<h5 class="card-title text-center"></h5>

  		<form id="post" method="post" class="form-signin">
  		<div class="form-label-group" style="position: relative;margin-bottom:1rem;">
  		<input type="text" name="user" id="user" class="form-control" placeholder="Email" required autofocus>
  		</div>
  		<div class="form-label-group" style="position: relative;margin-bottom:1rem;">
  		<input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required>
  		</div>
  			<div class="custom-control custom-checkbox md-3" style="position: relative;margin-bottom:1rem;">
  				<input type="checkbox" name="remem" id="remem" class="custom-control-input">
  				<label class="custom-control-label" for="remem">Remember Me</label>
  			</div>

  			<div class="row justify-content-center">
  				<button class="btn btn-lg btn-primary btn-block" type="submit" style="width:80%;font-size: 80%;border-radius: 5rem;">Log in</button>
  			</div>
  		</form>
  			<hr class="my-3">
  		<form action="php_signup.php">
  			<div class="row justify-content-center">
  				<button class="btn btn-lg btn-primary btn-block" type="submit" style="width:80%;font-size: 80%;border-radius: 5rem;">Sign up</button>
  			</div>
  		</form>
  		</div>
  		</div>
		</div>
		</div>
		</div>
	<footer class="fixed-bottom text-white bg-primary">
		<div class="container text-center">
			<span>&copy; Group 1</span>
		</div>
		<div class="alert alert-success alert-dismissable" style="display:none;" id="trillMsg"></div>
	</footer>


<script type="text/javascript">

	for(var i =0; i < cs.length; i++)
	{
		var cookie = cs[i].split("=");
		if(cookie[0].trim() == "triller")
		{
			var val = decodeURIComponent(cookie[1]).split('|');
			document.getElementById("user").setAttribute('value', val[0]);
			document.getElementById("pass").setAttribute('value', val[1]);
			document.getElementById("remem").setAttribute('checked', 'true');
			break;
		}
	}
</script>

<script>

	if (typeof note !== 'undefined' && note !== null) {
    notify('Invalid Log in');
}

</script>

</main>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>