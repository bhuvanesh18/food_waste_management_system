<?php
    error_reporting(0);
    session_start();
    if($_SESSION['email']){
        header('location:home.php');
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include_once('header.html');
?>
</head>
<style>
html{
    background-color:#212529;
}
</style>
<body class="main-layout">
    <?php
        include_once('sideNav.php');
    ?>
    <div id="content">
        <!-- header -->
        <?php
            include_once('navBar.php');
        ?>
        <!-- end header -->
        <!-- Modal -->
        <?php
            include_once('modals.html');
        ?>
        <!-- end modal -->
    <!-- start slider section -->
        <div class="slider_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="full">
                            <div id="main_slider" class="carousel vert slide" data-ride="carousel" data-interval="5000">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="slider_cont">
                                                    <h3>Respect for food is a respect for life, for who we are and what we do</h3>
                                                    <p align="right">– Thomas Keller</p>
                                                    
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="slider_image full text_align_center">
                                                    <img class="img-responsive" src="images/001.jpg" alt="#" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="carousel-item">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="slider_cont">
                                                    <h3>There is food for everyone on this planet, but not everyone eats.</h3>
                                                    <p align="right">– Carlo Petrini</p>
                                                </div>
                                            </div>
                                            <div class="col-md-7 full text_align_center">
                                                <div class="slider_image">
                                                    <img class="img-responsive" src="images/002.jpg" alt="#" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                                    <i class="fa fa-angle-up"></i>
                                </a>
                                <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                                    <i class="fa fa-angle-down"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end slider section -->
    </div>
    </div>
    <div class="overlay"></div>
    <!-- Javascript files-->
    <?php
        include_once('scripts.html');
    ?>
</body>
</html>
<?php
    } //end of else
?>