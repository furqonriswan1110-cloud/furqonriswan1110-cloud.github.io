<?php
require 'db.php';

header('Content-Type: text/plain; charset=utf-8');

try {
    $res = $conn->query('SHOW TABLES');
    if (!$res) {
        http_response_code(500);
        echo "Query gagal: " . $conn->error;
        exit;
    }

    while ($row = $res->fetch_array(MYSQLI_NUM)) {
        echo $row[0] . PHP_EOL;
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo 'Error: ' . $e->getMessage();
}

