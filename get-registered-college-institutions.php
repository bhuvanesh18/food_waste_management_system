<?php
include("connection.php");
error_reporting(0);

$result = new STDClass();

$institutions_query = "SELECT institution_id, institution_name FROM institutions ORDER BY institution_name";
$institutions_data = mysqli_query($conn, $institutions_query);
$total_num_rows = mysqli_num_rows($institutions_data);
$result->count = $total_num_rows;
if($total_num_rows>0){
    $institutions_name = [];
    $institutions_id = [];
    $i=0;
    while($row = mysqli_fetch_assoc($institutions_data)){
        $institutions_id[$i] = $row['institution_id'];
        $institutions_name[$i] = $row['institution_name'];
        $i++;
    }
    $result->ids = $institutions_id;
    $result->names = $institutions_name;
}
echo json_encode($result);
?>