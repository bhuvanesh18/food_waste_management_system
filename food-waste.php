<?php
    include("connection.php");
    session_start();
    error_reporting(0);
    if(!$_SESSION['email']){
        header('location:index.php');
    }else{
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- food waste -->
<script>
$(document).ready(function(){
  $("#food-waste-date-selector").change(function(){
    var date = new Date($('#food-waste-date-selector').val());
    
    var currentDate = new Date();

    // if only current date is greater than selected date
    if(currentDate > date){
        //for getting day 
        var GetURL = "get-day.php?day-value="+date.getDay();
        $.get(GetURL, function(data, status){
            var JSONData = JSON.parse(data);
            if(JSONData.hasOwnProperty('Error')){
                alert(JSONData.Error);
            }else{
                $('#food-waste-session-selected').find('option').remove().end().append('<option value="">Choose session</option>');
                if(JSONData.count==0){
                    alert("No session available for the selected day!");
                }else{
                    $('#food-waste-dayid-selected').val(JSONData.data.day_id);
                    $('#food-waste-day-selected').text(JSONData.data.day_name);

                    var GetURL = "get-all-available-day-sessions.php?day-selected="+$("#food-waste-dayid-selected").val();
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
                                $('#food-waste-session-selected').append(`<option class="text-capitalize" value=${JSONData.data[i]}>${JSONData.data[i]}</option>`);
                                i++;
                            }
                        }
                    }
                });
                }
            }
        });
    }else{
        // if selected date is greater than today date
        $('#food-waste-session-selected').find('option').remove().end().append('<option value="">Choose session</option>');
        $('#food-waste-dayid-selected').val("");
        $('#food-waste-day-selected').text("No day selected");
        $('#food-waste-date-selector').val('');
        alert("Please select vaild date!");
    } 
});
});
</script>
<!-- cook waste -->
<script>
$(document).ready(function(){
  $("#cook-waste-date-selector").change(function(){
    var date = new Date($('#cook-waste-date-selector').val());
    
    var currentDate = new Date();

    // if only current date is greater than selected date
    if(currentDate > date){
        //for getting day 
        var GetURL = "get-day.php?day-value="+date.getDay();
        $.get(GetURL, function(data, status){
            var JSONData = JSON.parse(data);
            if(JSONData.hasOwnProperty('Error')){
                alert(JSONData.Error);
            }else{
                $('#cook-waste-session-selected').find('option').remove().end().append('<option value="">Choose session</option>');
                if(JSONData.count==0){
                    alert("No session available for the selected day!");
                }else{
                    $('#cook-waste-dayid-selected').val(JSONData.data.day_id);
                    $('#cook-waste-day-selected').text(JSONData.data.day_name);

                    var GetURL = "get-all-available-day-sessions.php?day-selected="+$("#cook-waste-dayid-selected").val();
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
                                $('#cook-waste-session-selected').append(`<option class="text-capitalize" value=${JSONData.data[i]}>${JSONData.data[i]}</option>`);
                                i++;
                            }
                        }
                    }
                });
                }
            }
        });
    }else{
        // if selected date is greater than today date
        $('#cook-waste-session-selected').find('option').remove().end().append('<option value="">Choose session</option>');
        $('#cook-waste-dayid-selected').val("");
        $('#cook-waste-day-selected').text("No day selected");
        $('#cook-waste-date-selector').val('');
        alert("Please select vaild date!");
    } 
});
});
</script>
<!-- cook item waste -->
<script>
$(document).ready(function(){
    $("#cook-item-waste-date-selector").change(function(){
    var date = new Date($('#cook-item-waste-date-selector').val());
    
    var currentDate = new Date();

    // if only current date is greater than selected date
    if(currentDate > date){
        //for getting day 
        var GetURL = "get-day.php?day-value="+date.getDay();
        $.get(GetURL, function(data, status){
            var JSONData = JSON.parse(data);
            if(JSONData.hasOwnProperty('Error')){
                alert(JSONData.Error);
                $('#cook-item-waste-recipe-selected').find('option').remove().end().append('<option value="">Choose recipe</option>');
                $('#cook-item-waste-session-selected').find('option').remove().end().append('<option value="">Choose session</option>');
            }else{
                $('#cook-item-waste-session-selected').find('option').remove().end().append('<option value="">Choose session</option>');
                if(JSONData.count==0){
                    alert("No session available for the selected day!");
                    $('#cook-item-waste-recipe-selected').find('option').remove().end().append('<option value="">Choose recipe</option>');
                }else{
                    $('#cook-item-waste-dayid-selected').val(JSONData.data.day_id);
                    $('#cook-item-waste-day-selected').text(JSONData.data.day_name);
                    $('#cook-item-waste-recipe-selected').find('option').remove().end().append('<option value="">Choose recipe</option>');

                    var GetURL = "get-all-available-day-sessions.php?day-selected="+$("#cook-item-waste-dayid-selected").val();
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
                                $('#cook-item-waste-session-selected').append(`<option class="text-capitalize" value=${JSONData.data[i]}>${JSONData.data[i]}</option>`);
                                i++;
                            }
                        }
                    }
                });
                }
            }
        });
    }else{
        // if selected date is greater than today date
        $('#cook-item-waste-session-selected').find('option').remove().end().append('<option value="">Choose session</option>');
        $('#cook-item-waste-recipe-selected').find('option').remove().end().append('<option value="">Choose recipe</option>');
        $('#cook-item-waste-dayid-selected').val("");
        $('#cook-item-waste-day-selected').text("No day selected");
        $('#cook-item-waste-date-selector').val('');
        alert("Please select vaild date!");
    } 
});
});
</script>
<script>
$(document).ready(function(){
    // for recipe item option filling
    window.getRecipeList = function(){
        $('#cook-item-waste-recipe-selected').find('option').remove().end().append('<option value="">Choose recipe</option>');
        if($("#cook-item-waste-session-selected").val()!="" && $("#cook-item-waste-dayid-selected").val()!="" && $("#cook-item-waste-venue-selected").val()!=""){
            var GetURL = "get-recipe-list.php?day-selected="+$("#cook-item-waste-dayid-selected").val()+"&session-selected="+$("#cook-item-waste-session-selected").val()+"&venue-selected="+$("#cook-item-waste-venue-selected").val();
            $.get(GetURL, function(data, status){
            var JSONData = JSON.parse(data);
            if(JSONData.hasOwnProperty('Error')){
                alert(JSONData.Error);
            }else{
                if(JSONData.count==0){
                    alert("No recipe available for the selected session in that day!");
                    $('#cook-item-waste-recipe-selected').find('option').remove().end().append('<option value="">Choose recipe</option>');
                }else{
                    var n=JSONData.count;
                    var i=0;
                    while(i<n){
                        $('#cook-item-waste-recipe-selected').append(`<option class="text-capitalize" value=${JSONData.ids[i]}>${JSONData.names[i]}</option>`);
                        i++;
                    }
                }
            }
        });
        }else{
            $('#cook-item-waste-recipe-selected').find('option').remove().end().append('<option value="">Choose recipe</option>');
        }
    }
    $("#cook-item-waste-session-selected").change(getRecipeList);
    $("#cook-item-waste-venue-selected").change(getRecipeList);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include_once('header.html');
?>
</head>
<style>
.accordion .card-header:after {
    font-family: 'FontAwesome';  
    content: "\f077 ";
    float: right; 
}
.accordion .card-header.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\f078"; 
}
.box-content-height{
    max-height:350px;
    overflow-y:auto;
}
</style>
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
        <h2 class="display-5">Food Waste Entry</h2>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="food-waste-tab" data-bs-toggle="tab" href="#food-waste" role="tab" aria-controls="food-waste" aria-selected="true">Food waste</a>
                <a class="nav-link" id="cook-waste-tab" data-bs-toggle="tab" href="#cook-waste" role="tab" aria-controls="cook-waste" aria-selected="false">Cook waste</a>
                <a class="nav-link" id="cook-item-waste-tab" data-bs-toggle="tab" href="#cook-item-waste" role="tab" aria-controls="cook-item-waste" aria-selected="false">Cook item waste</a>
                <a class="nav-link" id="user-history-tab" data-bs-toggle="tab" href="#user-history" role="tab" aria-controls="user-history" aria-selected="false">Your history</a>
                <?php
                    if($_SESSION['role']=='SUPER_ADMIN'){
                        ?>
                        <a class="nav-link" id="overall-history-tab" data-bs-toggle="tab" href="#overall-history" role="tab" aria-controls="overall-history" aria-selected="false">Waste entry history</a>
                        <?php
                    }
                ?>
            </div>
        </nav>
        <div class="tab-content mt-4 container" id="nav-tabContent">
            <!-- food waste -->
            <div class="tab-pane fade show active" id="food-waste" role="tabpanel" aria-labelledby="food-waste-tab">
            <h2 class="text-center display-6">Food waste</h2>  
                <form class="row g-3" method="POST" action="food-waste-entry.php">
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
                        <label for="food-waste-date-selector">Select date</label>
                        <input type="date" class="form-control" id="food-waste-date-selector" name="date" required/>
                    </div>
                    <div class="col-sm-6">
                        <label for="food-waste-day-selected">Selected day</label>
                        <span class="form-control text-center user-select-none text-capitalize" id="food-waste-day-selected">No day selected</span>
                    </div>
                    <div class="col-sm-6 d-none">
                        <input type="text" id="food-waste-dayid-selected" name="day" readonly required/>
                        <input type="text" name="category" value="FOOD_WASTE" readonly required/>
                    </div>
                    <div class="col-sm-6">
                        <label for="food-waste-session-selected">Select any available session for chosen day</label>
                        <select class="form-select text-capitalize" id="food-waste-session-selected" name="session" required>
                            <option value="">Choose session</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="food-waste-weight">Enter food waste weight</label>
                        <input type="number" step="any" min="0" class="form-control" id="food-waste-weight" name="weight" placeholder="Enter food waste weight" required>
                    </div>
                    <div class="text-center col-sm-12">
                        <input type="submit" class="btn btn-primary" name="waste-entry-submit" value="Submit"/>
                    </div>
                </form>
            </div>

            <!-- cook waste -->
            <div class="tab-pane fade" id="cook-waste" role="tabpanel" aria-labelledby="cook-waste-tab">
            <h2 class="text-center">Cook waste</h2>  
                <form class="row g-3" method="POST" action="food-waste-entry.php">
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
                        <label for="cook-waste-date-selector">Select date</label>
                        <input type="date" class="form-control" id="cook-waste-date-selector" name="date" required/>
                    </div>
                    <div class="col-sm-6">
                        <label for="cook-waste-day-selected">Selected day</label>
                        <span class="form-control text-center user-select-none text-capitalize" id="cook-waste-day-selected">No day selected</span>
                    </div>
                    <div class="col-sm-6 d-none">
                        <input type="text" id="cook-waste-dayid-selected" name="day" readonly required/>
                        <input type="text" name="category" value="COOK_WASTE" readonly required/>
                    </div>
                    <div class="col-sm-6">
                        <label for="cook-waste-session-selected">Select any available session for chosen day</label>
                        <select class="form-select text-capitalize" id="cook-waste-session-selected" name="session" required>
                            <option value="">Choose session</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="cook-waste-weight">Enter food waste weight</label>
                        <input type="number" step="any" min="0" class="form-control" id="cook-waste-weight" name="weight" placeholder="Enter food waste weight" required>
                    </div>
                    <div class="text-center col-sm-12">
                        <input type="submit" class="btn btn-primary" name="waste-entry-submit" value="Submit"/>
                    </div>
                </form>
            </div>

            <!-- cook item waste -->
            <div class="tab-pane fade" id="cook-item-waste" role="tabpanel" aria-labelledby="cook-item-waste-tab">
            <h2 class="text-center">Cook item waste</h2>  
                <form class="row g-3" method="POST" action="food-waste-entry.php">
                    <?php
                        if($_SESSION['venue']=="ALL"){
                        ?>
                        <div class="col-sm-12">
                            <div class="mx-auto col-sm-6">
                                <label for="cook-item-waste-venue-selected">Select venue</label>
                                <select class="form-select text-capitalize" id="cook-item-waste-venue-selected" name="venue" required>
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
                        }else{
                            echo('<input type="hidden" id="cook-item-waste-venue-selected" value="'.$_SESSION[venue].'" readonly />'); 
                        }
                    ?>
                    <div class="col-sm-6">
                        <label for="cook-item-waste-date-selector">Select date</label>
                        <input type="date" class="form-control" id="cook-item-waste-date-selector" name="date" required/>
                    </div>
                    <div class="col-sm-6">
                        <label for="cook-item-waste-day-selected">Selected day</label>
                        <span class="form-control text-center user-select-none text-capitalize" id="cook-item-waste-day-selected">No day selected</span>
                    </div>
                    <div class="col-sm-6 d-none">
                        <input type="text" id="cook-item-waste-dayid-selected" name="day" readonly required/>
                        <input type="text" name="category" value="COOK_ITEM_WASTE" readonly required/>
                    </div>
                    <div class="col-sm-6">
                        <label for="cook-item-waste-session-selected">Select any available session for chosen day</label>
                        <select class="form-select text-capitalize" id="cook-item-waste-session-selected" name="session" required>
                            <option value="">Choose session</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="cook-item-waste-recipe-selected">Select recipe wasted</label>
                        <select class="form-select text-capitalize" id="cook-item-waste-recipe-selected" name="recipe" required>
                            <option value="">Choose recipe</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="cook-item-waste-weight">Enter food waste weight</label>
                        <input type="number" step="any" min="0" class="form-control" id="cook-item-waste-weight" name="weight" placeholder="Enter food waste weight" required>
                    </div>
                    <div class="text-center col-sm-12">
                        <input type="submit" class="btn btn-primary" name="waste-entry-submit" value="Submit"/>
                    </div>
                </form>
            </div>

            <!-- user history -->
            <div class="tab-pane fade" id="user-history" role="tabpanel" aria-labelledby="user-history-tab">
                <div class="container">
                    <div id="accordion" class="accordion border border-primary shadow">
                        <div class="card mb-0">
                            <div class="card-header collapsed" data-toggle="collapse" href="#user-history-collapseOne">
                                <a class="card-title">
                                    Food waste
                                </a>
                            </div>
                            <div id="user-history-collapseOne" class="card-body collapse box-content-height" data-parent="#accordion" >
                                <?php
                                    $query = "SELECT venue, date, day_id, session, weight, entry_at FROM food_wastes WHERE waste_category='FOOD_WASTE' AND entry_by='$_SESSION[email]'";
                                    $data = mysqli_query($conn, $query);
                                    if(mysqli_num_rows($data)==0){
                                        echo('<h4 class="text-center text-danger">No entries found!</h4>');
                                    }else{
                                        echo('<table class="table table-dark table-striped text-capitalize">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">S.NO</th>
                                                    <th scope="col">Venue</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Session</th>
                                                    <th scope="col">Weight</th>
                                                    <th scope="col">Entry at</th>
                                                    </tr>
                                                </thead>
                                            <tbody>');
                                        $count=1;
                                        while($row = mysqli_fetch_assoc($data)){
                                            echo('<tr>
                                            <th scope="row" class="text-secondary">'.$count.'</th>
                                            <td>'.$venue_array[$row['venue']].'</td>
                                            <td class="text-info">'.getDateFormat($row['date']).'</td>
                                            <td class="text-info">'.$days_info_array[$row['day_id']].'</td>
                                            <td class="text-warning">'.$row['session'].'</td>
                                            <td>'.$row['weight'].'</td>
                                            <td>'.getDateTimeFormat($row['entry_at']).'</td>
                                            </tr>');
                                            $count++;
                                        }
                                        echo("</tbody></table>");
                                    }
                                ?>
                            </div>
                            <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#user-history-collapseTwo">
                                <a class="card-title">
                                    Cook waste
                                </a>
                            </div>
                            <div id="user-history-collapseTwo" class="card-body collapse box-content-height" data-parent="#accordion" >
                            <?php
                                    $query = "SELECT venue, date, day_id, session, weight, entry_at FROM food_wastes WHERE waste_category='COOK_WASTE' AND entry_by='$_SESSION[email]'";
                                    $data = mysqli_query($conn, $query);
                                    if(mysqli_num_rows($data)==0){
                                        echo('<h4 class="text-center text-danger">No entries found!</h4>');
                                    }else{
                                        echo('<table class="table table-dark table-striped text-capitalize">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">S.NO</th>
                                                    <th scope="col">Venue</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Session</th>
                                                    <th scope="col">Weight</th>
                                                    <th scope="col">Entry at</th>
                                                    </tr>
                                                </thead>
                                            <tbody>');
                                        $count=1;
                                        while($row = mysqli_fetch_assoc($data)){
                                            echo('<tr>
                                            <th scope="row" class="text-secondary">'.$count.'</th>
                                            <td>'.$venue_array[$row['venue']].'</td>
                                            <td class="text-info">'.getDateFormat($row['date']).'</td>
                                            <td class="text-info">'.$days_info_array[$row['day_id']].'</td>
                                            <td class="text-warning">'.$row['session'].'</td>
                                            <td>'.$row['weight'].'</td>
                                            <td>'.getDateTimeFormat($row['entry_at']).'</td>
                                            </tr>');
                                            $count++;
                                        }
                                        echo("</tbody></table>");
                                    }
                                ?>
                            </div>
                            <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion" href="#user-history-collapseThree">
                                <a class="card-title">
                                    Cook item waste
                                </a>
                            </div>
                            <div id="user-history-collapseThree" class="card-body collapse box-content-height" data-parent="#accordion" >
                            <?php
                                    $query = "SELECT user_entry_with_food_item.*, recipe_name, recipe_image_path FROM recipes INNER JOIN (SELECT * FROM cook_item_waste INNER JOIN (SELECT * FROM food_wastes WHERE entry_by='$_SESSION[email]' AND waste_category='COOK_ITEM_WASTE') as user_entry ON user_entry.id = cook_item_waste.food_waste_id) as user_entry_with_food_item ON user_entry_with_food_item.recipe_id = recipes.id";
                                    $data = mysqli_query($conn, $query);
                                    if(mysqli_num_rows($data)==0){
                                        echo('<h4 class="text-center text-danger">No entries found!</h4>');
                                    }else{
                                        echo('<table class="table table-dark table-striped text-capitalize">
                                                <thead>
                                                    <tr>
                                                    <th scope="col">S.NO</th>
                                                    <th scope="col">Venue</th>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Session</th>
                                                    <th scope="col">Recipe Item</th>
                                                    <th scope="col">Weight</th>
                                                    <th scope="col">Entry at</th>
                                                    </tr>
                                                </thead>
                                            <tbody>');
                                        $count=1;
                                        while($row = mysqli_fetch_assoc($data)){
                                            echo('<tr>
                                            <th scope="row" class="text-secondary">'.$count.'</th>
                                            <td>'.$venue_array[$row['venue']].'</td>
                                            <td class="text-info">'.getDateFormat($row['date']).'</td>
                                            <td class="text-info">'.$days_info_array[$row['day_id']].'</td>
                                            <td class="text-warning">'.$row['session'].'</td>
                                            <td>
                                                <div>
                                                    <img src='.$row['recipe_image_path'].' alt='.$row['recipe_name'].' class="rounded-circle" width="50px" height="auto"/>
                                                    <span>'.$row['recipe_name'].'</span>
                                                </div>
                                            </td>
                                            <td>'.$row['weight'].'</td>
                                            <td>'.getDateTimeFormat($row['entry_at']).'</td>
                                            </tr>');
                                            $count++;
                                        }
                                        echo("</tbody></table>");
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- overall history -->
            <?php
                if($_SESSION['role']=='SUPER_ADMIN'){
                    ?>
                    <div class="tab-pane fade" id="overall-history" role="tabpanel" aria-labelledby="overall-history-tab">
                        <div class="container">
                            <div id="accordion-overall" class="accordion border border-primary shadow">
                                <div class="card mb-0">
                                    <div class="card-header collapsed" data-toggle="collapse" href="#overall-history-collapseOne">
                                        <a class="card-title">
                                            Over all Food waste
                                        </a>
                                    </div>
                                    <div id="overall-history-collapseOne" class="card-body collapse box-content-height" data-parent="#accordion-overall" >
                                        <?php
                                            $query = "SELECT overall_entry_history.*, name FROM users INNER JOIN (SELECT venue, date, day_id, session, weight, entry_by, entry_at FROM food_wastes WHERE waste_category='FOOD_WASTE') as overall_entry_history ON overall_entry_history.entry_by = users.email";
                                            $data = mysqli_query($conn, $query);
                                            if(mysqli_num_rows($data)==0){
                                                echo('<h4 class="text-center text-danger">No entries found!</h4>');
                                            }else{
                                                echo('<table class="table table-dark table-striped text-capitalize">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">S.NO</th>
                                                            <th scope="col">Venue</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Day</th>
                                                            <th scope="col">Session</th>
                                                            <th scope="col">Weight</th>
                                                            <th scope="col">Entry By</th>
                                                            <th scope="col">Entry at</th>
                                                            </tr>
                                                        </thead>
                                                    <tbody>');
                                                $count=1;
                                                while($row = mysqli_fetch_assoc($data)){
                                                    echo('<tr>
                                                    <th scope="row" class="text-secondary">'.$count.'</th>
                                                    <td>'.$venue_array[$row['venue']].'</td>
                                                    <td class="text-info">'.getDateFormat($row['date']).'</td>
                                                    <td class="text-info">'.$days_info_array[$row['day_id']].'</td>
                                                    <td class="text-warning">'.$row['session'].'</td>
                                                    <td>'.$row['weight'].'</td>
                                                    <td>
                                                        <span>'.$row['name'].'</span>
                                                        <p class="text-info text-lowercase">'.$row['entry_by'].'</p>    
                                                    </td>
                                                    <td>'.getDateTimeFormat($row['entry_at']).'</td>
                                                    </tr>');
                                                    $count++;
                                                }
                                                echo("</tbody></table>");
                                            }
                                        ?>
                                    </div>
                                    <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion-overall" href="#overall-history-collapseTwo">
                                        <a class="card-title">
                                            Overall Cook waste
                                        </a>
                                    </div>
                                    <div id="overall-history-collapseTwo" class="card-body collapse box-content-height" data-parent="#accordion-overall" >
                                    <?php
                                            $query = "SELECT overall_entry_history.*, name FROM users INNER JOIN (SELECT venue, date, day_id, session, weight, entry_by, entry_at FROM food_wastes WHERE waste_category='COOK_WASTE') as overall_entry_history ON overall_entry_history.entry_by = users.email";
                                            $data = mysqli_query($conn, $query);
                                            if(mysqli_num_rows($data)==0){
                                                echo('<h4 class="text-center text-danger">No entries found!</h4>');
                                            }else{
                                                echo('<table class="table table-dark table-striped text-capitalize">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">S.NO</th>
                                                            <th scope="col">Venue</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Day</th>
                                                            <th scope="col">Session</th>
                                                            <th scope="col">Weight</th>
                                                            <th scope="col">Entry By</th>
                                                            <th scope="col">Entry at</th>
                                                            </tr>
                                                        </thead>
                                                    <tbody>');
                                                $count=1;
                                                while($row = mysqli_fetch_assoc($data)){
                                                    echo('<tr>
                                                    <th scope="row" class="text-secondary">'.$count.'</th>
                                                    <td>'.$venue_array[$row['venue']].'</td>
                                                    <td class="text-info">'.getDateFormat($row['date']).'</td>
                                                    <td class="text-info">'.$days_info_array[$row['day_id']].'</td>
                                                    <td class="text-warning">'.$row['session'].'</td>
                                                    <td>'.$row['weight'].'</td>
                                                    <td>
                                                        <span>'.$row['name'].'</span>
                                                        <p class="text-info text-lowercase">'.$row['entry_by'].'</p>    
                                                    </td>
                                                    <td>'.getDateTimeFormat($row['entry_at']).'</td>
                                                    </tr>');
                                                    $count++;
                                                }
                                                echo("</tbody></table>");
                                            }
                                        ?>
                                    </div>
                                    <div class="card-header collapsed" data-toggle="collapse" data-parent="#accordion-overall" href="#overall-history-collapseThree">
                                        <a class="card-title">
                                            Overall Cook item waste
                                        </a>
                                    </div>
                                    <div id="overall-history-collapseThree" class="card-body collapse box-content-height" data-parent="#accordion-overall" >
                                    <?php
                                            $query = "SELECT overall_entry_history.*, name FROM users INNER JOIN (SELECT user_entry_with_food_item.*, recipe_name, recipe_image_path FROM recipes INNER JOIN (SELECT * FROM cook_item_waste INNER JOIN (SELECT * FROM food_wastes WHERE waste_category='COOK_ITEM_WASTE') as user_entry ON user_entry.id = cook_item_waste.food_waste_id) as user_entry_with_food_item ON user_entry_with_food_item.recipe_id = recipes.id) as overall_entry_history ON overall_entry_history.entry_by = users.email";
                                            $data = mysqli_query($conn, $query);
                                            if(mysqli_num_rows($data)==0){
                                                echo('<h4 class="text-center text-danger">No entries found!</h4>');
                                            }else{
                                                echo('<table class="table table-dark table-striped text-capitalize">
                                                        <thead>
                                                            <tr>
                                                            <th scope="col">S.NO</th>
                                                            <th scope="col">Venue</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Day</th>
                                                            <th scope="col">Session</th>
                                                            <th scope="col">Recipe Item</th>
                                                            <th scope="col">Weight</th>
                                                            <th scope="col">Entry by</th>
                                                            <th scope="col">Entry at</th>
                                                            </tr>
                                                        </thead>
                                                    <tbody>');
                                                $count=1;
                                                while($row = mysqli_fetch_assoc($data)){
                                                    echo('<tr>
                                                    <th scope="row" class="text-secondary">'.$count.'</th>
                                                    <td>'.$venue_array[$row['venue']].'</td>
                                                    <td class="text-info">'.getDateFormat($row['date']).'</td>
                                                    <td class="text-info">'.$days_info_array[$row['day_id']].'</td>
                                                    <td class="text-warning">'.$row['session'].'</td>
                                                    <td>
                                                        <div>
                                                            <img src='.$row['recipe_image_path'].' alt='.$row['recipe_name'].' class="rounded-circle" width="50px" height="auto"/>
                                                            <span>'.$row['recipe_name'].'</span>
                                                        </div>
                                                    </td>
                                                    <td>'.$row['weight'].'</td>
                                                    <td>
                                                        <span>'.$row['name'].'</span>
                                                        <p class="text-info text-lowercase">'.$row['entry_by'].'</p>    
                                                    </td>
                                                    <td>'.getDateTimeFormat($row['entry_at']).'</td>
                                                    </tr>');
                                                    $count++;
                                                }
                                                echo("</tbody></table>");
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                } // end of else
                ?>
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
    function getDateFormat($date){
        $date = explode('-',$date);
        return $date[2]."-".$date[1]."-".$date[0];
    }

    function getDateTimeFormat($timestamp){

        $datetime = explode(' ',$timestamp);

        // getting time in 12 hr format
        $time = explode(':',$datetime[1]);
        $hr_min = $time[0].":".$time[1];
        $time_in_12_hr_format = date("g:i a",strtotime($hr_min));
                            
        $date_dmy_format = getDateFormat($datetime[0]);

        return $time_in_12_hr_format." ".$date_dmy_format;
    }

?>