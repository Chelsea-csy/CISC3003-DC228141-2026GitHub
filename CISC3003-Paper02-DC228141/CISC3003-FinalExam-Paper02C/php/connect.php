<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'cisc3003_paper02_c';
$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_errno) {
    die('Database connection failed: ' . htmlspecialchars($mysqli->connect_error));
}
$mysqli->set_charset('utf8mb4');
?>
