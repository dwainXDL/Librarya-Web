<?php
// Database connection (adjust your values)
$serverName = "libraryadb-server.database.windows.net,1433";
$connectionOptions = array(
    "Database" => "libraryaDB",
    "Uid" => "admin-librarya",
    "PWD" => "hbuvoc%qAqB@32"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}

// Query latest books
$sql = "SELECT TOP 10 title, cover FROM books ORDER BY dateAdded DESC";
$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $title = htmlspecialchars($row['title']);
    $cover = htmlspecialchars($row['cover']); // Assuming this is a valid URL or image path

    echo '
<div class="book-slide-wrapper">
  <img src="' . $cover . '" alt="' . $title . '">
  <h4 class="book-title">' . $title . '</h4>
</div>';

}

sqlsrv_close($conn);
?>
