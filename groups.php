<?php
include './auth/auth.php';
if (!$islogedin) {
    header('Location: ./unauth.php');
} else {
    include './server/conn.php';
    $sql = "SELECT * FROM groups WHERE by_user='" . $_COOKIE['useride'] . "' limit 20";

    $result = mysqli_query($conn, $sql);
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
                Groups
            </h2>
            <h3 class="display-6 text-muted bolder">
                adkbfdsfbgsdbfkj
            </h3>
        </div>

        <div class="container">
            <form method="post" action="./server/addgroup.php">
                <div class="row">

                    <div class="col-9 col-md-4">

                        <div class="form-group">
                            <label for="exampleInputPassword1">Group Name:</label>
                            <input type="text" name="gname" class="form-control" id="exampleInputPassword1"
                                placeholder="Enter New Group..." required>
                        </div>
                    </div>
                    <div class="col-3 d-flex align-items-end ">

                        <button type="submit" class="btn btn-primary px-4 py-1" style="font-size: 19px;">Add</button>
                    </div>

                </div>
            </form>
        </div>
        <div class="container">
            <div class="row "><?php
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="col-lg-4 col-12 my-2  ">
                    <div class="side ">
                        <div class="row ">
                            <div class=" col-9">

                                <div class=" col text-break text-capitalize">' . $row['gname'] . '</div>
                                <div class="col ">' . date("j/n/Y", (int)$row['date_created']) . ' <span class="mx-1"> <a href="./group.php?id=' . $row['id'] . '">Open</a> </span>
                                <!--<span> <a href="./server/deletegroup.php?id=' . $row['id'] . '">Delete </a> </span>--></div>
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


<?php
}
