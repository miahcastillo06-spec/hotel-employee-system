<?php
/**
 * ==========================================================
 *  HOTEL SYSTEM - Database Configuration
 *  Represents: PC1 / Web Server 1  (see diagram)
 * ==========================================================
 */

$host     = "localhost";
$db_name  = "hotel_db";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    http_response_code(500);
    header("Content-Type: application/json");
    die(json_encode(["success" => false, "message" => "Hotel DB connection failed: " . $conn->connect_error]));
}

$conn->set_charset("utf8mb4");
?>
