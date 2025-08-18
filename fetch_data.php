<?php
// fetch_data.php
header('Content-Type: application/json');
require 'db.php';

// Get filter from query param
$filter = $_GET['filter'] ?? 'all';
$whereIncome = "1=1";
$whereExpense = "1=1";

// Apply filter
if ($filter === 'daily') {
    $whereIncome = "DATE(date) = CURDATE()";
    $whereExpense = "DATE(date) = CURDATE()";
} elseif ($filter === 'weekly') {
    $whereIncome = "YEARWEEK(date,1) = YEARWEEK(CURDATE(),1)";
    $whereExpense = "YEARWEEK(date,1) = YEARWEEK(CURDATE(),1)";
} elseif ($filter === 'monthly') {
    $whereIncome = "YEAR(date)=YEAR(CURDATE()) AND MONTH(date)=MONTH(CURDATE())";
    $whereExpense = "YEAR(date)=YEAR(CURDATE()) AND MONTH(date)=MONTH(CURDATE())";
} elseif ($filter === 'income') {
    $whereIncome = "1=1";
    $whereExpense = "1=0"; // no expenses
} elseif ($filter === 'expense') {
    $whereIncome = "1=0"; // no income
    $whereExpense = "1=1";
}

$transactions = [];
try {
    // UNION query with parentheses to allow ORDER BY
    $sql = "
        SELECT * FROM (
            SELECT id, 'income' as type, amount, category, description, date
            FROM income WHERE $whereIncome
            UNION ALL
            SELECT id, 'expense' as type, amount, category, description, date
            FROM expenses WHERE $whereExpense
        ) t
        ORDER BY t.date DESC
    ";
    $res = $conn->query($sql);
    while ($r = $res->fetch_assoc()) {
        $transactions[] = $r;
    }

    // Totals
    $totRes = $conn->query("
        SELECT
            (SELECT COALESCE(SUM(amount),0) FROM income WHERE $whereIncome) AS totalIncome,
            (SELECT COALESCE(SUM(amount),0) FROM expenses WHERE $whereExpense) AS totalExpense
    ")->fetch_assoc();

    $totalIncome = floatval($totRes['totalIncome'] ?? 0);
    $totalExpense = floatval($totRes['totalExpense'] ?? 0);
    $balance = $totalIncome - $totalExpense;

    // Expense categories (all time)
    $catRows = [];
    $q1 = $conn->query("SELECT category, SUM(amount) AS total FROM expenses GROUP BY category");
    while ($r = $q1->fetch_assoc()) $catRows[] = $r;

    // Trend last 6 months
    $months = [];
    for ($i=5;$i>=0;$i--) $months[] = date('Y-m-01', strtotime("-$i month"));

    $trendLabels = [];
    $trendIncome = [];
    $trendExpense = [];

    foreach ($months as $m) {
        $label = date('M Y', strtotime($m));
        $trendLabels[] = $label;
        $start = $m;
        $end = date('Y-m-t', strtotime($m));

        $incRow = $conn->query("SELECT COALESCE(SUM(amount),0) AS s FROM income WHERE date BETWEEN '$start' AND '$end'")->fetch_assoc();
        $expRow = $conn->query("SELECT COALESCE(SUM(amount),0) AS s FROM expenses WHERE date BETWEEN '$start' AND '$end'")->fetch_assoc();

        $trendIncome[] = floatval($incRow['s']);
        $trendExpense[] = floatval($expRow['s']);
    }

    echo json_encode([
        "ok" => true,
        "transactions" => $transactions,
        "totalIncome" => $totalIncome,
        "totalExpense" => $totalExpense,
        "balance" => $balance,
        "categories" => array_map(fn($r)=>$r['category'], $catRows),
        "categoryTotals" => array_map(fn($r)=>floatval($r['total']), $catRows),
        "trendLabels" => $trendLabels,
        "trendIncome" => $trendIncome,
        "trendExpense" => $trendExpense
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["ok"=>false, "error"=>"DB error: ".$e->getMessage()]);
}
