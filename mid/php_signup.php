<?php
	
	date_default_timezone_set('America/Toronto');
	session_start();
	if(isset($_SESSION["dbUser"]))
	{
		header( "Location: ./php_triller8.php");
		exit();
	}

 ?>
 
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Group 1 - Midterm Challenge</title>
	<link rel="stylesheet" href="style.css" />
	<link rel="stylesheet" 
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
			integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
			crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,500;0,600;1,600;1,700&display=swap" rel="stylesheet">
	
	<script type="text/javascript">
	
       function selectionuser(inputElement) {
            var firstName = inputElement.value;
            var usernameLabel = document.getElementById('uusername');
            usernameLabel.textContent = 'Your User Name: ' + firstName;
        }

        document.addEventListener("DOMContentLoaded", function() {
            var emailInput = document.getElementById('email');
             emailInput.parentElement.addEventListener("click", function() {
				var fnamevalue = document.getElementById('First');
                selectionuser(fnamevalue);
            });
        });

		function vName(element)
		{
			var msg = "";
			const field = element.value;
			
			if(field.length == 0) msg = `${element.id} Name rquired!`;
			
			element.setCustomValidity(msg);
		}
		function vEmail(element)
		{
			var msg = "";
			const field = element.value;

			if(field.length == 0) msg = "E-mail rquired!";
			else if ( field.indexOf(".") < 0 || field.indexOf("@") < 0 || /[^a-zA-Z0-9.@_-]/.test(field)) msg = "Invlaid E-mail format!";
			
			element.setCustomValidity(msg);
		}
		function vPass(element)
		{
			var msg = "";
			const pass1 = element.value;
			const element2 = (element.id == 'pass1'? document.querySelector('#pass2') : document.querySelector('#pass1'));
			const pass2 = element2.value;
			if(pass1.length == 0) msg = "Password required!";
			else if (pass2.length > 0 && pass1 != pass2) msg = "Passwords must match";
			console.log(msg + "..." + element.id + "..." + element.value);
			element.setCustomValidity(msg);
		}
		function vGender()
		{
			radios = document.getElementsByName("gender");

			for (var i = 0; i < radios.length; i++) 
			{
			  if (radios[i].checked) 
			  {
			    radios[0].setCustomValidity("");
				return;
			  }
			}
			radios[0].setCustomValidity("Gender option must be selected");
		}
		function keyPressed(event)	
		{
			if (event.keyCode === 13) document.querySelector('#validate').submit();
		}
		function validate()
		{
			vName(document.querySelector('#First'));
			vName(document.querySelector('#Last'));
			vEmail(document.querySelector('#email'));
			vPass(document.querySelector('#pass1'));
			vPass(document.querySelector('#pass2'));
			vGender();

			return document.querySelector('#validate').checkValidity();
			//return true;
		}
	</script>

</head>

<body>

	<main role="main" class="container">
		<nav class="navbar navbar-expand-lg navbar-light bg-white">
			<a class="navbar-brand" href="#"><img src="group1.png" width="110" alt=""></a>

  	  		<div class="col col-lg-10">
  			<p style="color:#ac3f10; font-size: 40px; text-align:center;">INTERNAL TASK ASSIGNMENT APP</p>
  			</div>
  		</nav>

	
	<div class="card-body">
		<div class="wrap">
		<form method="post" action="#" id="validate" onsubmit="return validate()">
			<h1>Signup</h1>
			<br>
			<div class="half"><input type="text" id="First" name="fname" placeholder="First Name"  autofocus onblur ="vName(this)"></div>
			<div class="half"><input type="text" id="Last" name="lname" placeholder="Last Name" onblur ="vName(this)"></div>
			<div><label id="uusername" class="col-form-label">Your User Name</label></div>
			<div><input type="text" id="email" name="email" placeholder="E-mail" onblur ="vEmail(this)"></div>
			<!-- <div><input type="email" id="email" name="email" placeholder="E-mail" required></div> -->
			<div><input type="password" id="pass1" name="pass1" placeholder="Password" onblur ="vPass(this)"></div>
			<div><input type="password" id="pass2" name="pass2" placeholder="Re-type Password" onblur ="vPass(this)"></div>
			<div>
				<input type="radio" name="gender" value = 'Male' id="rd1" onblur ="vGender()"><label for="rd1">Male</label>
				<input type="radio" name="gender" value = 'Female' id="rd2" onblur ="vGender()"><label for="rd2">Female</label>
				<input type="radio" name="gender" value = 'Other' id="rd3" onblur ="vGender()"><label for="rd3">Other</label>
			</div>
			<hr style="width: 100%; margin: 35px 1px 35px 0;">
		<div>
         <button class="btn btn-secondary" style=" width: 40%; padding: 2%;" type="button" onclick="window.location.href='php_login.php'">Login</button>
				<input class="btn btn-primary"style=" width: 40%; padding: 2%;" type="submit" value="Register...">
			</div>
		</form>
		</div>
	</div>
	
<?php


	require_once("dbTriller.php");

	$trillDB = new dbTriller();
 
		if( !$trillDB->connected() ) exit("Databas Error");


		if(!empty($_POST))
		{
			if (verifyPassword($_POST['pass1'],$_POST['pass2']))
			{
				$_POST['pass1'] = $_POST['pass2'];
			}
		}	
		
		if(!empty($_POST))
		{
			if (verifyFname(isset($_POST['fname'])))
			{
				if (verifyLname(isset($_POST['lname']))) 
				{
					if(verifyEmail(isset($_POST['email']))) 
					{
						if (isset($_POST['pass1']))
						{
							if (verifyGender(isset($_POST['gender']))) 
							{
								$respon = $trillDB->checkuser($_POST['fname']);

								if(!$respon) {
									
									$trillDB->useradd($_POST['fname'], $_POST['lname'], $_POST['gender'], $_POST['email'], $_POST['pass1']);
									echo '<script>alert("User Created! First Name is Your UserName!");</script>';
								
								} else {
									
									echo '<script>alert("User already exists ! Please login.");</script>';
								}
								
								unset($_POST);
							}
			}	}	}	}
			
			exit();
		}

		function verifyFname($field)
		{
			if($field == "") echo "First Name required!<br>";
			return $field;
		}
		function verifyLname($field)
		{
			if($field == "") echo "Last Name required!<br>";
			return $field;
		}
		function verifyEmail($field)
		{
			if($field == "") echo "E-mail required!";
			if((strpos($field, '.') == false) || (strpos($field, '@') == false) || preg_match("/[^a-zA-Z0-9.@_-]/", $field)) return "Invalid E-mail format!";	
			return $field;
		}
		function verifyPassword($pass1, $pass2)
		{
			if($pass1 == "") echo "Password required!<br>";
			if($pass1 !== $pass2) echo "Password must match!<br>";
			return $pass1;
		}
		function verifyGender($field)
		{
			if($field == "") echo "Gender not selected!<br>";
			return $field;
		}
 ?>
 
</body>
</html>