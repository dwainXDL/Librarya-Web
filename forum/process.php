<?php
session_start();
require_once __DIR__ . '/../assets/database.php';

if (empty($_SESSION['memberID'])) {
  header('Location: ../login/loginForm.html');
  exit;
}

$title      = trim($_POST['title']);
$body       = trim($_POST['body']);
$categoryID = intval($_POST['categoryID']);
$memberID   = $_SESSION['memberID'];

$sql    = "INSERT INTO questions (categoryID, memberID, title, body) VALUES (?, ?, ?, ?)";
$params = [$categoryID, $memberID, $title, $body];
sqlsrv_query($connect, $sql, $params);

header('Location: ../pages/forum.php');
exit;
