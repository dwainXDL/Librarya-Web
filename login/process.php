<?php
// process.php
session_start();  // ensure session available
require_once __DIR__ . '/../assets/database.php';

$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$pwd   = $_POST['password'] ?? '';

// Lookup user
$sql   = "SELECT memberID, name, email, password FROM members WHERE email = ?";
$stmt  = sqlsrv_query($connect, $sql, [ $email ]);
$row   = $stmt ? sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) : null;

// On bad creds -> redirect back with error=1
if (! $row || ! password_verify($pwd, $row['password'])) {
    header('Location: ../pages/login.php?error=1');
    exit;
}

// On success -> set session + go home
session_regenerate_id(true);
$_SESSION['user_email']  = $row['email'];
$_SESSION['memberName']  = $row['name'];
$_SESSION['memberID'] = $row['memberID'];
header('Location: ../pages/home.php');
exit;

