<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../assets/database.php';

header('Content-Type: application/json');

if (!$connect) {
    echo json_encode(['error' => 'DB connection failed', 'details' => sqlsrv_errors()]);
    exit;
}

$sql = "SELECT cover, isbn, title, author, category, language, publishedYear, description, availability FROM books ORDER BY title";
$cmd = sqlsrv_query($connect, $sql);

if (!$cmd) {
    echo json_encode(['error' => 'Query failed', 'details' => sqlsrv_errors()]);
    exit;
}

$books = [];
while ($row = sqlsrv_fetch_array($cmd, SQLSRV_FETCH_ASSOC)) {
    $books[] = [
        'cover'        => $row['cover'] ?? 'placeholder.png',
        'isbn'         => $row['isbn'],
        'title'        => $row['title'],
        'author'       => $row['author'],
        'category'     => $row['category'],
        'language'     => $row['language'],
        'year'         => $row['publishedYear'],
        'description'  => $row['description'],
        'availability' => $row['availability']
    ];
}

function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
        return $mixed;
    }
    if (is_string($mixed)) {
        return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
    }
    return $mixed;
}

$json = json_encode(utf8ize($books));
if ($json === false) {
    echo '<pre>JSON error: ' . json_last_error_msg() . '</pre>';
} else {
    echo $json;
}

