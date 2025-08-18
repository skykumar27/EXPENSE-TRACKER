<?php
// add_expense.php
header('Content-Type: application/json');
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

$amount = number_format((float)$amount, 2, '.', '');
$user_id = 1;

try {
  $stmt = $conn->prepare("INSERT INTO expenses (user_id, amount, category, description, date) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("idsss", $user_id, $amount, $category, $description, $date);
  $stmt->execute();
  echo json_encode(["ok"=>true, "id"=>$conn->insert_id]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["ok"=>false, "error"=>"DB error"]);
}
