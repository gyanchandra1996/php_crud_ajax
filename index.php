<?php
include "db.php";

$states = mysqli_query($conn, "SELECT * FROM states ORDER BY state_name");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PHP AJAX CRUD</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4">PHP AJAX CRUD</h2>

    <!-- Message -->
    <div id="message"></div>

    <!-- Form -->
    <div class="card mb-4">

        <div class="card-header">
            <h5 id="formTitle">Add User</h5>
        </div>

        <div class="card-body">

            <form id="userForm" enctype="multipart/form-data">

                <input type="hidden" name="id" id="user_id">

                <div class="row">

                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                        >
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                        >
                    </div>

                    <!-- Image -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>

                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="form-control"
                            accept="image/*"
                        >

                        <div class="mt-2">
                            <img
                                id="imagePreview"
                                src=""
                                width="80"
                                style="display:none;"
                            >
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label d-block">
                            Gender
                        </label>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="gender"
                                value="Male"
                                id="male"
                            >

                            <label class="form-check-label" for="male">
                                Male
                            </label>

                        </div>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="gender"
                                value="Female"
                                id="female"
                            >

                            <label class="form-check-label" for="female">
                                Female
                            </label>

                        </div>

                    </div>

                    <!-- Hobbies -->
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Hobbies
                        </label>

                        <br>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="hobbies[]"
                                value="Reading"
                                id="reading"
                            >

                            <label class="form-check-label" for="reading">
                                Reading
                            </label>

                        </div>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="hobbies[]"
                                value="Music"
                                id="music"
                            >

                            <label class="form-check-label" for="music">
                                Music
                            </label>

                        </div>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="hobbies[]"
                                value="Sports"
                                id="sports"
                            >

                            <label class="form-check-label" for="sports">
                                Sports
                            </label>

                        </div>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="hobbies[]"
                                value="Travel"
                                id="travel"
                            >

                            <label class="form-check-label" for="travel">
                                Travel
                            </label>

                        </div>

                    </div>

                    <!-- State -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            State
                        </label>

                        <select
                            name="state_id"
                            id="state_id"
                            class="form-select"
                        >

                            <option value="">
                                Select State
                            </option>

                            <?php while ($state = mysqli_fetch_assoc($states)) { ?>

                                <option value="<?php echo $state['id']; ?>">
                                    <?php echo htmlspecialchars($state['state_name']); ?>
                                </option>

                            <?php } ?>

                        </select>

                    </div>

                    <!-- City -->
                    <div class="col-md-3 mb-3">

                        <label class="form-label">
                            City
                        </label>

                        <select
                            name="city_id"
                            id="city_id"
                            class="form-select"
                        >

                            <option value="">
                                Select City
                            </option>

                        </select>

                    </div>

                </div>

                <button
                    type="submit"
                    id="saveBtn"
                    class="btn btn-primary"
                >
                    Save
                </button>

                <button
                    type="button"
                    id="cancelBtn"
                    class="btn btn-secondary"
                    style="display:none;"
                >
                    Cancel
                </button>

            </form>

        </div>
    </div>


    <!-- Users Table -->

    <div class="card">

        <div class="card-header">
            <h5>Users List</h5>
        </div>

        <div class="card-body">

            <div id="userTable"></div>

        </div>

    </div>

</div>


<script src="js/script.js"></script>

</body>
</html>