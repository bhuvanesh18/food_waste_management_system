<?php
    include("connection.php");
    session_start();
    error_reporting(0);
    if(!$_SESSION['email']){
        header('location:index.php');
    }else{
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $("#day-selector").change(function(){
    // for clearing the previous result options
    $('#day-session').find('option').remove().end().append('<option value="">Choose day session</option>');
    var GetURL = "get-day-sessions.php?day-selected="+$("#day-selector").val();
    $.get(GetURL, function(data, status){
      var JSONData = JSON.parse(data);
      if(JSONData.hasOwnProperty('Error')){
          alert(JSONData.Error);
      }else{
        if(JSONData.count==0){
            alert("No session available for the selected day!");
        }else{
            var n=JSONData.data.length;
            var i=0;
            while(i<n){
                $('#day-session').append(`<option class="text-capitalize" value=${JSONData.data[i]}>${JSONData.data[i]}</option>`);
                i++;
            }
        }
      }
  });
});
});
</script>
<script>
$(document).ready(function(){
  $("#day").change(function(){
    // for clearing the previous result options
    $('#session').find('option').remove().end().append('<option value="ALL">All available sessions</option>');
    if($("#day").val()!="ALL"){
        var GetURL = "get-all-available-day-sessions.php?day-selected="+$("#day").val();
        $.get(GetURL, function(data, status){
        var JSONData = JSON.parse(data);
        if(JSONData.hasOwnProperty('Error')){
            alert(JSONData.Error);
        }else{
            if(JSONData.count==0){
                alert("No session available for the selected day!");
            }else{
                var n=JSONData.data.length;
                var i=0;
                while(i<n){
                    $('#session').append(`<option class="text-capitalize" value=${JSONData.data[i]}>${JSONData.data[i]}</option>`);
                    i++;
                }
            }
        }
    });
    }
});
});
</script>
<script>
$(document).ready(function(){
  $("#apply-filter").click(function(){
        // for clearing previous child elements
        $('#filtered_result_content').empty();

        // if venue selector feild's id exists
        if($('#venue').length){
            var GetURL = "get-recipes.php?day="+$("#day").val()+"&session="+$("#session").val()+"&venue="+$("#venue").val();
        }else{
            var GetURL = "get-recipes.php?day="+$("#day").val()+"&session="+$("#session").val();
        }

        $.get(GetURL, function(data, status){
        var JSONData = $.parseJSON(data);
        if(JSONData.hasOwnProperty('Error')){
            $('#filtered_result_content').append(JSONData.Error);
        }else{
            $('#filtered_result_content').append(JSONData.data);
        }
    });
  });
});
</script>
<?php
    // days info 
    $get_days_info_query = "SELECT day_id, day_value FROM days_info ORDER BY day_order ASC";
    $get_days_info_data = mysqli_query($conn,$get_days_info_query);
    $days_info_array = [];
    while($get_days_info_result = mysqli_fetch_assoc($get_days_info_data)){
        $days_info_array[$get_days_info_result['day_id']] = $get_days_info_result['day_value'];
    }

    //venue info
    $venue_query = "SELECT * FROM venue_info";
    $venue_data = mysqli_query($conn, $venue_query);
    $venue_array = [];
    while($venue_result = mysqli_fetch_assoc($venue_data)){
        $venue_array[$venue_result['venue_id']]= $venue_result['venue_name'];
    }

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
        <h2 class="display-5">Recipe Updations</h2>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="add-recipe-tab" data-bs-toggle="tab" href="#add-recipe" role="tab" aria-controls="add-recipe" aria-selected="true">Add recipe</a>
                <a class="nav-link" id="remove-recipe-tab" data-bs-toggle="tab" href="#remove-recipe" role="tab" aria-controls="remove-recipe" aria-selected="false">Remove recipe</a>
                <a class="nav-link" id="user-history-tab" data-bs-toggle="tab" href="#user-history" role="tab" aria-controls="user-history" aria-selected="false">Your history</a>
                <?php
                    if($_SESSION['role']=='SUPER_ADMIN'){
                        ?>
                        <a class="nav-link" id="recipes-history-tab" data-bs-toggle="tab" href="#recipes-history" role="tab" aria-controls="recipes-history" aria-selected="false">Recipes history</a>
                        <?php
                    }
                ?>
            </div>
        </nav>
        <div class="tab-content mt-4 container" id="nav-tabContent">
            <!-- add recipe -->
            <div class="tab-pane fade show active" id="add-recipe" role="tabpanel" aria-labelledby="add-recipe-tab">
                <h2 class="text-center display-6">Add Recipe</h2>  
                <form class="row g-3" method="POST" action="add-recipe.php"  enctype="multipart/form-data">
                    <?php
                        if($_SESSION['venue']=="ALL"){
                        ?>
                        <div class="col-sm-12">
                            <div class="mx-auto col-sm-6">
                                <label for="venue-selector">Select venue</label>
                                <select class="form-select text-capitalize" id="venue-selector" name="venue" required>
                                    <option value="">Choose venue</option>
                                    <?php
                                        $query = "SELECT * FROM venue_info WHERE is_venue_available=1";
                                        $data = mysqli_query($conn, $query);
                                        while($result = mysqli_fetch_assoc($data)){
                                            echo('<option class="text-capitalize" value="'.$result['venue_id'].'">'.$result["venue_name"].'</option>');
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                        } // end of if
                    ?>
                    <div class="col-sm-6">
                        <label for="day-selector">Select day</label>
                        <select class="form-select text-capitalize" id="day-selector" name="day" required>
                            <option value="">Choose day</option>
                            <?php
                                $query = "SELECT * FROM days_info WHERE is_available=1 ORDER BY day_order ASC";
                                $data = mysqli_query($conn, $query);
                                while($result = mysqli_fetch_assoc($data)){
                                    echo('<option class="text-capitalize" value="'.$result['day_id'].'">'.$result["day_value"].'</option>');
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="day-session">Select any available session for chosen day</label>
                        <select class="form-select text-capitalize" id="day-session" name="day-session" required>
                            <option value="">Choose day session</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="recipe-name">Enter recipe name</label>
                        <input type="text" class="form-control" name="recipe-name" id="recipe-name" maxlength="50" placeholder="Enter recipe name" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="recipe-image" class="form-label">Choose recipe image</label>
                        <input class="form-control" type="file" name="recipe-image" id="recipe-image" accept="image/png,image/jpeg,image/jpg" required>
                    </div>
                    <div class="text-center col-sm-12">
                        <input type="submit" class="btn btn-primary" name="add-recipe" value="Add Recipe"/>
                    </div>
                </form>
            </div>

            <!-- remove recipe -->
            <div class="tab-pane fade" id="remove-recipe" role="tabpanel" aria-labelledby="remove-recipe-tab">
                <form class="row row-cols-lg-auto g-2 align-items-center" method="POST">
                    <?php
                        if($_SESSION['venue']=="ALL"){
                            ?>
                            <div class="col-12">
                                <select class="form-select text-capitalize" id="venue" name="venue">
                                    <?php
                                        $query = "SELECT * FROM venue_info WHERE is_venue_available=1";
                                        $data = mysqli_query($conn, $query);
                                        while($result = mysqli_fetch_assoc($data)){
                                            echo('<option class="text-capitalize" value="'.$result['venue_id'].'">'.$result["venue_name"].'</option>');
                                        }
                                    ?>
                                </select>
                            </div>
                        <?php
                        }
                    ?>
                    <div class="col-12">
                        <select class="form-select text-capitalize" id="day" name="day">
                            <option value="ALL">All available days</option>
                            <?php
                                $query = "SELECT day_id, day_value FROM days_info WHERE is_available=1 ORDER BY day_order ASC";
                                $data = mysqli_query($conn, $query);
                                while($result = mysqli_fetch_assoc($data)){
                                    echo('<option class="text-capitalize" value="'.$result['day_id'].'">'.$result["day_value"].'</option>');
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <select class="form-select text-capitalize" id="session" name="session">
                            <option value="ALL">All available sessions</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="button" id="apply-filter" name="apply-filter" class="btn btn-primary">Apply</button>
                    </div>
                </form>
                <div id="filtered_result_content"></div>
            </div>

            <!-- user history -->
            <div class="tab-pane fade" id="user-history" role="tabpanel" aria-labelledby="user-history-tab">
                <?php
                    $user_history_query = "SELECT * FROM recipes INNER JOIN recipes_log_status ON recipes_log_status.recipe_id = recipes.id WHERE recipes_log_status.action_by = '$_SESSION[email]'";
                    $user_history_data = mysqli_query($conn,$user_history_query);
                    if($user_history_data){
                        $total_rows = mysqli_num_rows($user_history_data);
                        if($total_rows==0){
                            echo('<h4 class="text-center">No recipe contribution on your account!</h4>');    
                        }else{
                            ?>
                            <table class="table table-dark table-striped text-capitalize text-center">
                            <thead>
                                <tr>
                                <th scope="col">S.NO</th>
                                <th scope="col">Venue</th>
                                <th scope="col">Day</th>
                                <th scope="col">Session</th>
                                <th scole="col">Recipe name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Contribution</th>
                                <th scope="col">Action on</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $count=1;
                                while($row = mysqli_fetch_assoc($user_history_data)){
                                    echo('<tr>
                                        <th scope="row" class="text-secondary">'.$count.'</th>
                                        <td>'.$venue_array[$row["venue"]].'</td>
                                        <td class="text-warning">'.$days_info_array[$row["day"]].'</td>
                                        <td>'.$row["session"].'</td>
                                        <td class="text-info">'.$row["recipe_name"].'</td>');

                                        if($row["is_active"]==0){
                                            $activestatus = "Not In Use";
                                            $textcolorclass = "text-danger";
                                        }else if($row["is_active"]==1){
                                            $activestatus = "In Use";
                                            $textcolorclass = "text-success";
                                        }

                                        if($row["is_created"]==0){
                                            $createdstatus = "You removed";
                                            $textcolorclass1 = "text-danger";
                                        }else if($row["is_created"]==1){
                                            $createdstatus = "You added";
                                            $textcolorclass1 = "text-success";
                                        }


                                        $data_time_format = getDateTimeFormat($row["action_logged_at"]);

                                    echo('<td class='.$textcolorclass.'>'.$activestatus.'</td>
                                        <td class='.$textcolorclass1.'>'.$createdstatus.'</td>
                                        <td class="text-secondary">'.$data_time_format.'</td>
                                    </tr>');
                                    $count++;
                                }
                            ?>
                            </tbody>
                        </table>
                        <?php
                        }
                    }else{
                        echo('<h4 class="text-center">Internal server error occured. Try again!</h4>');
                    }
                ?>
            </div>
            <!-- overall history -->
            <?php
                if($_SESSION['role']=='SUPER_ADMIN' || $_SESSION['role']=='ADMIN'){
                    ?>
                    <div class="tab-pane fade" id="recipes-history" role="tabpanel" aria-labelledby="recipes-history-tab">
                        <?php
                        if($_SESSION['role']=='SUPER_ADMIN'){
                            $overall_query = "SELECT recipe_info_and_history.*, users.name from users INNER JOIN (SELECT * FROM recipes INNER JOIN recipes_log_status ON recipes_log_status.recipe_id = recipes.id) as recipe_info_and_history ON recipe_info_and_history.action_by = users.email";
                        }else if($_SESSION['role']=='ADMIN'){
                            $overall_query = "SELECT recipe_info_and_history.*, users.name from users INNER JOIN (SELECT * FROM recipes INNER JOIN recipes_log_status ON recipes_log_status.recipe_id = recipes.id WHERE institution_id = '$_SESSION[institution_id]' ) as recipe_info_and_history ON recipe_info_and_history.action_by = users.email";
                        }
                        $overall_data = mysqli_query($conn,$overall_query);
                        if($overall_data){
                            $total_rows = mysqli_num_rows($overall_data);
                            if($total_rows==0){
                                echo('<h4 class="text-center">No recipe contribution on your account!</h4>');    
                            }else{
                                ?>
                                <table class="table table-dark table-striped text-capitalize text-center">
                                <thead>
                                    <tr>
                                    <th scope="col">S.NO</th>
                                    <th scope="col">Institution</th>
                                    <th scope="col">Venue</th>
                                    <th scope="col">Day</th>
                                    <th scope="col">Session</th>
                                    <th scole="col">Recipe name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Contributor</th>
                                    <th scope="col">Contribution</th>
                                    <th scope="col">Action on</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $count=1;
                                    while($row = mysqli_fetch_assoc($overall_data)){
                                        echo('<tr>
                                            <th scope="row" class="text-secondary">'.$count.'</th>
                                            <td>'.$institution_array[$row["institution_id"]].'</td>
                                            <td>'.$venue_array[$row["venue"]].'</td>
                                            <td class="text-warning">'.$days_info_array[$row["day"]].'</td>
                                            <td>'.$row["session"].'</td>
                                            <td class="text-info">'.$row["recipe_name"].'</td>');

                                            if($row["is_active"]==0){
                                                $activestatus = "Not In Use";
                                                $textcolorclass = "text-danger";
                                            }else if($row["is_active"]==1){
                                                $activestatus = "In Use";
                                                $textcolorclass = "text-success";
                                            }
                                            
                                            if($row['action_by']==$_SESSION['email']){
                                                $contributor_info = "You"; 
                                            }else{
                                                $contributor_info = $row['name'].'<br><span class="text-info text-lowercase">'.$row['action_by'].'</span>';
                                            }

                                            if($row["is_created"]==0){
                                                $contributionstatus = "You removed";
                                                $textcolorclass1 = "text-danger";
                                            }else if($row["is_created"]==1){
                                                $contributionstatus = "You added";
                                                $textcolorclass1 = "text-success";
                                            }


                                            $data_time_format = getDateTimeFormat($row["action_logged_at"]);

                                        echo('<td class='.$textcolorclass.'>'.$activestatus.'</td>
                                            <td class="text-warning">'.$contributor_info.'</td>
                                            <td class='.$textcolorclass1.'>'.$contributionstatus.'</td>
                                            <td class="text-secondary">'.$data_time_format.'</td>
                                        </tr>');
                                        $count++;
                                    }
                                ?>
                                </tbody>
                            </table>
                            <?php
                            }
                        }else{
                            echo('<h4 class="text-center">Internal server error occured. Try again!</h4>');
                        }
                    } // end of else
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