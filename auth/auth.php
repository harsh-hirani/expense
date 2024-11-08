<?php
$islogedin = False;
if (isset($_COOKIE['usere'])) {
    $islogedin = truE;
    
}else{

    header('Location: ./landing');
}
?>