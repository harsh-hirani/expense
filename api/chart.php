<?php
header('Content-Type:application/json');
try {
    // print_r($_REQUEST);
    include '../server/conn.php';
    $min = $_POST['min'];
    $max = $_POST['max'];
    if (isset($_COOKIE['useride'])) {
        $id = $_COOKIE['useride'];
    } else {
        $id = $_POST['cid'];
    }
    $sql = "SELECT sum(amount) as total,cate,count(amount) as tms FROM `expenses` where cid = '" . $id . "' AND tt > " . $min . " and tt < " . $max . " group by cate";

    $result = mysqli_query($conn, $sql);

    $expenses = array();


    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[] = $row;
    }


    echo json_encode(["status" => 200, "sql" => $sql, "entries" => $expenses,"s"=>$_REQUEST]);
} catch (Exception $e) {
    echo json_encode(["status" => 500, "error" => $e->getMessage()]);
}
