<?php

$servername = 'MinProject';
$username = 'root';
$password = '';
$dbname = 'pc_builder';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8mb4');

    // Existing project pages use $db, so both names refer to this connection.
    $db = $conn;
} catch (Throwable $exception) {
    http_response_code(503);
    $db_error = 'The PC Builder database is not available. Check that MySQL is running and that the connection settings in db_connect.php match your setup.';
}
?>
