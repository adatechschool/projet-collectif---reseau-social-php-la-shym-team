<?php
// détruite la session
session_start();
session_destroy();
// rediriger vers le log in
header("Location:login.php?OUT=true");
exit();
?>