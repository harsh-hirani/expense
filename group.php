<?php
include './auth/auth.php';
if (!$islogedin) {
    header('Location: ./unauth.php');
} else {
    include './server/conn.php';
    $sql = "SELECT * FROM groups WHERE by_user='" . $_COOKIE['useride'] . "' and id='" . $_GET['id'] . "'";

    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        header('Location: ./not.php');
    }
    $group = mysqli_fetch_assoc($result);
    $gname = $group['gname'];

    // sql to get transections
    $sql = "
        SELECT 
            title, 
            tt, 
            gid,id,cate, 
            SUM(amount) AS amount 
        FROM 
            expenses 
        WHERE 
            gid = ? 
        GROUP BY 
            title, tt, gid
        ORDER BY 
            tt DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();


?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $_COOKIE['namee'] ?> | Dashboard</title>
        <?php include './base/css.php'; ?>
        <style>
            * {
                box-sizing: border-box;
                margin: 0px;
                padding: 0px;
            }
        </style>
    </head>

    <body>
        <?php include './comps/nav.php'; ?>


        <div class="container">
            <h2 class="display-2">
                <?php echo $gname; ?>
            </h2>
            
        </div>


        <div class="container">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <a type="button" href="addgroupex.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-primary">Add expense</a>
                <a type="button" href="managegroup.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-warning">Manage</a>
            </div>
        </div>
        <div class="container my-4">
            <div class="btn-group" role="group" aria-label="Basic outlined example rounded">
                <a type="button" href="group.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary">Expense</a>
                <a type="button" href="grouppeople.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-primary">People</a>
            </div>
        </div>

        <div class="container">
            <div class="row ">
                <?php

                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-lg-4 col-12 my-2  ">
                        <div class="side ">
                            <div class="row ">
                                <div class=" col-9">
    
                                    <div class=" col text-break text-capitalize">' . $row['title'] . '</div>
                                    <div class="col ">' . date("j/n/Y", (int)$row['tt']) . ' <span class="mx-1"> <a href="./server/deleteexg.php?id=' . $row['id'] . '">delete</a> </span>
                                    <span> <a href="./editexg.php?id='.$_GET['id'].'&tid=' . $row['id'] . '">edit</a> </span></div>
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
                }
                $stmt->close();
                ?>

            </div>
        </div>
        <?php include './base/js.php'; ?>

    </body>

    </html>


<?php
}
