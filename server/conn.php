<?php

$conn = mysqli_connect('localhost', 'root', '', 'expense');
// $conn = mysqli_connect('sql210.infinityfree.com', 'if0_38039536', 'uoOIWLszyw', 'if0_38039536_expense');
function getrow($id, $conn)
{
    return mysqli_query($conn, "SELECT * FROM expenses WHERE id = $id AND cid='" . $_COOKIE['useride'] . "'");
}
function getgroup($id, $conn)
{
    return mysqli_query($conn, "SELECT * FROM groups WHERE id = $id AND by_user='" . $_COOKIE['useride'] . "'");
}
function isOwner($id, $conn)
{
    $sql = "
    SELECT 
        e.title,e.id as id,
        e.amount,
        e.tt,
        e.cate,
        IF(e.gid = -1, 'personal', 'group') AS expense_type,
        e.gid,
        gp.name AS contributor_name
    FROM 
        expenses e
    LEFT JOIN 
        group_people gp ON e.gpid = gp.id AND e.gid != -1
    WHERE 
        ((e.gid = -1 AND e.cid = ?) OR (gp.uid = ?)) AND (e.id = ?)
    ORDER BY 
        e.tt DESC";
        $cid = $_COOKIE['useride'];
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $cid, $cid,$id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        return false;
    }
    return $result->fetch_assoc();
}
