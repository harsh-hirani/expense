<?php
header('Content-Type: application/json');

include '../server/conn.php';

try {
    // Collect required data
    $gid = $_GET['gid'];
    $name = $_POST['name'];
    $uid = isset($_COOKIE['useride']) ? $_COOKIE['useride'] : $_POST['uid'];

    if (!$gid || !$name || !$uid) {
        echo json_encode(["status" => 400, "message" => "Missing required data: gid, name, or uid"]);
        exit();
    }

    // Prepare and execute the insert statement
    $stmt = $conn->prepare("INSERT INTO group_people (gid, name) VALUES (?, ?)");
    $stmt->bind_param("is", $gid, $name);

    if ($stmt->execute()) {
        echo json_encode(["status" => 200, "message" => "Person added to group successfully"]);
        header('Location: ../managegroup.php?id=' . $gid);
    } else {
        echo json_encode(["status" => 500, "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();

} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);
}
?>
