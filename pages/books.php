<?php

session_start();
$user = $_SESSION['memberName'] ?? null;

include __DIR__ . '/../books/bookForm.html';
?>

