<?php
header('Content-Type: application/json');

try {
    include '../server/conn.php';

    // List of all possible categories
    $cates = ["Food", "Travel", "Shopping", "Medical", "Fun", "Other"];

    // Get current month start and end Unix timestamps
    $currentMonthStart = strtotime(date('Y-m-01 00:00:00'));
    $currentMonthEnd = strtotime(date('Y-m-t 23:59:59'));

    // Set up user ID based on cookie or POST data
    $id = isset($_COOKIE['useride']) ? $_COOKIE['useride'] : $_POST['cid'];

    // SQL query to group expenses by day and category within the current month
    $sql = "
        SELECT 
            FROM_UNIXTIME(tt, '%Y-%m-%d') as expense_day, 
            cate, 
            SUM(amount) as total, 
            COUNT(amount) as tms 
        FROM `expenses` 
        WHERE 
            cid = ? 
            AND tt >= ? 
            AND tt <= ? 
        GROUP BY expense_day, cate
        ORDER BY expense_day ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id, $currentMonthStart, $currentMonthEnd);

    $stmt->execute();
    $result = $stmt->get_result();

    $expenses = [];

    // Initialize daily expenses with all categories set to 0
    while ($row = $result->fetch_assoc()) {
        $day = $row['expense_day'];
        $category = $row['cate'];

        // Initialize the day if not already set
        if (!isset($expenses[$day])) {
            $expenses[$day] = ["total_expense" => 0, "categories" => []];

            // Set each category to 0 by default
            foreach ($cates as $cat) {
                $expenses[$day][$cat] = 0;
            }
        }

        // Update total expense for the day and category
        $expenses[$day]['total_expense'] += $row['total'];
        $expenses[$day][$category] = $row['total'];
    }

    echo json_encode(["status" => 200, "entries" => $expenses]);

} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);
}
