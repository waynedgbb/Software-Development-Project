<?php
session_start();
include("connection.php");
$cuisine_id = $_POST['recipe_cuisine'];
$title = $_POST['title'];
$content = $_POST['content'];


		$sql = "INSERT INTO recipes (content, title, cuisine_id) VALUES ('".$content."', '".$title."', '".$cuisine_id."')";
		$res = mysql_query($sql) or die(mysql_error());


header("Location: mainpage.php");

?>