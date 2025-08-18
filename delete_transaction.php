<?php
header('Content-Type: application/json');
require 'db.php';

// Get POST parameters
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$type = isset($_POST['type']) ? $_POST['type'] : '';

if (!$id || !in_array($type, ['income', 'expense'])) {
    http_response_code(400);
    echo json_encode(["ok" => false, "error" => "Invalid input"]);
    exit;
}

// Determine table
$table = $type === 'income' ? 'income' : 'expenses';

// Prepare and execute deletion
$stmt = $conn->prepare("DELETE FROM `$table` WHERE id = ?");
if (!$stmt) {
    http_response_code(500);
    echo json_encode(["ok" => false, "error" => "Prepare failed: " . $conn->error]);
    exit;
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["ok" => true]);
} else {
    http_response_code(500);
    echo json_encode(["ok" => false, "error" => "DB delete failed: " . $stmt->error]);
}

$stmt->close();
$conn->close();
