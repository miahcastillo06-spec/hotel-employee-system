<?php
/**
 * ==========================================================
 *  HOTEL SYSTEM - Create Reservation
 *  This is the "Store / Create" step in the diagram:
 *  the reservation (including the employee name & id chosen
 *  from the dropdown populated via the Employee System API)
 *  gets saved into the hotel_db database.
 * ==========================================================
 */

header("Content-Type: application/json");
require_once "db_config.php";

$data = json_decode(file_get_contents("php://input"), true);

$customer_name = trim($data["customer_name"] ?? "");
$check_in      = $data["check_in"] ?? "";
$check_out     = $data["check_out"] ?? "";
$employee_name = trim($data["employee_name"] ?? "");
$employee_id   = intval($data["employee_id"] ?? 0);

if ($customer_name === "" || $check_in === "" || $check_out === "" || $employee_name === "" || $employee_id === 0) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO reservations (customer_name, check_in, check_out, employee_name, employee_id)
     VALUES (?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssssi", $customer_name, $check_in, $check_out, $employee_name, $employee_id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Reservation created and stored successfully.",
        "reservation_id" => $stmt->insert_id
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
