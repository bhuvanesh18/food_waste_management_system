<?php
    include("connection.php");
    error_reporting(0);
    $daySelected = $_GET['day-selected'];

    $result = new STDClass();

    $query = "SELECT session_name from days_session_info WHERE day_id = '$daySelected' AND is_available=1";
    $data = mysqli_query($conn, $query);
    if($data){
        $count = mysqli_num_rows($data);
        if($count==0){
            $result->count=0;
        }else{
            $i=0;
            $available_sessions = [];
            
            $session_max_items_query = "SELECT * FROM session_info ORDER BY session_order";
            $session_max_items_data = mysqli_query($conn,$session_max_items_query);
            $session_max_items_array = [];
            while($row = mysqli_fetch_assoc($session_max_items_data)){
                $session_max_items_array[$row['session']] = $row['max_recipe_count'];
            }

            while($fetched_sessions = mysqli_fetch_assoc($data)){
                $q = "SELECT count(*) as already_session_recipe from recipes WHERE day='$daySelected' AND session='$fetched_sessions[session_name]' AND is_active=1";
                $d = mysqli_query($conn, $q);
                $r = mysqli_fetch_assoc($d);
                if($r['already_session_recipe'] < $session_max_items_array[$fetched_sessions['session_name']]){
                    $available_sessions[$i]=$fetched_sessions['session_name'];
                    $i++;
                }
            }
            $result->count = $i;
            $result->data = $available_sessions;
        }
    }else{
        $result->Error="Internal server error occured!";
    }
    echo json_encode($result);

?>