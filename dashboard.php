<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("location:adminlogin");
}


include_once("./layout/head.php");
?>

<body class="vh-100" id="body-el">
<div class="container-fluid mb-4">
    <!-- custom alert start -->
    <div class="col-lg-4 col-md-4 col-sm-5 ml-auto d-none rightSideAlert">
        <div class="alert alert-dismissible fade show add-alert-prop">
     
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading"></h4>
            <strong><p class="alert-message"></p></strong>
     
        </div>
    </div>
    <!-- custom alert end -->
    <div class="row bg-secondary py-3">
        <div class="col col-md-9 d-inline">
            <h2 class="text-light">Today's Blog</h2>
        </div>
        <!-- <div class="col-md-6"></div> -->
        <div class="col col-md-3 text-end ">
            <button type="button" class="btn btn-primary me-4">
                <a href="logout.php" class="text-light">Logout</a>
            </button>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <form method="POST" id="editor_form">
                <div class="row mt-4">
                    <div class="col-md-12">
                        <textarea name="text_editor" id="text_editor" cols="30" rows="20" >
                            </textarea>
                        <div class="fw-bold mt-2 fs-5" id="editor_msg"> </div>
                        <span class=" text-danger" id="editor_error"> </span>

                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-success me-4"> Submit </button>
                </div>
            </form>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

<?php include_once("./layout/footer.php");?>

<script>
$(document).ready(function() {

    $("#editor_form").submit(function(e) {
        e.preventDefault();
        var editorFormData = new FormData(this);
        var blog_content = $("#text_editor").val();
        var blog_content_status;

        if (blog_content.trim() == '' || blog_content.trim() == null) {
            // $("#editor_error").text("Please enter content");
            alertErrorMessage("Please enter content")
            blog_content_status = false;
        } else {
            $("#editor_error").text("");
            blog_content_status = true;
        }

        if( blog_content_status){
            $.ajax({
                url: "./controllers/Dashboard.php",
                method: "POST",
                data: editorFormData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    console.log(res);
                    setTimeout(function() {
                        $("#editor_msg").html('');
                        $('#editor_form').trigger("reset");
                    }, 4000);
                    if (res.status == true) {
                        $("#editor_msg").html('');
                        alertSuccessMessage(res.message);
                    }
                    if (res.status == false) {
                        $("#editor_msg").html('');
                        alertErrorMessage(message)
                    }
                }
            });
        }

    });

    function alertSuccessMessage(message){
        setTimeout(function(){
            $(".rightSideAlert").addClass("d-none");
            $(".rightSideAlert").fadeOut(1000);
        }, 4000);
        $(".add-alert-prop").removeClass("alert-danger").addClass("alert-success");
        $(".alert-heading").text('').text("Success");
        $(".alert-message").text('').text(message);
        $(".rightSideAlert").removeClass("d-none");
    }

    function alertErrorMessage(message){
        setTimeout(function(){
            $(".rightSideAlert").addClass("d-none");
            $(".rightSideAlert").fadeOut(1000);
        }, 4000);
        $(".add-alert-prop").removeClass("alert-success").addClass("alert-danger");
        $(".alert-heading").text('').text("Error");
        $(".alert-message").text('').text(message);
        $(".rightSideAlert").removeClass("d-none");
    }
});
</script>