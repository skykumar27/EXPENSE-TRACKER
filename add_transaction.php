<?php
// add_transaction.php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$type = $data['type'] ?? '';
$title = trim($data['title'] ?? '');
$amount = floatval($data['amount'] ?? 0);
$category = trim($data['category'] ?? '');
$description = trim($data['description'] ?? '');
$date = $data['date'] ?? '';

if ($type === '' || $title === '' || $amount <= 0 || $category === '' || $date === '') {
    http_response_code(400);
    echo json_encode(["ok"=>false,"error"=>"Invalid input"]);
    exit;
}

$table = $type === 'income' ? 'income' : 'expenses';

try {
    $stmt = $conn->prepare("INSERT INTO $table (amount, category, description, date) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("dsss", $amount, $category, $description, $date);

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    echo json_encode(["ok"=>true,"id"=>$stmt->insert_id]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["ok"=>false,"error"=>$e->getMessage()]);
}
