<?php
    error_reporting(0);
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include_once('header.html');
?>
</head>
<!-- body -->
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
        <!--content -->
        <div class="container text-center">
            <div class="row mt-5 pt-5">
                <div class="col-md-12 mt-5"> 
                    <img src="images/rs1.png" alt="#" />
                </div>
                <div>
                    <h4>About</h4>
                    <p>Here you can type your about content.</p>
                </div>
            </div>
        </div>
        <!-- end content -->
    </div>
    <div class="overlay"></div>
   <!-- Javascript files-->
   <?php
      include_once('scripts.html');
   ?>
</body>
</html>