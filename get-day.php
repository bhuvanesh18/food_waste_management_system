<?php
    include("connection.php");
    error_reporting(0);
    $selected_day_order = $_GET['day-value'];

    if($selected_day_order==0){
        $selected_day_order=7;
    }

    $result = new STDClass();

    $query = "SELECT day_id, day_value from days_info WHERE day_order = '$selected_day_order' AND is_available=1";
    $data = mysqli_query($conn, $query);
    if($data){
        $count = mysqli_num_rows($data);
        if($count==0){
            $result->count=0;
        }else{
            $row = mysqli_fetch_assoc($data);
            $result->count = $count;
            $result->data->day_id = $row['day_id'];
            $result->data->day_name = $row['day_value'];
        }
    }else{
        $result->Error="Internal server error occured!";
    }
    echo json_encode($result);

?>