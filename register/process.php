<?php

require_once __DIR__ . '/../assets/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit;
}

$name    = trim($_POST['name']);
$nic     = trim($_POST['nic']);
$email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$phone   = '+94 ' . preg_replace('/\D+/', '', $_POST['phoneNo']);
$pwd     = $_POST['password'];

$hashed = password_hash($pwd, PASSWORD_BCRYPT);

$sql = "
  INSERT INTO members (name, nic, email, phoneNo, password)
  VALUES (?, ?, ?, ?, ?)
";
$parameters = [ $name, $nic, $email, $phone, $hashed ];

$cmd = sqlsrv_query($connect, $sql, $parameters);

if ($cmd) 
{
  header('Location: login.php?registered=1');
  exit;
} 
else 
{
  $error = print_r(sqlsrv_errors(), true);
  die("Registration failed (Check):<br><pre>$error</pre>");
}