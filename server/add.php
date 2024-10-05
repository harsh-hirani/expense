<?php
include 'conn.php';
$amount = $_POST['amount'];
$title = $_POST['title'];
$cid = $_COOKIE['useride'];
$stmt = $conn->prepare("INSERT INTO expenses (title, amount, cid) VALUES (?, ?, ?)");

$stmt->bind_param("sii", $title, $amount, $cid);

if($stmt->execute()){
    echo "New record created successfully";
    header('Location: ../index.php');
}else{
    echo "Error: ". $stmt->error;
    // header('Location: index.php');
}

$stmt->close();

?>