<?php

require_once __DIR__ . '/../assets/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../login/process.php';
    exit;
}

$error = isset($_GET['error']) ? 'Incorrect credentials' : '';

include __DIR__ . '/../login/loginForm.html';