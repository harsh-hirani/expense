<?php
include './conn.php';
$id = $_GET['id'];
$res = getrow($id, $conn);
if (mysqli_num_rows($res) == 1) {
    
    $stmt = $conn->prepare("DELETE FROM expenses WHERE id = ? and cid = ?");
    $stmt->bind_param("ii", $id, $_COOKIE['useride']);
    if ($stmt->execute()) {
        header('Location:../index.php');
    } else {
        echo "Error: ". $stmt->error;
    }
} else {
    header('Location: ../unauth.php');
}
