<?php

include "../db.php";

$id = (int)($_POST['id'] ?? 0);

$sql = "SELECT * FROM users WHERE id = $id";

$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {

    $row['hobbies'] = !empty($row['hobbies'])
        ? explode(",", $row['hobbies'])
        : [];

    echo json_encode($row);

} else {

    echo json_encode([
        "error" => "User not found"
    ]);
}
?>