<?php

$conn = mysqli_connect('localhost', 'root', '', 'expense');
function getrow($id, $conn)
{
    return mysqli_query($conn, "SELECT * FROM expenses WHERE id = $id AND cid='" . $_COOKIE['useride'] . "'");
}
