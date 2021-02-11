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
    <!-- start slider section -->
    <div class="slider_section">
	<br><br><br><br><br><br><br><br><br>
	<div class="row">
                        <div class="col-lg-6 col-md-10 col-sm-6 m-b30">
                           <div class="icon-bx-wraper bx-style-1 p-a20 center">
                              <div class="icon-xl text-primary m-b20"> <a href="#" class="icon-cell"><i class="ti-location-pin"></i></a> </div>
                              <div class="icon-content">
							  <h5 style="color:white" align="center" class="tilte">Address</h5>
                                 <p style="color:white" align="center">Sathy - Bhavani State Highway, Alathukombai - Post,<br>
                                    Sathyamangalam - 638 401, Erode District, Tamil Nadu, India
                                 </p>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 m-b30">
                           <div class="icon-bx-wraper bx-style-1 p-a20 center">
                              <div class="icon-xl text-primary m-b20"> <a href="#" class="icon-cell"><i class="ti-mobile"></i></a> </div>
                              <div class="icon-content">
                                 <h5 style="color:white" align="center" class="tilte">Phone</h5>
                                 <p align="center"><a href="tel:+914295226000" style="color:white" >Phone No. : +91 - 4295 - 226000</a> <br> <a href="tel:+914295226666" style="color:white" align="center" >Phone No. : +91 - 4295 - 226666</a></p>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 m-b30">
                           <div class="icon-bx-wraper bx-style-1 p-a20 center">
                              <div class="icon-xl text-primary m-b20"> <a href="#" class="icon-cell"><i class="ti-email"></i></a> </div>
                              <div class="icon-content"><br><br><br><br><br><br><br>
                                 <h5 style="color:white" align="center" class="tilte">Email</h5>
                                 <p style="color:white" align="center">stayahead@bitsathy.ac.in</a></p>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-10 col-sm-6 m-b30">
                           <div class="icon-bx-wraper bx-style-1 p-a20 center">
                              <div class="icon-xl text-primary m-b20"> <a href="#" class="icon-cell"><i class="fa fa-university"></i></a> </div>
                              <div class="icon-content"><br><br><br><br><br><br><br>
                                 <h5 style="color:white" align="center" class="tilte">Admission</h5>
                                 <p style="color:white" align="center">admissions@bitsathy.ac.in</a> <br> +91-89401 26000</p>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-10 col-sm-6 m-b30">
                           <div class="icon-bx-wraper bx-style-1 p-a20 center">
                              <div class="icon-xl text-primary m-b20"> <a href="#" class="icon-cell"><i class="ti-world"></i></a> </div>
                              <div class="icon-content"><br><br><br><br><br><br><br>
                                 <h5 style="color:white" align="center" class="tilte">Website</h5>
                                 <p style="color:white" align="center">digitalmarketing@bitsathy.ac.in</a></p>
                              </div>
                           </div>
						   
                           <div class="icon-bx-wraper bx-style-1 p-a20 center">
                              <div class="topbar-right topbar-social center" style="float: none;">
                                 <ul class="list-inline m-a0">
                                    <li><a target="_blank" href="https://www.facebook.com/bitsathyindia" class="site-button facebook circle "><i class="fa fa-facebook"></i></a></li>
                                    <li><a target="_blank" href="https://www.youtube.com/bitsathyindia?sub_confirmation=1" class="site-button youtube circle "><i class="fa fa-youtube-play"></i></a></li>
                                    <li><a target="_blank" href="https://in.linkedin.com/school/bitsathyindia/" class="site-button linkedin circle "><i class="fa fa-linkedin"></i></a></li>
                                    <li><a target="_blank" href="http://instagram.com/lifeatbit" class="site-button instagram circle "><i class="fa fa-instagram"></i></a></li>
                                    <li><a target="_blank" href="https://twitter.com/Bitsathyindia" class="site-button twitter circle "><i class="fa fa-twitter"></i></a></li>
                                 </ul>
                              </div> 
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </div>
    <div class="overlay"></div>
   <!-- Javascript files-->
   <?php
      include_once('scripts.html');
   ?>
</body>
</html>