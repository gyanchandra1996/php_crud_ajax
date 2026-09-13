<?php

include "../db.php";

$id = (int)($_POST['id'] ?? 0);

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$gender = $_POST['gender'] ?? '';
$state_id = $_POST['state_id'] ?? '';
$city_id = $_POST['city_id'] ?? '';

$hobbies = "";

if (isset($_POST['hobbies'])) {
    $hobbies = implode(",", $_POST['hobbies']);
}


// Validation

if ($id <= 0) {
    echo "Invalid ID";
    exit;
}

if ($name == '') {
    echo "Name is required";
    exit;
}

if ($email == '') {
    echo "Email is required";
    exit;
}


$name = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);
$gender = mysqli_real_escape_string($conn, $gender);
$hobbies = mysqli_real_escape_string($conn, $hobbies);


// Existing image

$oldImage = "";

$result = mysqli_query(
    $conn,
    "SELECT image FROM users WHERE id = $id"
);

if ($row = mysqli_fetch_assoc($result)) {
    $oldImage = $row['image'];
}


$imageSQL = "";


// New image uploaded

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] == 0
) {

    $imageName = time() . "_" . basename($_FILES['image']['name']);

    $uploadPath = "../uploads/" . $imageName;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadPath
    );


    // Delete old image

    if (
        !empty($oldImage) &&
        file_exists("../uploads/" . $oldImage)
    ) {

        unlink("../uploads/" . $oldImage);
    }


    $imageSQL = ", image='$imageName'";
}


// Update

$sql = "UPDATE users SET

        name='$name',
        email='$email',
        gender='$gender',
        hobbies='$hobbies',
        state_id='$state_id',
        city_id='$city_id'

        $imageSQL

        WHERE id=$id";


if (mysqli_query($conn, $sql)) {

    echo "success";

} else {

    echo "Error: " . mysqli_error($conn);
}

?>