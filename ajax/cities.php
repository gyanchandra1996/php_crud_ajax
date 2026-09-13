<?php

include "../db.php";

$state_id = $_POST['state_id'] ?? '';

if ($state_id == '') {

    echo '<option value="">Select City</option>';

    exit;
}

$state_id = (int)$state_id;

$sql = "SELECT *
        FROM cities
        WHERE state_id = $state_id
        ORDER BY city_name";

$result = mysqli_query($conn, $sql);

echo '<option value="">Select City</option>';

while ($row = mysqli_fetch_assoc($result)) {

    echo '<option value="' . $row['id'] . '">'
        . htmlspecialchars($row['city_name'])
        . '</option>';
}
?>