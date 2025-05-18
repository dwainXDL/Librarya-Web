<?php

// SQL Connection Details
$server = "libraryadb-server.database.windows.net, 1433";
$database = "libraryaDB";
$username = "admin-librarya";
$password = "hbuvoc%qAqB@32";

$connectionOptions = [
    "Database" => $database,
    "UID"      => $username,
    "PWD"      => $password,
    "Encrypt"  => true,
    "TrustServerCertificate" => false
];

// SQL Connection
$connect = sqlsrv_connect($server, $connectOptions);

if(!$connect) {
    die("Connection to database failed: " . print_r(sqlsrv_errors(), true));
}

// Confirmation Msg
if ($connect) {
    echo "Connected to Database!";
}

?>