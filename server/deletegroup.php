<?php
include './conn.php';
$id = $_GET['id'];
$res = getgroup($id, $conn);
if (mysqli_num_rows($res) == 1) {
    
    $stmt = $conn->prepare("DELETE FROM groups WHERE id = ? and by_user = ?");
    $stmt->bind_param("ii", $id, $_COOKIE['useride']);
    if ($stmt->execute()) {
        header('Location:../groups.php');
    } else {
        echo "Error: ". $stmt->error;
    }
} else {
    header('Location: ../unauth.php');
}
