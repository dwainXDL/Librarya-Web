<?php
// new-arrivals-multiple.php

// DB connection
$server = "libraryadb-server.database.windows.net,1433";
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

$conn = sqlsrv_connect($server, $connectionOptions);
if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}

// Get the latest 10 books ordered by date
$sql = "SELECT TOP 10 title, cover FROM books ORDER BY dateAdded DESC";
$stmt = sqlsrv_query($conn, $sql);

$books = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $books[] = $row;
}

$totalBooks = count($books);

for ($i = 0; $i < $totalBooks; $i += 3) {
    $active = ($i === 0) ? 'active' : '';
    echo "<div class='carousel-item $active'>";
    for ($j = $i; $j < $i + 3 && $j < $totalBooks; $j++) {
        $title = htmlspecialchars($books[$j]['title']);
        $cover = htmlspecialchars($books[$j]['cover']);
        echo "<div class='book-slide" . ($j === $i + 1 ? " active" : "") . "'>";
        echo "<img src='uploads/$cover' alt='$title'>";
        echo "<p class='book-title'>$title</p>";
        echo "</div>";
    }
    echo "</div>";
}

sqlsrv_close($conn);
?>
