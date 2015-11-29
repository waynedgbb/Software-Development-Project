<?php

session_start();
$title = $_POST['title'];
$content = $_POST['content'];
$id = $_POST['recipe_id'];
include("connection.php");

		$sql = "UPDATE recipes SET title='".$title."', content='".$content."' WHERE id='".$id."' ";
		$res = mysql_query($sql) or die(mysql_error());

header("Location: mainpage.php");

?>