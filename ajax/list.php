<?php

include "../db.php";

$sql = "SELECT
            users.*,
            states.state_name,
            cities.city_name
        FROM users

        LEFT JOIN states
            ON users.state_id = states.id

        LEFT JOIN cities
            ON users.city_id = cities.id

        ORDER BY users.id DESC";

$result = mysqli_query($conn, $sql);

?>

<table class="table table-bordered table-striped">

    <thead>

        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Hobbies</th>
            <th>State</th>
            <th>City</th>
            <th>Action</th>
        </tr>

    </thead>

    <tbody>

    <?php if (mysqli_num_rows($result) > 0) { ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td>
                    <?php echo $row['id']; ?>
                </td>

                <td>

                    <?php if (!empty($row['image'])) { ?>

                        <img
                            src="uploads/<?php echo htmlspecialchars($row['image']); ?>"
                            width="60"
                            height="60"
                            style="object-fit:cover;"
                        >

                    <?php } else { ?>

                        No Image

                    <?php } ?>

                </td>

                <td>
                    <?php echo htmlspecialchars($row['name']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['email']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['gender']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['hobbies']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['state_name']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($row['city_name']); ?>
                </td>

                <td>

                    <button
                        class="btn btn-sm btn-warning editBtn"
                        data-id="<?php echo $row['id']; ?>"
                    >
                        Edit
                    </button>

                    <button
                        class="btn btn-sm btn-danger deleteBtn"
                        data-id="<?php echo $row['id']; ?>"
                    >
                        Delete
                    </button>

                </td>

            </tr>

        <?php } ?>

    <?php } else { ?>

        <tr>

            <td colspan="9" class="text-center">
                No users found
            </td>

        </tr>

    <?php } ?>

    </tbody>

</table>