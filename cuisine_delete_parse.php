<?php

session_start();
include("connection.php");
$id = $_GET['id'];

		$sql = "DELETE FROM recipes WHERE cuisine_id ='".$id."'";
		$res = mysql_query($sql) or die(mysql_error());

		$sql = "DELETE FROM cuisines WHERE id='".$id."'";
		$res = mysql_query($sql) or die(mysql_error());

header("Location: mainpage.php");

?>