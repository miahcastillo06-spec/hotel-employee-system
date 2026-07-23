<?php
/**
 * ==========================================================
 *  EMPLOYEE SYSTEM - Database Configuration
 *  Represents: PC2 / Webserver 2  (see diagram)
 * ==========================================================
 * NOTE: For this activity, both systems run on the same
 * MySQL server (different databases) to simplify local
 * testing. In a real 2-PC setup, you would simply change
 * $host to the IP address of PC2's MySQL server.
 */

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
