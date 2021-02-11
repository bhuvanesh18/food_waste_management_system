<?php
    include("connection.php");
    error_reporting(0);
    session_start();
    $day = $_GET['day-selected'];
    $session = $_GET['session-selected']; 
    $venue = $_GET['venue-selected'];

    $result = new STDClass();

    $selected_day_session_query = "SELECT fetched_recipe_table.*, day_value FROM days_info INNER JOIN (SELECT id, day, session, recipe_name, recipe_image_path, venue FROM recipes WHERE day='$day' AND session='$session' AND venue='$venue' AND is_active = 1 ORDER BY id ASC) as fetched_recipe_table ON fetched_recipe_table.day = days_info.day_id";
    $selected_day_session_data = mysqli_query($conn, $selected_day_session_query);
    $total_num_rows = mysqli_num_rows($selected_day_session_data);

    if($total_num_rows!=0){
        $recipes_id = [];
        $recipes_name = [];
        $i=0;
        while($row = mysqli_fetch_assoc($selected_day_session_data)){
            $recipes_id[$i] = $row['id']; 
            $recipes_name[$i] = $row['recipe_name'];
            $i++;
        }
        $result->ids = $recipes_id;
        $result->names = $recipes_name;
    }
    $result->count = $total_num_rows;

    echo json_encode($result);
?>
