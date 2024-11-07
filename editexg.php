<?php
include './auth/auth.php';
if (!$islogedin) {
    header('Location: ./unauth.php');
} else {
    include './server/conn.php';
    $sql = "SELECT * FROM groups WHERE by_user='" . $_COOKIE['useride'] . "' and id='" . $_GET['id'] . "'";
    $data = isOwner($_GET['tid'], $conn);
    if (!$data) {
        header('Location: ./not.php');
    }

    $select_sql = "SELECT * FROM expenses WHERE gid = ? and tt = ? and title = ? and cate = ? ";
    $select_stmt = $conn->prepare($select_sql);
    $select_stmt->bind_param("iiss", $_GET['id'], $data['tt'], $data['title'], $data['cate']);
    $res = $select_stmt->execute();
    $res = $select_stmt->get_result();
    
    $select_stmt->close();

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
    $cates = ["Food", "Travel", "Shopping", "Medical", "Fun", "Other"];
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
            <h3 class="display-6 text-muted bolder">
                adkbfdsfbgsdbfkj
            </h3>
        </div>




        <div class="container">
            <h2 class="display-5">
                Total:<span id="total">0</span></h2>
            <form method="post" action="./server/editexg.php?id=<?php echo $_GET['id']; ?>&tid=<?php echo $_GET['tid']; ?>" onsubmit="return validate();">
                <div class="row my-2">
                    <div class="col-12 col-md-8 col-lg-4">
                        <label for="amount">Title:</label>
                        <input type="text" name="title" class="form-control" placeholder="Title" required
                            value="<?php echo $data['title']; ?>">
                    </div>
                    <div class="col-12 my-2"></div>
                    <div class="col-12 col-md-8 col-lg-4">
                        <ul class="list-group">

                            <?php
                            foreach ($group_people as $person) {
                                $row = $res->fetch_assoc();
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center row">
                                    <lable class="col-4"><?php echo $person['name']; ?> : </lable>
                                    <input type="number" name="<?php echo $row['id']; ?>" class="form-control col" placeholder="Amount"
                                        oninput="change();" min="0" value="<?php echo $row['amount'];?>">
                                </li>
                            <?php
                            } ?>

                        </ul>

                    </div>
                    <div class="col-12 d-flex align-items-center my-2">
                        <?php foreach ($cates as $cate) {
                            echo '<div class="d-flex mx-1">
                        <input type="radio" class="d-none" name="cate" id="' . $cate . '" value="' . $cate . '">
                        <label class="cate" for="' . $cate . '">' . $cate . '</label>  
                    </div>';
                        }
                        ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary px-4 py-1" style="font-size: 19px;">Update</button>
            </form>
        </div>

        <?php include './base/js.php'; ?>
        <script>
            var total = 0;
            document.querySelector('input[name="cate"][value="<?php echo $data['cate']; ?>"]').checked = true;

            function change() {
                total = 0;
                var inputs = document.getElementsByTagName('input');
                for (var i = 0; i < inputs.length; i++) {
                    if (inputs[i].type == 'number') {
                        total += parseInt(inputs[i].value);
                    }
                }
                document.getElementById('total').innerText = total;
            }

            function validate() {
                if (total == 0) {
                    alert('Please enter some amount');
                    return false;
                }
                return true;
            }
            change();
        </script>
    </body>

    </html>


<?php
}
