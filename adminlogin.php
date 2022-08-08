<?php
session_start();

if (isset($_SESSION['email'])) {
    header("location:dashboard");
}

// print_r($_SESSION);

include_once("./layout/head.php");

?>

<body class="vh-100" id="body-el">
<div class="container-fluid">
    <!-- <div class="row bg-secondary py-3 text-center">
        <h2 class="text-light">Header</h2>
    </div> -->
    <div class="row ">
        <!-- <div class="col-lg-1"></div> -->
        <div class="col-md-2 col-lg-2 col-xl-2 col-xxl-3"></div>

        <div class="col-md-4 col-lg-4 col-xl-4 col-xxl-3 p-3 order-2 order-md-1 login_form">
            <div class="">
                <div class="row ">
                    <div class="col-md-12">
                        <h3 class="text-left fw-bold">Login with Your Account</h3>
                    </div>
                </div>
                <br>
                <form id="loginform" method="post" class="w-100 ">

                    <div class="form-outline">
                        <label class="form-label fw-bold" for="useremail">Email</label>
                        <input type="text" class="form-control form-control-lg w-100 mb-3" id="user_email"
                            name="user_email" placeholder="Enter Your Email">
                        <span class="field-error text-danger fw-bold" id="username_error"></span>
                    </div>
                    <br>

                    <div class="form-outline mb-4">
                        <label class="form-label fw-bold" for="userpassword">Password</label>
                        <input type="password" class="form-control form-control-lg w-100 mb-3" id="userpass"
                            name="userpass" placeholder="Enter Password">
                        <span class="field-error text-danger fw-bold" id="pass_error"></span>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6 text-danger fw-bold" id="credential_error"></div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="row ">
                        <div class="col-md-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-success w-25 btn-block mb-4 signup-btn btn-login">Log
                                In</button>
                        </div>
                    </div>
                    <br>

                </form>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-6 order-1 order-md-2">
            <div class="ms-2" id="login-logo">
                <span class="fw-bold login-logo"> Blog's Today </span>
            </div>
        </div>
        <!-- <div class="col-md-2 col-lg-2"></div> -->

    </div>
</div>


<?php include_once("./layout/footer.php"); ?>

<script>
$(document).ready(function() {

    // $("#loginform").trigger("reset");
    // document.getElementById("loginform").reset();

    $("#user_email").on("change keyup", function(){
        $("#username_error").text('');
    });

    $("#userpass").on("change keyup", function(){
        $("#pass_error").text('');
    });

    $("#loginform").submit(function(e) {
        // alert("innn");
        e.preventDefault();
        var user_email = $("#user_email").val();
        var user_pass = $("#userpass").val();
        var pass_status;
        var email_status;
        // var email_pattern = /^[\w.+\-]+@gmail\.com$/;
        var emailPattern = /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/;
        $("#pass_error").text("");

        if (user_email == '' || user_email == null) {
            $("#username_error").text("Please enter email address");
            $("#credential_error").text('');
            email_status = false;
        }
        else if (!emailPattern.test(user_email)){
            $("#username_error").text("Please enter valid email address");
            $("#credential_error").text('');
            email_status = false;
        }
        else {
            $("#username_error").text("");
            email_status = true;
        }

        if (user_pass == '' || user_pass == null) {
            $("#pass_error").text("Please enter password");
            $("#credential_error").text('');
            pass_status = false;
        }
        else if(user_pass.length < 6){
            $("#pass_error").text("Password must be 6 character long.");
            $("#credential_error").text('');
            pass_status = false;
        }
        else {
            $("#pass_error").text("");
            pass_status = true;
        }

        if (email_status && pass_status) {

            var loginFormData = new FormData(this);

            $.ajax({
                url: "./controllers/Login.php",
                method: "POST",
                data: loginFormData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    if (res.status == false) {
                        $.each(res.error, function(key, val) {
                            $("#" + key + "").text(val);
                        });
                        if (res.type == "password_not_matched" || res.type ==
                            "no_user_found") {
                            $("#pass_error").text("Credentials not mached.");
                        }
                    }
                    if (res.status == true && res.type == "password_matched") {
                        window.location.href = "dashboard";
                    }
                }
            });
        }
    });
});
</script>