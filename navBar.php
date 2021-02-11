<header>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="full">
                    <a class="logo" href="index.php"><img src="images/bitlogo.png" alt="#" /></a>  
                </div>
            </div>
            <div class="col-md-9">
                <div class="full">
                    <div class="right_header_info">
                        <ul>
                            <li class="dinone">Contact Us : <img style="margin-right: 15px;margin-left: 15px;" src="images/phone_icon.png" alt="#"><a href="#">9659454703</a></li>
                            <li class="dinone"><img style="margin-right: 15px;" src="images/mail_icon.png" alt="#"><a href="#">stayahead@bitsathy.ac.in</a></li>
                            <li class="dinone"><img style="margin-right: 15px;height: 21px;position: relative;top: -2px;" src="images/location_icon.png" alt="#"><a href="#">Sathyamangalam, Erode, Tamil Nadu.</a></li>
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