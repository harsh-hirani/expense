<?php
include 'conn.php';
$amount = $_POST['amount'];
$title = $_POST['title'];
$cid = $_COOKIE['useride'];
if(isset($_POST['cate'])){
    $cate = $_POST['cate'];}else{
        $cate = "Other";
    }
$tz='Indian/Mahe';
date_default_timezone_set($tz);
$timeZone = date_default_timezone_get();
$tt= time();
$stmt = $conn->prepare("INSERT INTO expenses (title, amount, cid, tt, cate) VALUES (?, ?, ?, ? ,?)");

$stmt->bind_param("siiis", $title, $amount, $cid,$tt,$cate);

if($stmt->execute()){
    echo "New record created successfully";
    header('Location: ../index.php');
}else{
    echo "Error: ". $stmt->error;
    // header('Location: index.php');
}

$stmt->close();

?>