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
li{
    margin-top:20px;
}
button{
    width:200px;
    height:50px;
}
</style>
<body class="main-layout">
    <?php
        include_once('sideNav.php');
    ?>
    <div id="content">
        <!-- Modal -->
        <?php
            include_once('modals.html');
        ?>
        <div style="position:relative;">
            <img src="./images/bg_img.jpg" style="width:100%;height:623px;" alt="background image"/>
        </div>
        <div style="position:absolute; top:40%; left:65%;">
            <ul>
                <li>
                    <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#login">Login</button>
                </li>
                <li>
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#register">Register</button>
                </li>
            </ul>
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