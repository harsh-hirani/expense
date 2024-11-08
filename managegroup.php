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
    $stmt = $conn->prepare("SELECT * FROM group_people WHERE gid = ? ");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $group_people = array();
    while ($row = $result->fetch_assoc()) {
        array_push($group_people, $row);
    }
    $stmt->close();
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
                <a class="nav-link " style="cursor: pointer;" href="group.php?id=<?php echo $_GET['id']; ?>">
                    < <?php echo $gname; ?></a>
            </h2>
            
        </div>


        <div class="container">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <a type="button" href="addgroupex.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-primary">Add expense</a>
                <a type="button" href="managegroup.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-warning">Manage</a>
            </div>
        </div>

        <div class="container">
            <form method="post" action="./server/addgrouppeople.php?gid=<?php echo $_GET['id']; ?>">
                <div class="row">

                    <div class="col-9 col-md-4">

                        <div class="form-group">
                            <label for="exampleInputPassword1">Person Name:</label>
                            <input type="text" name="name" class="form-control" id="exampleInputPassword1"
                                placeholder="Enter New Group..." required>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 d-flex align-items-end ">

                        <button type="submit" class="btn btn-primary px-4 py-1" style="font-size: 19px;">Add Person</button>
                    </div>

                </div>
            </form>
        </div>

        <div class="container">
            <h2 class="display-5">
                People in Group:</h2>
            <div class="row">
                <div class="col-12 col-md-8 col-lg-4">
                    <ul class="list-group">

                        <?php
                        foreach ($group_people as $person) {
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo $person['name'];?> 
                                
                            </li>
                        <?php
                        } ?>

                    </ul>
                </div>
            </div>
        </div>

        <?php include './base/js.php'; ?>

    </body>

    </html>


<?php
}
