<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense</title>

    <?php include './base/css.php'; ?>

</head>

<body>
    <div class="container">
        <div class="row ">
<?php for($i=0;$i<100;$i++){?>
            <div class="col-lg-4 col-12 my-2  ">
                <div class="side ">
                    <div class="row ">
                        <div class=" col-9">
    
                            <div class=" col text-break text-capitalize">name</div>
                            <div class="col ">Date</div>
                        </div>
                        <div class=" col-3">
                            ₹5054.55
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
                
            </div>
<?php }?>
        </div>
    </div>
    <?php include './base/js.php'; ?>

</body>

</html>