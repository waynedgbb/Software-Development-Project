<?php
	session_start();
	include("connection.php");
	
	$query="UPDATE users SET notes='".mysqli_real_escape_string($link, $_POST['notes'])."' WHERE id = '".$_SESSION['id']."' LIMIT 1";
	
	mysqli_query($link,$query);
	
?>

<form method="post">
	
	<input name="notes" />
	
	<input type="submit" />
</form>