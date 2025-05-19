<?php

// Connecting to SQL Server (Azure)
$server = "libraryadb-server.database.windows.net, 1433";
$database = "libraryaDB";
$username = "admin-librarya";
$password = "hbuvoc%qAqB@32";

$connectionOptions = [
    "Database" => $database,
    "UID" => $username,
    "PWD" => $password,
    "Encrypt" => true,
    "TrustServerCertificate" => false
];

$connect = sqlsrv_connect($server, $connectionOptions);

if(!$connect) {
    die("Connection to database failed: " . print_r(sqlsrv_errors(), true));
}