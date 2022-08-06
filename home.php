<?php

// spl_autoload_register(function ($className) {
//     require_once("./controllers/models/" . $className . ".php");
// });

// $userData = Crud::getUserData($_SESSION['id']);

include_once("./layout/head.php");

?>

<body class="vh-100">
    <div class="container-fluid">
        <div class="row bg-secondary py-3 align-items-center" id="home-header">
            <span class="text-dark text-start ps-4"> Blog's Today</span>
        </div>

        <div class="row pb-3" id="second-row">
            <div class="col-lg-2 h-40rem border pb-4" id="left-side-box">
                <fieldset class="border p-2 m-2">
                    <legend class="float-none w-auto p-2"> Content </legend>
                    <ul class="">
                        <li class=""><a href="#">Heading 1</a></li>
                        <li class=""><a href="#">Heading 2</a></li>
                        <li class=""><a href="#">Heading 3</a></li>
                        <li class=""><a href="#">Heading 4</a></li>
                        <li class=""><a href="#">Heading 5</a></li>
                    </ul>
                </fieldset>
            </div>
            <div class="col-lg-8 border pb-4">
                <div class=" mx-3 " id="blog-box">
                    <fieldset class="border p-2 m-2">
                        <legend class="float-none w-auto p-2 fs-2 fw-bold" id="title"> ABC </legend>
                        <div id="content-box" style="overflow-x: hidden;"></div>
                    </fieldset>
                </div>
            </div>
            <div class="col-lg-2 border pb-4" id="right-side-box">
                <fieldset class="border p-2 m-2">
                    <legend class="float-none w-auto p-2"> today's quote </legend>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Reiciendis fuga aspernatur saepe placeat, laboriosam porro dolorum quam enim praesentium facilis numquam velit blanditiis provident, eius, reprehenderit pariatur cupiditate esse dignissimos.
                    </p>
                </fieldset>
            </div>
        </div>
        <div class="row bottom-0 align-items-end " id="footer-box">
            <div class="col-md-12 w-100 footer-copyright text-center py-3 " style="background: #907163">
                © 2022 Copyright: Today'sBlog.com
            </div>
            
        </div>
    </div>

    <!-- <footer class="page-footer font-small fixed-bottom "> -->

    <!-- </footer> -->


    <?php

    include_once("./layout/footer.php");

    ?>

    <script>
        $(document).ready(function() {
            $.ajax({
                url: "./controllers/Home.php",
                method: "POST",
                data: {
                    getContent: "getContent"
                },
                success: function(response) {
                    var res = JSON.parse(response);                    
                    
                    if (res.status == true) {
                        $("#content-box").append(res.data.content);
                    }
                    if (res.status == false) {
                        $("#title").html('');
                        $("#content-box").html('');
                        $("#content-box").append('No Data Found');
                    }

                    if($("#content-box").find("img").length > 0){
                        $('#content-box img').attr('class', 'img-fluid');
                    }
                }
            });
        })
    </script>