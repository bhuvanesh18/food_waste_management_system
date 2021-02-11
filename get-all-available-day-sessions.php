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
            while($fetched_sessions = mysqli_fetch_assoc($data)){
                $available_sessions[$i] = $fetched_sessions['session_name'];
                $i++;
            }
            $result->count = $count;
            $result->data = $available_sessions;
        }
    }else{
        $result->Error="Internal server error occured!";
    }
    echo json_encode($result);

?>