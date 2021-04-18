<?php
include("connection.php");
error_reporting(0);

$result = new STDClass();

$states_query = "SELECT DISTINCT(city_state) as state_name FROM cities ORDER BY city_state";
$states_data = mysqli_query($conn, $states_query);
$total_num_rows = mysqli_num_rows($states_data);
$result->count = $total_num_rows;
if($total_num_rows>0){
    $states = [];
    $i=0;
    while($row = mysqli_fetch_assoc($states_data)){
        $states[$i] = $row['state_name'];
        $i++;
    }
    $result->data = $states;
}
echo json_encode($result);
?>