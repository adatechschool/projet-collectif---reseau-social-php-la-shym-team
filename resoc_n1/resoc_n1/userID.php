<?php
// Old way to get the id
//$userId = intval($_GET['user_id']);

//New, safer way to get the id
session_start();

$userId = intval($_SESSION['connected_id']);

?>

