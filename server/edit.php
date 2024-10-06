<?php
include './conn.php';
$id = $_GET['id'];
$res = getrow($id, $conn);
if (mysqli_num_rows($res) == 1) {
    $title = $_POST['title'];
    $amount = $_POST['amount'];
    $cate = $_POST['cate'];
    $stmt = $conn->prepare("UPDATE expenses SET title = ?, amount = ?, cate = ? WHERE id = ? and cid = ?");
    $stmt->bind_param("sssii", $title, $amount, $cate, $id, $_COOKIE['useride']);
    if ($stmt->execute()) {
        header('Location:../index.php');
    } else {
        echo "Error: ". $stmt->error;
    }
} else {
    header('Location: ../unauth.php');
}
