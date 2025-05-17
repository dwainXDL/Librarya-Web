<?php

// SQL Connection Details
$serverName = ".\SQLEXPRESS, 1433";
$connectOptions = [
    "Database" => "libraryaDB",
];

// SQL Connection
$connect = sqlsrv_connect($serverName, $connectOptions);
if(!$connect) {
    die(print_r(sqlsrv_errors(), true));
}

// Confirmation Msg
echo "Connected to Database!";
?>