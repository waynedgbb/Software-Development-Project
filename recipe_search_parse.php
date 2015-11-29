<?php
session_start();
$word = $_GET['word'];

$_SESSION['search_word'] = $word;

header("Location: recipes.php");

?>