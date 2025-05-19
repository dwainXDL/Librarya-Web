<?php

session_start();
require_once __DIR__ . '/../assets/database.php';

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$pwd   = $_POST['password'];

$sql = "SELECT name, email, password FROM members WHERE email = ?";
$params = [ $email ];
$stmt = sqlsrv_query($connect, $sql, $params);

if ($stmt === false) {
    die("Query error: " . print_r(sqlsrv_errors(), true));
}

$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$row || !password_verify($pwd, $row['password'])) {
    header('Location: ../loginForm.html?error=' . urlencode("Incorrect credentials"));
    exit;
}

session_regenerate_id(true);
$_SESSION['user_email'] = $row['email'];
$_SESSION['memberName']   = $row['name'];

header('Location: ../pages/home.php');
exit;

