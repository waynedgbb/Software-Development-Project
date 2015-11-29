<?php

	session_start();
	
	if ($_GET["logout"]==1 AND $_SESSION['id']) {session_destroy(); 
	
		$message="You have been logged out.";
	
	}
	include("connection.php");
	
	if ($_POST['submit']=="Sign Up") {
		
		if(!$_POST['email']) $error.="<br />Please enter your email";
			else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error.="<br />Please check your email.";
			
		if(!$_POST['password']) $error.="<br />Please enter your password";
			else {
				
				if(strlen($_POST['password'])<8)  $error.="<br />Please enter a password with at least 8 charaters.";
				if (!preg_match('`[A-Z]`',$_POST['password'])) $error.="<br />Please include at least one capital letter in your password";
				
			}
			
		if ($error) $error = "There were error(s) in your signup details:".$error;
		else {	
			
			$query="SELECT * FROM user WHERE email= '".mysqli_real_escape_string($link,$_POST['email'])."'";
			
			$result=mysqli_query($link,$query);
			
			$results =mysqli_num_rows($result);
			
			if ($results) $error = "That email address is already registered. DO you want to log in?";
			else {
					
					$query="INSERT INTO `user` (`email`, `password`) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".$_POST['password']."')";
				
					mysqli_query($link,$query);
					
					echo "You've been signed up!!!!";
					
					$_SESSION['id'] = mysqli_insert_id($link);
					$_SESSION['uid'] = mysqli_insert_id($link);
					//print_r($_SESSION);
					
					header("Location:mainpage.php");
					//Redirect to logged in page
				}
			
	}
	}

	if($_POST['submit']=="Log In"){
		
			
			//echo "11111111";
			$query="SELECT * FROM `user` WHERE email='".mysqli_real_escape_string($link,$_POST['loginemail'])."' AND password = '".$_POST['loginpassword']."'";
			
			$result = mysqli_query($link,$query);
			//echo mysqli_num_rows($result);
			
			$row = mysqli_fetch_array($result);
			//if ($row)echo "11111111";
			if($row) {
				
					$_SESSION['id']=$row['id'];
					$_SESSION['uid']=$row['id'];
					
					header("Location:mainpage.php");
					//print_r($_SESSION);
					//Redirect to logged in page
				
			} else {
				
					$error = "We could not find a user with that email and password. Please try again.";
				
				}
			
		}
	
?>

