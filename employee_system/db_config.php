<?php

$host     = "localhost";
$db_name  = "employee_db";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    http_response_code(500);
    header("Content-Type: application/json");
    die(json_encode(["error" => "Employee DB connection failed: " . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");
?>
