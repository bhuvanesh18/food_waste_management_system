<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="full">
                    <a class="logo" href="index.php"><img src="images/logo.png" alt="logo" style="width:280px;height:80px;"/></a>  
                </div>
            </div>
            <div class="col-md-9">
                <div class="full">
                    <div class="right_header_info">
                        <ul>
                            <li class="button_user" style="height: 21px;margin-top: -5px;">
                                <?php
                                error_reporting(0);
                                if($_SESSION['email']){
                                    ?>
                                    <button class="btn btn-danger py-1" onclick="window.location='logout.php';">Logout</button>
                                    <?php
                                }else{
                                ?>
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#login">Login</button>
                                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#register">Register</button>
                                <?php
                                }
                                ?>
                            </li>
                            <li>
                                <button type="button" id="sidebarCollapse">
                                    <img src="images/menu_icon.png" alt="#">
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</header>