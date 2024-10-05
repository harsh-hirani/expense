<?php
include './auth/auth.php';
if (!$islogedin) {
    $html = "<h1>login to see</h1>";
    
}else{
    $html ="";
    include './server/conn.php';
    $sql ="SELECT * FROM expenses WHERE cid='".$_COOKIE['useride']."'";
    
    $result = mysqli_query($conn, $sql);
   

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>

    <?php include './base/css.php'; ?>

</head>

<body>
    <?php
    if ($islogedin) {
        echo "<h3>welcome, " . $_COOKIE['namee'] . "</h3>";
    }
    ?>

    <div class="container">
        <form method="post" action="./server/add.php">
            <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" name="title" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Enter email" required>
            </div>
            <div class="row">
                <div class="col-9">

                    <div class="form-group">
                        <label for="exampleInputPassword1">Ammount</label>
                        <input type="number"  min="0" name="amount" class="form-control" id="exampleInputPassword1"
                            placeholder="Password" required>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-end ">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row "><?php
        while($row = $result->fetch_assoc()) {
        $html .= "<div class='card my-2'>
            <div class='card-body'>
                <h5 class='card-title'>{}</h5>
                <p class='card-text'>{$row['amount']}</p>
            </div>
        </div>";
        
    
    echo 
                '<div class="col-lg-4 col-12 my-2  ">
                    <div class="side ">
                        <div class="row ">
                            <div class=" col-9">

                                <div class=" col text-break text-capitalize">'.$row['title'].'</div>
                                <div class="col ">Date</div>
                            </div>
                            <div class=" col-3">
                                ₹'.$row['amount'].'
                            </div>
                        </div>
                        <div class="row tages my-2">
                            <div class="col">
                                <span>cate1</span>
                                <span>cate1</span>
                                <span>cate1</span>
                                <span>cate1</span>
                            </div>
                        </div>
                    </div>

                </div>';
            }?>
        </div>
    </div>
    <?php include './base/js.php'; ?>

</body>

</html>