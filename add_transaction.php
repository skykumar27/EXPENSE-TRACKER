<?php
header('Content-Type: application/json');
require 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$type = $data['type'] ?? '';
$title = $data['title'] ?? '';
$amount = floatval($data['amount'] ?? 0);
$category = $data['category'] ?? '';

if (!$type || !$title || !$amount || !$category) {
    http_response_code(400);
    echo json_encode(["ok"=>false,"error"=>"Invalid input"]);
    exit;
}

$table = $type === 'income' ? 'income' : 'expenses';
$stmt = $conn->prepare("INSERT INTO $table (description, amount, category, date) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sds", $title, $amount, $category);
if ($stmt->execute()) {
    echo json_encode(["ok"=>true,"id"=>$stmt->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(["ok"=>false,"error"=>"DB insert failed"]);
}
