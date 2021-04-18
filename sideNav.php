<?php
error_reporting(0);
?>
<div class="sidebar">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div id="dismiss-sidenav">
            <i class="fa fa-arrow-left"></i>
        </div>
        <ul class="list-unstyled components">
            <li class="active" >
                <a href="home.php">Home</a>
            </li>
            <?php
                if($_SESSION['email'] && $_SESSION['is_active']==1){
                    ?>
                    <li>
                        <a href="update-recipes.php">Update Recipes</a>
                    </li>
                    <li>
                        <a href="food-waste.php">Food Waste Entry</a>
                    </li>
                    <li>
                        <a href="track-analysis.php">Track and Analysis</a>
                    </li>
                <?php
                    if($_SESSION['role']=='ADMIN' || $_SESSION['role']=='SUPER_ADMIN'){
                        ?>
                        <li>
                            <a href="account-activations.php">Account Activations</a>
                        </li>
                        <?php
                    }
                }
            ?>
        </ul>
        <?php
                if($_SESSION['email']){
                    ?>
                    <div class="mx-3 mb-4">
                        <button class="btn btn-danger  mx-5 px-5" onclick="window.location='logout.php';">Logout</button>
                    </div>
                    <?php
                }
            ?>
    </nav>
</div>