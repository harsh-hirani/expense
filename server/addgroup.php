<?php
include 'conn.php';

$gname = $_POST['gname'];
$cid = $_COOKIE['useride'];

$tz = 'Indian/Mahe';
date_default_timezone_set($tz);
$tt = time();

$stmt = $conn->prepare("INSERT INTO `groups` (gname, date_created, by_user) VALUES (?, ?, ?)");
$stmt->bind_param("sii", $gname, $tt, $cid);

if ($stmt->execute()) {
    $insert_id = $conn->insert_id;  // Store the insert_id immediately after execution
    if ($insert_id) {  // Check if insert_id is successfully set
        $stmt2 = $conn->prepare("INSERT INTO `group_people` (gid, name, uid) VALUES (?, ?, ?)");
        $namee = $_COOKIE['namee'];
        $stmt2->bind_param("isi", $insert_id, $namee, $cid);

        if ($stmt2->execute()) {
            echo "New record created successfully";
            header('Location: ../groups.php');
            exit();  // Always call exit after header redirection
        } else {
            echo "Error in second statement: " . $stmt2->error;
        }
        $stmt2->close();
    } else {
        echo "Failed to retrieve the last insert ID.";
    }
} else {
    echo "Error in first statement: " . $stmt->error;
}

$stmt->close();
?>
