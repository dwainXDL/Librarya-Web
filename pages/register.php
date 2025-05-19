<?php

include __DIR__ . '/../assets/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include __DIR__ . '/../register/process.php';
  exit;
}

include __DIR__ . '/../register/registerForm.html';