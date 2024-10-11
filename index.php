<?php
include './auth/auth.php';
if (!$islogedin) {
    $html = "<h1>login to see</h1>";
} else {
    include './server/conn.php';
    $sql = "SELECT * FROM expenses WHERE cid='" . $_COOKIE['useride'] . "' limit 20";

    $result = mysqli_query($conn, $sql);
    $cates = ["Food", "Travel", "Shopping", "Medical", "Fun","Other"];
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
    include './comps/nav.php';
   
    ?>

    <div class="container">
        <form method="post" action="./server/add.php">
            <div class="row">
                <div class="col-11">

                    <div class="form-group">
                        <label for="exampleInputEmail1">Title:</label>
                        <input type="text" name="title" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="Enter Title" required>
                    </div>
                </div>
                <div class="col-9">

                    <div class="form-group">
                        <label for="exampleInputPassword1">Ammount:</label>
                        <input type="number" min="0" name="amount" class="form-control" id="exampleInputPassword1"
                            placeholder="Amount" required>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-end ">

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col d-flex align-items-center my-2">
                    <?php foreach ($cates as $cate) {
                        echo '<div class="d-flex mx-1">
                        <input type="radio" class="d-none" name="cate" id="' . $cate . '" value="' . $cate . '">
                        <label class="cate" for="' . $cate . '">' . $cate . '</label>  
                    </div>';
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row "><?php
                            while ($row = $result->fetch_assoc()) {
        //                         $html .= "<div class='card my-2'>
        //     <div class='card-body'>
        //         <h5 class='card-title'>{}</h5>
        //         <p class='card-text'>{$row['amount']}</p>
        //     </div>
        // </div>";


                                echo
                                '<div class="col-lg-4 col-12 my-2  ">
                    <div class="side ">
                        <div class="row ">
                            <div class=" col-9">

                                <div class=" col text-break text-capitalize">' . $row['title'] . '</div>
                                <div class="col ">'.date("j/n/Y",(int)$row['tt']).' <span class="mx-1"> <a href="./server/delete.php?id=' . $row['id'] . '">delete</a> </span>
                                <span> <a href="./edit.php?id=' . $row['id'] . '">edit</a> </span></div>
                            </div>
                            <div class=" col-3">
                                ₹' . $row['amount'] . '
                            </div>
                        </div>
                        <div class="row tages my-2">
                            <div class="col">
                                <span>' . $row['cate'] . '</span>
                            </div>
                        </div>
                    </div>

                </div>';
                            } ?>
        </div>
    </div>

    <?php include './base/js.php'; ?>

</body>

</html>