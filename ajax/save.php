<?php

include "../db.php";

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$gender = $_POST['gender'] ?? '';
$state_id = $_POST['state_id'] ?? '';
$city_id = $_POST['city_id'] ?? '';

$hobbies = "";

if (isset($_POST['hobbies'])) {
    $hobbies = implode(",", $_POST['hobbies']);
}


// Minimum validation

if ($name == '') {
    echo "Name is required";
    exit;
}

if ($email == '') {
    echo "Email is required";
    exit;
}


// Image

$imageName = "";

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {

    $imageName = time() . "_" . basename($_FILES['image']['name']);

    $uploadPath = "../uploads/" . $imageName;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadPath
    );
}


// Insert

$name = mysqli_real_escape_string($conn, $name);
$email = mysqli_real_escape_string($conn, $email);
$gender = mysqli_real_escape_string($conn, $gender);
$hobbies = mysqli_real_escape_string($conn, $hobbies);

$sql = "INSERT INTO users
        (name, email, image, gender, hobbies, state_id, city_id)
        VALUES
        ('$name', '$email', '$imageName', '$gender', '$hobbies', '$state_id', '$city_id')";

if (mysqli_query($conn, $sql)) {

    echo "success";

} else {

    echo "Error: " . mysqli_error($conn);
}
?>