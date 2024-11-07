<?php
header('Content-Type: application/json');

include '../server/conn.php';

try {
    // Get the group ID from GET parameters
    $gid = $_GET['gid'];
    if (!$gid) {
        echo json_encode(["status" => 400, "message" => "Group ID is required"]);
        exit();
    }

    // Get the transaction data from POST
    $transactions = $_POST;
    if (empty($transactions)) {
        echo json_encode(["status" => 400, "message" => "Transaction data is required"]);
        exit();
    }

    // Prepare statement for inserting each transaction
    $stmt = $conn->prepare("INSERT INTO expenses (cid,title, amount, tt, cate, gid, gpid) VALUES (?, ?, ?, ?, ?, ?,?)");
    $tz = 'Indian/Mahe';
    date_default_timezone_set($tz);
    $currentTimestamp = time();
    $title = $_POST['title'];
    $category = $_POST['cate']; // Example category, change as needed

    foreach ($transactions as $personId => $amount) {
        // Check that the person ID and amount are valid
        if (!is_numeric($personId) || !is_numeric($amount)) {
            if($personId == 'title' || $personId == 'cate') continue;
            echo json_encode(["status" => 400, "message" => "Invalid data format for person ID or amount"]);
            exit();
        }

        // Insert the transaction
        $stmt->bind_param("isdisis", $personId,$title, $amount, $currentTimestamp, $category, $gid, $personId);
        if (!$stmt->execute()) {
            echo json_encode(["status" => 500, "message" => "Error: " . $stmt->error]);
            exit();
        }
    }

    echo json_encode(["status" => 200, "message" => "Group transactions added successfully"]);
    header('Location: ../group.php?id=' . $gid);
    $stmt->close();
} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);
}
