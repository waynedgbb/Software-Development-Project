<?php
session_start();
include("connection.php");
$cuisine_title = $_POST['cuisine_title'];
$uid = $_SESSION['uid'];


		$sql = "INSERT INTO cuisines (cuisine_title, user_id, last_post_date) VALUES ('".$cuisine_title."', '".$uid."', now())";
		$res = mysql_query($sql) or die(mysql_error());
		header("Location: mainpage.php");

?>