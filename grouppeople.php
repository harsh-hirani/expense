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

    try {
        // Get the group ID (gid) from POST or $_COOKIE (if available)
        $gid = $_GET['id'];
        if (!$gid) {
            echo json_encode(["status" => 400, "message" => "Missing group ID (gid)"]);
            exit();
        }
    
        // SQL query to get total amount per person in a group (excluding personal expenses)
        $sql = "
            SELECT gp.name, SUM(e.amount) AS total_amount 
            FROM expenses e
            JOIN group_people gp ON e.gpid = gp.id
            WHERE e.gid = ? AND e.gpid != -1
            GROUP BY gp.id
        ";
    
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $gid);
    
        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Fetch results
        $total = 0;
        $expenses_per_person = array();
        while ($row = $result->fetch_assoc()) {
            $expenses_per_person[] = $row;
            $total += $row['total_amount'];
        }

    
    
        // Close the statement
        $stmt->close();
    
    } catch (Exception $e) {
        echo json_encode(["status" => 500, "error" => $e->getMessage()]);
    }

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
            <h3 class="display-6 text-muted bolder">
                adkbfdsfbgsdbfkj
            </h3>
        </div>


        <div class="container">
            <div class="btn-group" role="group" aria-label="Basic outlined example">
                <a type="button" href="addgroupex.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-primary">Add expense</a>
                <a type="button" href="managegroup.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-warning">Manage</a>
            </div>
        </div>
        <div class="container my-4">
            <div class="btn-group" role="group" aria-label="Basic outlined example rounded">
                <a type="button" href="group.php?id=<?php echo $_GET['id']; ?>" class="btn btn-outline-primary">Expense</a>
                <a type="button" href="grouppeople.php?id=<?php echo $_GET['id']; ?>" class="btn btn-primary">People</a>
            </div>
        </div>

        <div class="container">
            <h2 class="display-5">
                Total:<span id="total"><?php echo $total;?></span></h2>
                <div class="row my-2">
                    
                    <div class="col-12 col-md-8 col-lg-4">
                        <ul class="list-group">

                            <?php
                            foreach ($expenses_per_person as $person) {;
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center row">
                                    <lable class="col-4"><?php echo $person['name']; ?> : </lable>
                                    <input disabled type="number" class="form-control col"
                                     value="<?php echo $person['total_amount'];?>">
                                </li>
                            <?php
                            } ?>

                        </ul>

                    </div>
                    
                </div>
            </form>
        </div>
        <?php include './base/js.php'; ?>

    </body>

    </html>


<?php
}
