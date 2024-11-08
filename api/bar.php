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
            FROM_UNIXTIME(e.tt, '%Y-%m-%d') as expense_day, 
            e.cate, 
            SUM(e.amount) as total, 
            COUNT(e.amount) as tms 
        FROM 
            expenses e
        LEFT JOIN 
            group_people gp ON e.gpid = gp.id AND e.gid != -1
        WHERE 
            ((e.gid = -1 AND e.cid = ?) OR (gp.uid = ?))
            AND 
            (e.tt > ? AND e.tt < ? AND e.amount > 0)
        GROUP BY expense_day, cate
        ORDER BY expense_day ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii",$id, $id, $currentMonthStart, $currentMonthEnd);

    $stmt->execute();
    $result = $stmt->get_result();

    $expenses = [];
    $days=[];
    // Initialize daily expenses with all categories set to 0
    while ($row = $result->fetch_assoc()) {
        $day = $row['expense_day'];
        $category = $row['cate'];
        // $tmp = ["total_expense" => 0, ];
        // Initialize the day if not already set
        if (!in_array($day, $days)) {
            $days[] = $day;
            // Set each category to 0 by default
            
                $expenses[] = ["total_expense" => 0, 
                "Food"=>0,
                "Fun"=>0,
                "Medical"=>0,
                "Other"=>0,
                "Shopping"=> 0,
                "Travel"=> 0,];
           
        }

        // Update total expense for the day and category
        $expenses[array_search($day,$days)]['total_expense'] += $row['total'];
        $expenses[array_search($day,$days)][$category] += $row['total'];
        
        
      
    }

    echo json_encode(["status" => 200, "entries" => $expenses,"days"=>$days]);

} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);
}
