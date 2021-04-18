<?php
include("connection.php");
error_reporting(0);

$selected_state = $_GET['selected-state'];
$result = new STDClass();

$cities_query = "SELECT city_name FROM cities WHERE city_state = '$selected_state' ORDER BY city_name";
$cities_data = mysqli_query($conn, $cities_query);
$total_num_rows = mysqli_num_rows($cities_data);
$result->count = $total_num_rows;
if($total_num_rows>0){
    $cities = [];
    $i=0;
    while($row = mysqli_fetch_assoc($cities_data)){
        $cities[$i] = $row['city_name'];
        $i++;
    }
    $result->data = $cities;
}
echo json_encode($result);
?>