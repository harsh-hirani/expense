<?php
$id = $_GET['id'];
include './server/conn.php';
$res = getrow($id, $conn);
if (mysqli_num_rows($res) == 1) {
    $res = mysqli_fetch_assoc($res);
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit </title>
        <?php include './base/css.php';$cates = ["Food", "Travel", "Shopping", "Medical", "Fun", "Stationary", "Other","borrow"];?>
        
    </head>

    <body>
        <div class="container">
            <form method="post" action="./server/edit.php?id=<?php echo $id;?>">
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

                        <button type="submit" class="btn btn-primary">Edit</button>
                        <button type="reset" onclick="window.location.href = './'" class="btn btn-danger mx-2">Cancel</button>
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

        <script>

            document.querySelector('input[name="cate"][value="<?php echo $res['cate'];?>"]').checked = true;

            document.querySelector('input[name="title"]').value = "<?php echo $res['title'];?>";
            document.querySelector('input[name="amount"]').value = "<?php echo $res['amount'];?>";

        </script>
    </body>

    </html>
<?php
} else {
    header('Location: ./unauth.php');
}
?>