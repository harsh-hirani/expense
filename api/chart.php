<?php
header('Content-Type:application/json');
try {
    // print_r($_REQUEST);
    include '../server/conn.php';
    // $min = $_POST['min'];
    // $max = $_POST['max'];
    if (isset($_COOKIE['useride'])) {
        $id = $_COOKIE['useride'];
    } else {
        $id = $_POST['cid'];
    }
    if (isset($_POST['month'])) {
        $selectedMonth = intval($_POST['month']); // Get selected month and ensure it's an integer
    } else {
        $selectedMonth = date('n'); // Default to current month
    }
    if (isset($_POST['year'])) {
        $currentYear = intval($_POST['year']); // Get selected month and ensure it's an integer
    } else {
        $currentYear = date('Y'); // Default to current month
    }
    // $currentYear = 2025;
    // $selectedMonth = 2;
    $currentMonthStart = strtotime(date("$currentYear-$selectedMonth-01 00:00:00"));
    $currentMonthEnd = strtotime(date("$currentYear-$selectedMonth-t 23:59:59"));
    // $sql = "SELECT sum(amount) as total,cate,count(amount) as tms FROM `expenses` where cid = '" . $id . "' AND tt > " . $min . " and tt < " . $max . " group by cate";
    $sql = "
        SELECT 
            SUM(e.amount) AS total,
            e.title,
            e.id AS id,
            COUNT(e.amount) AS tms,
            e.tt,
            e.cate,
            IF(e.gid = -1, 'personal', 'group') AS expense_type,
            e.gid,
            gp.name AS contributor_name
        FROM 
            expenses e
        LEFT JOIN 
            group_people gp ON e.gpid = gp.id AND e.gid != -1
        WHERE 
            ((e.gid = -1 AND e.cid = ?) OR (gp.uid = ?))
            AND 
            (e.tt > ? AND e.tt < ? AND e.amount > 0)
        GROUP BY 
            e.cate
        ORDER BY 
            e.tt DESC
    ";

    // Prepare statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("SQL preparation error: " . $conn->error);
    }

    $stmt->bind_param("iiii", $id, $id, $currentMonthStart, $currentMonthEnd);

    // Execute query
    if (!$stmt->execute()) {
        throw new Exception("SQL execution error: " . $stmt->error);
    }

    // Fetch results
    $result = $stmt->get_result();
    if (!$result) {
        throw new Exception("Result retrieval error: " . $stmt->error);
    }

    $expenses = [];
    while ($row = $result->fetch_assoc()) {
        $expenses[] = $row;
    }

    // Output the JSON-encoded data
    echo json_encode(["status" => 200,"selectedMonth"=>$selectedMonth, "entries" => $expenses]);

    // Close connection
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);
}
?>