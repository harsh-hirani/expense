<?php
header('Content-Type: application/json');

include './conn.php';

$data = isOwner($_GET['tid'], $conn);
if (!$data) {
    header('Location: ./not.php');
}
try{
    $title = $_POST['title'];
    $category = $_POST['cate']; // Example category, change as needed
$update_sql = "UPDATE expenses SET amount = ?,  cate = ? , title = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

foreach ($_POST as $personId => $amount) {
    // Check that the person ID and amount are valid
    if (!is_numeric($personId) || !is_numeric($amount)) {
        if($personId == 'title' || $personId == 'cate') continue;
        echo json_encode(["status" => 400, "message" => "Invalid data format for person ID or amount"]);
        exit();
    }

    // Insert the transaction
    $update_stmt->bind_param("issi",  $amount, $category, $title, $personId);
    if (!$update_stmt->execute()) {
        echo json_encode(["status" => 500, "message" => "Error: " . $update_stmt->error]);
        exit();
    }
}

echo json_encode(["status" => 200, "message" => "Transactions updated successfully"]);
$update_stmt->close();
header('Location: ../group.php?id=' . $_GET['id']);
} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);

}
// try {
// Get data from POST request
//     $expense_id = isset($_POST['expense_id']) ? $_POST['expense_id'] : null;
//     $title = isset($_POST['title']) ? $_POST['title'] : null;
//     $amount = isset($_POST['amount']) ? $_POST['amount'] : null;
//     $tt = isset($_POST['tt']) ? $_POST['tt'] : null;
//     $cate = isset($_POST['cate']) ? $_POST['cate'] : null;
//     $gpid = isset($_POST['gpid']) ? $_POST['gpid'] : null; // group person ID
//     $gid = isset($_POST['gid']) ? $_POST['gid'] : null; // group ID

//     // Validate input data
//     if (!$expense_id || !$title || !$amount || !$tt || !$cate || !$gpid || !$gid) {
//         echo json_encode(["status" => 400, "message" => "Missing required fields"]);
//         exit();
//     }

//     // Check if the expense ID exists and is part of the correct group
//     $check_sql = "SELECT * FROM expenses WHERE id = ? AND gpid != -1";
//     $check_stmt = $conn->prepare($check_sql);
//     $check_stmt->bind_param("i", $expense_id);
//     $check_stmt->execute();
//     $check_result = $check_stmt->get_result();

//     if ($check_result->num_rows === 0) {
//         echo json_encode(["status" => 400, "message" => "Transaction not found or not a group transaction"]);
//         exit();
//     }

//     // Update all entries for the same title, tt, and gid
//     $update_sql = "
//         UPDATE expenses 
//         SET amount = ?, tt = ?, cate = ?, gpid = ?, gid = ? 
//         WHERE title = ? AND tt = ? AND gid = ?";
//     $update_stmt = $conn->prepare($update_sql);
//     $update_stmt->bind_param("dsssssi", $amount, $tt, $cate, $gpid, $gid, $title, $tt, $gid);

//     if ($update_stmt->execute()) {
//         echo json_encode(["status" => 200, "message" => "Group transaction updated successfully"]);
//     } else {
//         echo json_encode(["status" => 500, "message" => "Error updating group transaction"]);
//     }

//     $update_stmt->close();
//     $check_stmt->close();

// } catch (Exception $e) {
//     echo json_encode(["status" => 500, "error" => $e->getMessage()]);
// }
