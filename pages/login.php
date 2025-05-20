<?php

require_once __DIR__ . '/../assets/database.php';
session_start();

$error = isset($_GET['error']) ? 'Incorrect credentials' : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include __DIR__ . '/../login/process.php';
    exit;
}

include __DIR__ . '/../login/loginForm.php';