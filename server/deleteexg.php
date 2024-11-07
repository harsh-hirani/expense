<?php
header('Content-Type: application/json');

include '../server/conn.php';

try {
    // Get the transaction ID from POST request
    $expense_id = isset($_GET['id']) ? $_GET['id'] : null;
    // echo $_GET['id'];
    if (!$expense_id) {
        echo json_encode(["status" => 400, "message" => "Expense ID is required"]);
        exit();
    }

    // SQL query to check if the expense exists
    $check_sql = "SELECT * FROM expenses WHERE id = ? AND gpid != -1";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $expense_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();

    if ($check_result->num_rows === 0) {
            header('Location: ../group.php?id=' . $row['gid']);
            echo json_encode(["status" => 400, "message" => "Transaction not found or not a group transaction"]);
        exit();
    }

    // Proceed with deleting the group transaction
    $delete_sql = "DELETE FROM expenses WHERE gid = ? and tt = ? and title = ? and cate = ? ";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("iiss", $row['gid'], $row['tt'], $row['title'], $row['cate']);
    if(isOwner($expense_id,$conn)){

        if ($delete_stmt->execute()) {
            echo json_encode(["status" => 200, "message" => "Group transaction deleted successfully"]);
            header('Location: ../group.php?id=' . $row['gid']);
        } else {
            echo json_encode(["status" => 500, "message" => "Error deleting group transaction"]);
        }
    }else{
        echo json_encode(["status" => 400, "message" => "You are not allowed to delete this transaction"]);
    }

    $delete_stmt->close();
    $check_stmt->close();

} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);
}
?>
