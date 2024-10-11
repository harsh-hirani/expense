<?php 

setcookie('namee', '', time() - 3600, '/');

setcookie('usere', '', time() - 3600, '/');

setcookie('useride', '', time() - 3600, '/');

header("Location: ../");
?>