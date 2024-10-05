<?php
include '../server/conn.php';
$email = $_POST['email'];

$sql = "SELECT * FROM users WHERE email='$email'";

$result = mysqli_query($conn, $sql);

$count = mysqli_num_rows($result);

if($count > 0){
    $data = mysqli_fetch_array($result);
    setcookie('usere', $data['email'], time() + (86400 * 30), "/");
    setcookie('namee', $data['name'], time() + (86400 * 30), "/");
    setcookie('useride', $data['id'], time() + (86400 * 30), "/");
}else{
    echo '
        <script>
            alert("Invalid email or password");
            window.location.href = "../auth/login.php";
        </script>
    ';
}

mysqli_close($conn);
?>
