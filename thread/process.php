<?php
session_start();
require_once __DIR__ . '/../assets/database.php';

if (empty($_SESSION['memberID'])) {
  header('Location: ../login/loginForm.html');
  exit;
}

$questionID = intval($_POST['questionID']);
$body       = trim($_POST['body']);
$memberID   = $_SESSION['memberID'];

$sql = "INSERT INTO replies (questionID, memberID, body) VALUES (?, ?, ?)";
sqlsrv_query($connect, $sql, [$questionID, $memberID, $body]);

header("Location: ../pages/thread.php?id=$questionID");
exit;
