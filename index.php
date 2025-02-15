<?php
include './auth/auth.php';
if (!$islogedin) {
    $html = "<h1>login to see</h1>";
} else {
    try {

        include './server/conn.php';

        // $sql = "SELECT * FROM expenses WHERE cid='" . $_COOKIE['useride'] . "' limit 20";
        $cid = $_COOKIE['useride'];
        $selectedCategories = isset($_GET['category']) ? explode(',', $_GET['category']) : [];
        // $result = mysqli_query($conn, $sql);
        //     $sql = "
        // SELECT 
        //     e.title,e.id as id,
        //     e.amount,
        //     e.tt,
        //     e.cate,
        //     IF(e.gid = -1, 'personal', 'group') AS expense_type,
        //     e.gid,
        //     gp.name AS contributor_name
        // FROM 
        //     expenses e
        // LEFT JOIN 
        //     group_people gp ON e.gpid = gp.id AND e.gid != -1
        // WHERE 
        //     (e.gid = -1 AND e.cid = ?) OR (gp.uid = ?)  and e.amount>0
        // ORDER BY 
        //     e.tt DESC LIMIT 90";
        //     $stmt = $conn->prepare($sql);
        //     $stmt->bind_param("ii", $cid, $cid);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
        // Base SQL query
        $sql = "
SELECT 
    e.title, e.id as id,
    e.amount, e.tt, e.cate,
    IF(e.gid = -1, 'personal', 'group') AS expense_type,
    e.gid, gp.name AS contributor_name
FROM 
    expenses e
LEFT JOIN 
    group_people gp ON e.gpid = gp.id AND e.gid != -1
WHERE 
    ((e.gid = -1 AND e.cid = ?) OR (gp.uid = ?))  
    AND e.amount > 0";

        // Append category filter only if categories are selected
        if (!empty($selectedCategories)) {
            $placeholders = implode(',', array_fill(0, count($selectedCategories), '?')); // Creates (?, ?, ?)
            $sql .= " AND e.cate IN ($placeholders)";
        }

        // Order and limit
        $sql .= " ORDER BY e.tt DESC LIMIT 90";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // Bind parameters dynamically
        $params = [$cid, $cid]; // User ID from cookies
        if (!empty($selectedCategories)) {
            $params = array_merge($params, $selectedCategories);
        }

        // Execute the query
        $stmt->execute($params);
        $result = $stmt->get_result();
        $cates = ["Food", "Travel", "Shopping", "Medical", "Fun", "Stationary", "Other", "borrow"];
    } catch (Exception $e) {
        $html = "<h1>error</h1>";
    }
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
                <div class="col d-flex align-items-center my-2 flex-wrap">
                    <?php foreach ($cates as $cate) {
                        echo '<div class="d-flex mx-1 mb-1">
                        <input type="radio" class="d-none" name="cate" id="' . $cate . '" value="' . $cate . '">
                        <label class="cate" for="' . $cate . '">' . $cate . '</label>  
                    </div>';
                    }
                    ?>


                    <a class="btn btn-outline-dark px-4 mb-2" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        🛠️ Filter
                    </a>



                </div>
                <div class="collapse my-2 col" id="collapseExample">
                    <div class="card card-body d-flex flex-wrap">

                        <?php
                        foreach ($cates as $index => $category) { ?>
                            <div class="form-check ">
                                <input class="form-check-input" type="checkbox" name="category[]" value="<?= htmlspecialchars($category); ?>" id="flexCheck<?= $index; ?>">
                                <label class="form-check-label" for="flexCheck<?= $index; ?>">
                                    <?= htmlspecialchars($category); ?>
                                </label>
                            </div>
                        <?php } ?>

                        <div class="btn btn-primary" onclick="changeLocation()">Go</div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="row "><?php
                            while ($row = $result->fetch_assoc()) {
                                if ($row['expense_type'] == 'personal') {
                                }
                                echo '<div class="col-lg-4 col-12 my-2  ">
                    <div class="side ">
                        <div class="row ">
                            <div class=" col-9">

                                <div class=" col text-break text-capitalize">' . $row['title'] . '</div>
                                <div class="col ">' . date("j/n/Y", (int)$row['tt']) . ' <span class="mx-1 text-danger  del-button"> <a class="text-danger" href="./server/delete.php?id=' . $row['id'] . '">delete</a> </span>
                                <span> <a class="text-success" href="./edit.php?id=' . $row['id'] . '">edit</a> </span></div>
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