$(document).ready(function () {

    // Load users when page opens

    loadUsers();


    // --------------------------------
    // Load Users
    // --------------------------------

    function loadUsers() {

        $.ajax({

            url: "ajax/list.php",
            type: "GET",

            success: function (response) {

                $("#userTable").html(response);

            }

        });
    }


    // --------------------------------
    // State -> City AJAX
    // --------------------------------

    $("#state_id").change(function () {

        let state_id = $(this).val();

        $("#city_id").html(
            '<option value="">Loading...</option>'
        );


        if (state_id == "") {

            $("#city_id").html(
                '<option value="">Select City</option>'
            );

            return;
        }


        $.ajax({

            url: "ajax/cities.php",

            type: "POST",

            data: {
                state_id: state_id
            },

            success: function (response) {

                $("#city_id").html(response);

            }

        });

    });


    // --------------------------------
    // Add / Update
    // --------------------------------

    $("#userForm").submit(function (e) {

        e.preventDefault();


        let formData = new FormData(this);

        let id = $("#user_id").val();

        let url = "ajax/save.php";


        if (id != "") {

            url = "ajax/update.php";

        }


        $.ajax({

            url: url,

            type: "POST",

            data: formData,

            contentType: false,

            processData: false,

            success: function (response) {


                if (response.trim() == "success") {

                    $("#message").html(
                        '<div class="alert alert-success">' +
                        'Saved successfully' +
                        '</div>'
                    );


                    resetForm();

                    loadUsers();

                } else {

                    $("#message").html(
                        '<div class="alert alert-danger">' +
                        response +
                        '</div>'
                    );

                }

            },

            error: function () {

                $("#message").html(
                    '<div class="alert alert-danger">' +
                    'Something went wrong' +
                    '</div>'
                );

            }

        });

    });


    // --------------------------------
    // Edit
    // --------------------------------

    $(document).on("click", ".editBtn", function () {

        let id = $(this).data("id");


        $.ajax({

            url: "ajax/get.php",

            type: "POST",

            dataType: "json",

            data: {
                id: id
            },

            success: function (data) {


                if (data.error) {

                    alert(data.error);

                    return;
                }


                $("#user_id").val(data.id);

                $("#name").val(data.name);

                $("#email").val(data.email);


                // Gender

                $("input[name='gender']").prop(
                    "checked",
                    false
                );

                $("input[name='gender'][value='" +
                    data.gender +
                    "']").prop(
                    "checked",
                    true
                );


                // Hobbies

                $("input[name='hobbies[]']").prop(
                    "checked",
                    false
                );


                if (data.hobbies) {

                    data.hobbies.forEach(function (hobby) {

                        $("input[name='hobbies[]'][value='" +
                            hobby +
                            "']").prop(
                            "checked",
                            true
                        );

                    });

                }


                // State

                $("#state_id").val(data.state_id);


                // Get cities for selected state

                $.ajax({

                    url: "ajax/cities.php",

                    type: "POST",

                    data: {
                        state_id: data.state_id
                    },

                    success: function (response) {

                        $("#city_id").html(response);

                        $("#city_id").val(
                            data.city_id
                        );

                    }

                });


                // Image preview

                if (data.image != "") {

                    $("#imagePreview")
                        .attr(
                            "src",
                            "uploads/" + data.image
                        )
                        .show();

                } else {

                    $("#imagePreview").hide();

                }


                $("#formTitle").text("Edit User");

                $("#saveBtn").text("Update");

                $("#cancelBtn").show();


                // Scroll to form

                $("html, body").animate({

                    scrollTop: $("#userForm").offset().top

                }, 500);

            }

        });

    });


    // --------------------------------
    // Delete
    // --------------------------------

    $(document).on("click", ".deleteBtn", function () {

        let id = $(this).data("id");


        if (!confirm("Are you sure you want to delete this user?")) {
            return;
        }


        $.ajax({

            url: "ajax/delete.php",

            type: "POST",

            data: {
                id: id
            },

            success: function (response) {

                if (response.trim() == "success") {

                    $("#message").html(
                        '<div class="alert alert-success">' +
                        'Deleted successfully' +
                        '</div>'
                    );

                    loadUsers();

                } else {

                    alert(response);

                }

            }

        });

    });


    // --------------------------------
    // Cancel
    // --------------------------------

    $("#cancelBtn").click(function () {

        resetForm();

    });


    // --------------------------------
    // Reset Form
    // --------------------------------

    function resetForm() {

        $("#userForm")[0].reset();

        $("#user_id").val("");

        $("#city_id").html(
            '<option value="">Select City</option>'
        );

        $("#imagePreview").hide();

        $("#formTitle").text("Add User");

        $("#saveBtn").text("Save");

        $("#cancelBtn").hide();

    }


    // --------------------------------
    // Image Preview
    // --------------------------------

    $("#image").change(function () {

        let file = this.files[0];

        if (file) {

            let reader = new FileReader();

            reader.onload = function (e) {

                $("#imagePreview")
                    .attr("src", e.target.result)
                    .show();

            };

            reader.readAsDataURL(file);

        }

    });

});