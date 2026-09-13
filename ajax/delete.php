<?php

include "../db.php";

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    echo "Invalid ID";
    exit;
}


// Get image

$result = mysqli_query(
    $conn,
    "SELECT image FROM users WHERE id=$id"
);

$image = "";

if ($row = mysqli_fetch_assoc($result)) {
    $image = $row['image'];
}


// Delete database record

$sql = "DELETE FROM users WHERE id=$id";

if (mysqli_query($conn, $sql)) {

    // Delete image

    if (
        !empty($image) &&
        file_exists("../uploads/" . $image)
    ) {

        unlink("../uploads/" . $image);
    }

    echo "success";

} else {

    echo "Error: " . mysqli_error($conn);
}

?>