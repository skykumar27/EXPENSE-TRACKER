<?php
// db.php - update credentials if needed
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "expense_tracker";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
  $conn = new mysqli($host, $user, $pass, $dbname);
  $conn->set_charset("utf8mb4");
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["ok"=>false, "error"=>"DB connection failed"]);
  exit;
}
?>
