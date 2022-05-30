<?php
$mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
?>

<?php
$lesInformations = $mysqli->query($laQuestionEnSql);
?>

<?php
$$userId = intval($_GET['user_id']);
?>
