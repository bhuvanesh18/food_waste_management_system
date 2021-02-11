<?php
    include("connection.php");
    error_reporting(0);
    session_start();
    $day = $_GET['day'];
    $session = $_GET['session']; 

    if($_SESSION['venue']=="ALL"){
        $venue = $_GET['venue'];
    }else{
        $venue = $_SESSION['venue'];
    }

    $result = new STDClass();

    $output = "";
    if($day!="" && $session!=""){
        if($day!="ALL" && $session!="ALL"){
            $selected_day_session_query = "SELECT fetched_recipe_table.*, day_value FROM days_info INNER JOIN (SELECT id, day, session, recipe_name, recipe_image_path, venue FROM recipes WHERE day='$day' AND session='$session' AND venue='$venue' AND is_active = 1 ORDER BY id ASC) as fetched_recipe_table ON fetched_recipe_table.day = days_info.day_id";
        }elseif($day=="ALL" && $session=="ALL"){
            $selected_day_session_query = "SELECT fetched_result_sorted.*, days_info.day_value FROM days_info INNER JOIN (SELECT fetched_result.*, session_info.session_order FROM session_info INNER JOIN (SELECT recipes.* from recipes INNER JOIN (SELECT CONCAT(day_id,session_name) as day_session FROM days_session_info WHERE is_available=1) as available_sessions ON available_sessions.day_session = CONCAT(recipes.day,recipes.session) WHERE recipes.is_active=1 AND recipes.venue='$venue' ) as fetched_result ON fetched_result.session=session_info.session) as fetched_result_sorted ON fetched_result_sorted.day=days_info.day_id ORDER BY days_info.day_order ASC, fetched_result_sorted.session_order ASC";
        }else if($day!="ALL" && $session=="ALL"){
            $selected_day_session_query = "SELECT fetched_result.*, days_info.day_value FROM days_info INNER JOIN (SELECT recipes.* from recipes INNER JOIN (SELECT CONCAT(day_id,session_name) as day_session FROM days_session_info WHERE is_available=1) as available_sessions ON available_sessions.day_session = CONCAT(recipes.day,recipes.session) WHERE recipes.is_active=1 AND recipes.day='$day' AND recipes.venue='$venue') as fetched_result ON fetched_result.day = days_info.day_id ORDER BY days_info.day_order ASC";
        }
        $selected_day_session_data = mysqli_query($conn, $selected_day_session_query);
        $total_num_rows = mysqli_num_rows($selected_day_session_data);

        if($total_num_rows==0){
            $output = '<h4 class="text-danger text-center">No recipes found!</h4>';
        }else{

            $venue_query = "SELECT * FROM venue_info";
            $venue_data = mysqli_query($conn, $venue_query);
        
            $venue_array = [];
            while($venue_result = mysqli_fetch_assoc($venue_data)){
                $venue_array[$venue_result['venue_id']]= $venue_result['venue_name'];
            }

            $output.='<table class="table table-dark table-striped text-capitalize">
                    <thead>
                        <tr>
                        <th scope="col">S.NO</th>
                        <th scope="col">Venue</th>
                        <th scope="col">Day</th>
                        <th scope="col">Session</th>
                        <th scope="col">Recipe</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                <tbody>';
            $count=1;
            while($row = mysqli_fetch_assoc($selected_day_session_data)){
                $output.='<tr>
                <th scope="row" class="text-secondary">'.$count.'</th>
                <td>'.$venue_array[$row['venue']].'</td>
                <td class="text-info">'.$row['day_value'].'</td>
                <td class="text-warning">'.$row['session'].'</td>
                <td>
                    <div>
                        <img src="'.$row['recipe_image_path'].'" alt="'.$row['recipe_name'].'" class="rounded-circle" width="50px" height="auto"/>
                        <span class="text-bold text-info">'.$row['recipe_name'].'<span>
                    </div>
                </td>
                <td><form method="POST" action="remove-recipe.php">
                        <input type="text" value="'.$row['id'].'" name="selected-recipe" class="d-none" readonly />
                        <input type="submit" class="btn btn-danger" value="Remove" name="remove-recipe"/>
                    </form>
                </td>
                </tr>';
                $count++;
            }
            $output.="</tbody></table>";
        }
        $result->count = $total_num_rows;
        $result->data = $output;
    }else{
        $result->Error = "All feilds are mandatory!";
    }
    //echo($output);
    echo json_encode($result , JSON_HEX_QUOT | JSON_HEX_TAG);
?>
