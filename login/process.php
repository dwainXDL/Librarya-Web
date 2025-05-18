<?php

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$pwd   = $_POST['password'];

$sql = "SELECT password FROM members WHERE email = ?";
$parameters = [ $email ];
$cmd = sqlsrv_query($connect, $sql, $parameters);

if ($cmd === false) {
    die("Query error: " . print_r(sqlsrv_errors(), true));
}

if (!$row || !password_verify($pwd, $hashed)) {
    header('Location: login.php?error=1');
    exit;
}

session_regenerate_id(true);
$_SESSION['user_email'] = $email;
header('Location: dashboard.php');
exit;
