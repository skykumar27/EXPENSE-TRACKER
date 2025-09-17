<?php
// add_expense.php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';

$title = trim($_POST['title'] ?? '');
$amount = $_POST['amount'] ?? '';
$category = trim($_POST['category'] ?? '');
$description = trim($_POST['description'] ?? '');
$date = $_POST['date'] ?? '';

if ($title === '' || !is_numeric($amount) || floatval($amount) <= 0 || $date === '' || $category === '') {
    http_response_code(400);
    echo json_encode(["ok"=>false, "error"=>"Invalid input"]);
    exit;
}

$amount = (float)$amount;

try {
    $stmt = $conn->prepare("INSERT INTO expenses (amount, category, description, date) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("dsss", $amount, $category, $description, $date);

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    echo json_encode(["ok"=>true, "id"=>$conn->insert_id]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["ok"=>false, "error"=>$e->getMessage()]);
}
