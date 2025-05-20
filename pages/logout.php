<?php
session_start();
session_unset();
session_destroy();
// redirect back to home (or login) after logout
header('Location: ../pages/home.php');
exit;
?>