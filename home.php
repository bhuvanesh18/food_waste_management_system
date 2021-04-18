<?php
    include_once('connection.php');
    session_start();
    error_reporting(0);
    if(!$_SESSION['email']){
        header('location:index.php');
    }else{
        $query = "SELECT is_active FROM users WHERE email = '$_SESSION[email]' LIMIT 1";
        $data = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($data);

        $_SESSION['is_active'] = $result['is_active'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include_once('header.html');
?>
</head>
<body class="main-layout">
    <?php
        include_once('sideNav.php');
    ?>
    <div id="content" class="mt-5 pt-5">
        <div class="m-5">
        <!-- header -->
        <?php
        include_once('navBar.php');
        echo('<h2>Hi <span class="display-6 text-secondary">'.$_SESSION['name'].'</span></h2>');
        echo('<h2>Institution Name: <span class="text-primary">'.$_SESSION["institution_name"].'</span></h2>');

        switch ($_SESSION['is_active']) {
            case 0:
                $status = "Inactive";
                $color = "text-danger";
                break;
            case 1:
                $status = "Active";
                $color = "text-success";
                break;
        }
        echo('<h2>Account status - <span class="display-6 '.$color.'">'.$status.'</span></h2>');
        ?>
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
}
?>