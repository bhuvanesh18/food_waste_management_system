<?php
    include("connection.php");
    session_start();
    error_reporting(0);
    if(!$_SESSION['email']){
        header('location:index.php');
    }else{
        if($_SESSION['role']!='ADMIN' && $_SESSION['role']!='SUPER_ADMIN'){
        ?>
            <script>
                window.location="home.php";
            </script>
        <?php
        }else{
?>
<?php
    $venue_query = "SELECT * FROM venue_info";
    $venue_data = mysqli_query($conn, $venue_query);

    $venue_array = [];
    while($venue_result = mysqli_fetch_assoc($venue_data)){
        $venue_array[$venue_result['venue_id']]= $venue_result['venue_name'];
    }
    $venue_array["ALL"] = "ALL Dinings";

    $institution_query = "SELECT institution_id, institution_name FROM institutions";
    $institution_data = mysqli_query($conn, $institution_query);
    $institution_array = [];
    while($institution_result = mysqli_fetch_assoc($institution_data)){
        $institution_array[$institution_result['institution_id']] = $institution_result['institution_name'];
    }

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
        ?>
        <h2 class="display-5">Account activations</h2>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="activation-requests-tab" data-bs-toggle="tab" href="#activation-requests" role="tab" aria-controls="activation-requests" aria-selected="true">Activation requests</a>
                <a class="nav-link" id="active-accounts-tab" data-bs-toggle="tab" href="#active-accounts" role="tab" aria-controls="active-accounts" aria-selected="false">Active accounts</a>
                <a class="nav-link" id="blocked-accounts-tab" data-bs-toggle="tab" href="#blocked-accounts" role="tab" aria-controls="blocked-accounts" aria-selected="false">Blocked accounts</a>
                <a class="nav-link" id="user-history-tab" data-bs-toggle="tab" href="#user-history" role="tab" aria-controls="user-history" aria-selected="false">Your history</a>
                <?php
                    if($_SESSION['role']=='SUPER_ADMIN'){
                        ?>
                        <a class="nav-link" id="overall-history-tab" data-bs-toggle="tab" href="#overall-history" role="tab" aria-controls="overall-history" aria-selected="false">Overall History</a>
                        <?php
                    }
                ?>
            </div>
        </nav>
        <div class="tab-content mt-4" id="nav-tabContent">
            <!-- activation requests tab-->
            <div class="tab-pane fade show active" id="activation-requests" role="tabpanel" aria-labelledby="activation-requests-tab">
               <?php
                    if($_SESSION['role']=='SUPER_ADMIN'){
                        $query = "SELECT name, email, role, venue FROM users WHERE is_active=0 AND is_blocked=0";
                    }else if($_SESSION['role']=='ADMIN'){
                        $query = "SELECT name, email, role, venue FROM users WHERE is_active=0 AND is_blocked=0 AND role='MANAGER' AND institution_id = '$_SESSION[institution_id]'";
                    }
            
                    $data = mysqli_query($conn, $query);
                    if(mysqli_num_rows($data)==0){
                        ?>
                        <h4 class="mt-2 text-center">No pending request found!<h4>
                    <?php
                    }else{
                        echo('<table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Name</th>
                                    <th scole="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Venue</th>
                                    <th scope="col" colspan="2" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>');
                        $count=1;
                        while($row = mysqli_fetch_assoc($data)){
                            echo('<tr>
                                <th scope="row">'.$count.'</th>
                                <td class="text-capitalize">'.$row["name"].'</td>
                                <td class="text-info">'.$row["email"].'</td>
                                <td class="text-warning">'.$row["role"].'</td>
                                <td class="text-capitalize text-info">'.$venue_array[$row["venue"]].'</td>
                                <td><form method="POST" action="approve-account.php">
                                        <input type="text" value="'.$row['email'].'" name="selectedUserEmail" class="d-none" readonly />
                                        <input type="submit" class="btn btn-success" value="Approve" name="approve"/>
                                    </form>
                                </td>
                                <td><form method="POST" action="block-account.php">
                                        <input type="text" value="'.$row['email'].'" name="selectedUserEmail" class="d-none" readonly />
                                        <input type="submit" class="btn btn-danger" value="Block" name="block"/>
                                    </form>
                                </td>
                            </tr>');
                            $count++;
                        }
                        ?>
                        </tbody>
                        </table>
                        <?php
                        }// end of else
                    ?>
            </div>
            <!-- active accounts -->
            <div class="tab-pane fade" id="active-accounts" role="tabpanel" aria-labelledby="active-accounts-tab">
               <?php
                    if($_SESSION['role']=='SUPER_ADMIN'){
                        $query = "SELECT name, email, role, venue FROM users WHERE is_active=1 AND is_blocked=0 AND email!='$_SESSION[email]'";
                    }else if($_SESSION['role']=='ADMIN'){
                        $query = "SELECT name, email, role, venue FROM users WHERE is_active=1 AND is_blocked=0 AND role='MANAGER' AND email!='$_SESSION[email]' AND institution_id = '$_SESSION[institution_id]'";
                    }
            
                    $data = mysqli_query($conn, $query);
                    if(mysqli_num_rows($data)==0){
                        ?>
                        <h4 class="mt-2 text-center">No active accounts found!<h4>
                    <?php
                    }else{
                        echo('<table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Name</th>
                                    <th scole="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Venue</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>');
                        $count=1;
                        while($row = mysqli_fetch_assoc($data)){
                            echo('<tr>
                                <th scope="row">'.$count.'</th>
                                <td class="text-capitalize">'.$row["name"].'</td>
                                <td class="text-info">'.$row["email"].'</td>
                                <td class="text-warning">'.$row["role"].'</td>
                                <td class="text-capitalize text-info">'.$venue_array[$row["venue"]].'</td>
                                <td><form method="POST" action="block-account.php">
                                        <input type="text" value="'.$row['email'].'" name="selectedUserEmail" class="d-none" readonly />
                                        <input type="submit" class="btn btn-danger" value="Block" name="block"/>
                                    </form>
                                </td>
                            </tr>');
                            $count++;
                        }
                        ?>
                        </tbody>
                        </table>
                        <?php
                        }// end of else
                    ?>
            </div>
            <!-- blocked accounts -->
            <div class="tab-pane fade" id="blocked-accounts" role="tabpanel" aria-labelledby="blocked-accounts-tab">
               <?php
                    if($_SESSION['role']=='SUPER_ADMIN'){
                        $query = "SELECT name, email, role, venue FROM users WHERE is_blocked=1";
                    }else if($_SESSION['role']=='ADMIN'){
                        $query = "SELECT name, email, role, venue FROM users WHERE is_blocked=1 AND role='MANAGER' AND institution_id = '$_SESSION[institution_id]'";
                    }
            
                    $data = mysqli_query($conn, $query);
                    if(mysqli_num_rows($data)==0){
                        ?>
                        <h4 class="mt-2 text-center">No blocked accounts found!<h4>
                    <?php
                    }else{
                        echo('<table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Name</th>
                                    <th scole="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Venue</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>');
                        $count=1;
                        while($row = mysqli_fetch_assoc($data)){
                            echo('<tr>
                                <th scope="row">'.$count.'</th>
                                <td class="text-capitalize">'.$row["name"].'</td>
                                <td class="text-info">'.$row["email"].'</td>
                                <td class="text-warning">'.$row["role"].'</td>
                                <td class="text-capitalize text-info">'.$venue_array[$row["venue"]].'</td>
                                <td><form method="POST" action="approve-account.php">
                                        <input type="text" value="'.$row['email'].'" name="selectedUserEmail" class="d-none" readonly />
                                        <input type="submit" class="btn btn-success" value="Approve" name="approve"/>
                                    </form>
                                </td>
                            </tr>');
                            $count++;
                        }
                        ?>
                        </tbody>
                        </table>
                        <?php
                        }// end of else
                    ?>
            </div>
            <!-- user history -->
            <div class="tab-pane fade" id="user-history" role="tabpanel" aria-labelledby="user-history-tab">
                <?php
                    $query = "SELECT name, role, venue, email, is_approved, action_logged_at FROM users INNER JOIN users_log_status ON users.email = users_log_status.user_email WHERE users_log_status.action_by = '$_SESSION[email]' ORDER BY users_log_status.id ASC";
                    $data = mysqli_query($conn, $query);

                    if(mysqli_num_rows($data)==0){
                        ?>
                        <h4 class="mt-2 text-center">No approvals history found on your account!<h4>
                    <?php
                    }else{
                        ?>
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                <th scope="col">S.NO</th>
                                <th scope="col">Name</th>
                                <th scole="col">Email</th>
                                <th scope="col">Requsted Role</th>
                                <th scope="col">Venue</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action on</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $count=1;
                                while($row = mysqli_fetch_assoc($data)){
                                    echo('<tr>
                                        <th scope="row">'.$count.'</th>
                                        <td class="text-capitalize">'.$row["name"].'</td>
                                        <td class="text-info">'.$row["email"].'</td>
                                        <td class="text-warning">'.$row["role"].'</td>
                                        <td class="text-capitalize text-info">'.$venue_array[$row["venue"]].'</td>');

                                        if($row["is_approved"]==0){
                                            $approvalstatus = "Blocked";
                                            $textcolorclass = "text-danger";
                                        }else if($row["is_approved"]==1){
                                            $approvalstatus = "Approved";
                                            $textcolorclass = "text-success";
                                        }

                                        $data_time_format = getDateTimeFormat($row["action_logged_at"]);

                                    echo('<td class='.$textcolorclass.'>'.$approvalstatus.'</td>
                                        <td>'.$data_time_format.'</td>
                                    </tr>');
                                    $count++;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }// end of else
                ?>
            </div>
            <?php
                if($_SESSION['role']=='SUPER_ADMIN'){
                    ?>
                    <!-- overall history -->
                    <div class="tab-pane fade" id="overall-history" role="tabpanel" aria-labelledby="overall-history-tab">
                        <?php
                        $query = "SELECT id, requestor_name, requestor_email, temp_table.role as requestor_role, temp_table.venue as requestor_venue, action_taker_email, users.name as action_taker_name,
                                 is_approved, action_logged_at, institution_id from users INNER join (SELECT id, name as requestor_name, email as requestor_email, 
                                 role, venue, action_by as action_taker_email, is_approved ,action_logged_at FROM users INNER JOIN users_log_status
                                ON users_log_status.user_email = users.email) as temp_table on users.email = temp_table.action_taker_email ORDER BY id ASC";
                        $data = mysqli_query($conn, $query);

                        if(mysqli_num_rows($data)==0){
                            ?>
                            <h4 class="mt-2 text-center">No history found!<h4>
                        <?php
                        }else{
                            ?>
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Institution</th>
                                    <th scope="col">Requestor Name</th>
                                    <th scope="col">Requsted Role</th>
                                    <th scope="col">Requsted Venue</th>
                                    <th scole="col">Action Taken By</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action on</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $count=1;
                                    while($row = mysqli_fetch_assoc($data)){
                                        echo('<tr>
                                            <th scope="row">'.$count.'</th>
                                            <td class="text-secondary">'.$institution_array[$row["institution_id"]].'</td>
                                            <td><span class="text-capitalize">'.$row["requestor_name"].'</span><br><span class="text-info">'.$row["requestor_email"].'<span></td>
                                            <td class="text-warning">'.$row["requestor_role"].'</td>
                                            <td class="text-capitalize text-info">'.$venue_array[$row["requestor_venue"]].'</td>');

                                            if($_SESSION['email']==$row["action_taker_email"]){
                                                echo('<td class="text-warning fw-bold">You</td>');
                                            }else{
                                                echo('<td><span class="text-capitalize">'.$row["action_taker_name"].'</span><br><span class="text-info">'.$row["action_taker_email"].'</span></td>');
                                            }

                                            if($row["is_approved"]==0){
                                                $approvalstatus = "Blocked";
                                                $textcolorclass = "text-danger";
                                            }else if($row["is_approved"]==1){
                                                $approvalstatus = "Approved";
                                                $textcolorclass = "text-success";
                                            }

                                            $data_time_format = getDateTimeFormat($row["action_logged_at"]);

                                        echo('<td class='.$textcolorclass.'>'.$approvalstatus.'</td>
                                            <td>'.$data_time_format.'</td>
                                        </tr>');
                                        $count++;
                                    }
                                ?>
                            </tbody>
                        </table>
                        <?php
                    }// end of else
                    
                    ?>
                    </div>
                    <?php
                }
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
} //end of else
?>

<?php 
    // utility functions
    function getDateTimeFormat($timestamp){

        $datetime = explode(' ',$timestamp);

        // getting time in 12 hr format
        $time = explode(':',$datetime[1]);
        $hr_min = $time[0].":".$time[1];
        $time_in_12_hr_format = date("g:i a",strtotime($hr_min));

        //getting date d-m-y format
        $date = explode('-',$datetime[0]);
        $date_dmy_format = $date[2]."-".$date[1]."-".$date[0];

        return $time_in_12_hr_format." ".$date_dmy_format;
    }
?>