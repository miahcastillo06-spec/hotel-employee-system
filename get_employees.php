<?php
/**
 * ==========================================================
 *  EMPLOYEE SYSTEM - API
 *  Fetches all employees and returns them as JSON.
 *  This is the endpoint the Hotel System calls to populate
 *  the "employee name" dropdown on its reservation form.
 * ==========================================================
 */

// Allow the Hotel System (a different origin/server) to call this API
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json");

require_once "db_config.php";

$sql    = "SELECT employee_id, employee_name, position FROM employees ORDER BY employee_name ASC";
$result = $conn->query($sql);

$employees = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
}

echo json_encode($employees);

$conn->close();
?>
