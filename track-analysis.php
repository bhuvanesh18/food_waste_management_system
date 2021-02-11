<?php
    include("connection.php");
    session_start();
    error_reporting(0);
    if(!$_SESSION['email']){
        header('location:index.php');
    }else{
?>
<?php

// days info 
$get_days_info_query = "SELECT day_id, day_value FROM days_info ORDER BY day_order ASC";
$get_days_info_data = mysqli_query($conn,$get_days_info_query);
$days_info_array = [];
while($get_days_info_result = mysqli_fetch_assoc($get_days_info_data)){
    $days_info_array[$get_days_info_result['day_id']] = ucfirst($get_days_info_result['day_value']);
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
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>  
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.min.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
        <h2 class="display-5">Track and Analysis</h2>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-link active" id="analysis-report-tab" data-bs-toggle="tab" href="#analysis-report" role="tab" aria-controls="analysis-report" aria-selected="true">Analysis report</a>
                <a class="nav-link" id="cook-items-analysis-report-tab" data-bs-toggle="tab" href="#cook-items-analysis-report" role="tab" aria-controls="cook-items-analysis-report" aria-selected="false">Analysis report</a>
            </div>
        </nav>
        <div class="tab-content mt-4" id="nav-tabContent">
            <!-- analysis report tab-->
            <div class="tab-pane fade show active" id="analysis-report" role="tabpanel" aria-labelledby="analysis-report-tab">
                <form class="row row-cols-lg-auto g-2 align-items-center" method="POST">
                    <?php
                        if($_SESSION['venue']=="ALL"){
                            ?>
                            <div class="col-12">
                                <select class="form-select text-capitalize" id="venue" name="analysis-report-venue">
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
                        <label for="analysis-report-starting-date">Starting date</label>
                        <input type="date" class="form-control" id="analysis-report-starting-date" name="analysis-report-starting-date" required/>
                    </div>
                    <div class="col-12">
                        <label for="analysis-report-ending-date">Ending date</label>
                        <input type="date" class="form-control" id="analysis-report-ending-date" name="analysis-report-ending-date" required/>
                    </div>
                    <div class="col-12">
                        <input type="submit" id="analysis-report-generate" name="analysis-report-generate" class="btn btn-primary" value="Generate" />
                    </div>
                </form>

                <?php
                    if(isset($_POST['analysis-report-generate'])){
                        $starting_date = $_POST['analysis-report-starting-date'];
                        $ending_date = $_POST['analysis-report-ending-date'];

                        if($_SESSION['venue']=="ALL"){
                            $selected_venue = $_POST['analysis-report-venue'];
                        }else{
                            $selected_venue = $_SESSION['venue'];
                        }

                        // food waste table query
                        $food_waste_query = "
                        SELECT days_info.day_id as day
                        ,IFNULL(breakfast_waste,0) as breakfast
                        ,IFNULL(lunch_waste,0) as lunch
                        ,IFNULL(snacks_waste,0) as snacks
                        ,IFNULL(dinner_waste,0) as dinner
                        FROM days_info LEFT OUTER JOIN (SELECT day_id
                        ,SUM(CASE WHEN session = 'breakfast' THEN weight END) AS 'breakfast_waste'
                        ,SUM(CASE WHEN session = 'lunch' THEN weight END) AS 'lunch_waste'
                        ,SUM(CASE WHEN session = 'snacks' THEN weight END) AS 'snacks_waste'
                        ,SUM(CASE WHEN session = 'dinner' THEN weight END) AS 'dinner_waste'
                        FROM food_wastes WHERE date BETWEEN '$starting_date' AND '$ending_date' AND venue='$selected_venue' AND waste_category='FOOD_WASTE' GROUP BY day_id) as food_waste_result_table ON food_waste_result_table.day_id = days_info.day_id WHERE is_available=1 ORDER BY day_order ASC
                        ";
                        $food_waste_data = mysqli_query($conn,$food_waste_query);

                        $food_waste_result_array = array();
                        $food_waste_total = 0;
                        while($row = mysqli_fetch_assoc($food_waste_data)){
                            $food_waste_result_array[$row['day']] = array('breakfast'=>$row['breakfast'], 'lunch'=>$row['lunch'], 'snacks'=>$row['snacks'], 'dinner'=>$row['dinner']);
                            $food_waste_total += $row['breakfast']+$row['lunch']+$row['snacks']+$row['dinner'];
                        }

                        // cook waste table query
                        $cook_waste_query = "
                        SELECT days_info.day_id as day
                        ,IFNULL(breakfast_waste,0) as breakfast
                        ,IFNULL(lunch_waste,0) as lunch
                        ,IFNULL(snacks_waste,0) as snacks
                        ,IFNULL(dinner_waste,0) as dinner
                        FROM days_info LEFT OUTER JOIN (SELECT day_id
                        ,SUM(CASE WHEN session = 'breakfast' THEN weight END) AS 'breakfast_waste'
                        ,SUM(CASE WHEN session = 'lunch' THEN weight END) AS 'lunch_waste'
                        ,SUM(CASE WHEN session = 'snacks' THEN weight END) AS 'snacks_waste'
                        ,SUM(CASE WHEN session = 'dinner' THEN weight END) AS 'dinner_waste'
                        FROM food_wastes WHERE date BETWEEN '$starting_date' AND '$ending_date' AND venue='$selected_venue' AND waste_category='COOK_WASTE' GROUP BY day_id) as food_waste_result_table ON food_waste_result_table.day_id = days_info.day_id WHERE is_available=1 ORDER BY day_order ASC
                        ";
                        $cook_waste_data = mysqli_query($conn,$cook_waste_query);

                        $cook_waste_result_array = array();
                        $cook_waste_total = 0;
                        while($row = mysqli_fetch_assoc($cook_waste_data)){
                            $cook_waste_result_array[$row['day']] = array('breakfast'=>$row['breakfast'], 'lunch'=>$row['lunch'], 'snacks'=>$row['snacks'], 'dinner'=>$row['dinner']);
                            $cook_waste_total += $row['breakfast']+$row['lunch']+$row['snacks']+$row['dinner'];
                        }

                        // cook item waste table query
                        $cook_item_waste_query = "
                        SELECT days_info.day_id as day
                        ,IFNULL(breakfast_waste,0) as breakfast
                        ,IFNULL(lunch_waste,0) as lunch
                        ,IFNULL(snacks_waste,0) as snacks
                        ,IFNULL(dinner_waste,0) as dinner
                        FROM days_info LEFT OUTER JOIN (SELECT day_id
                        ,SUM(CASE WHEN session = 'breakfast' THEN weight END) AS 'breakfast_waste'
                        ,SUM(CASE WHEN session = 'lunch' THEN weight END) AS 'lunch_waste'
                        ,SUM(CASE WHEN session = 'snacks' THEN weight END) AS 'snacks_waste'
                        ,SUM(CASE WHEN session = 'dinner' THEN weight END) AS 'dinner_waste'
                        FROM food_wastes WHERE date BETWEEN '$starting_date' AND '$ending_date' AND venue='$selected_venue' AND waste_category='COOK_ITEM_WASTE' GROUP BY day_id) as food_waste_result_table ON food_waste_result_table.day_id = days_info.day_id WHERE is_available=1 ORDER BY day_order ASC
                        ";
                        $cook_item_waste_data = mysqli_query($conn,$cook_item_waste_query);

                        $cook_item_waste_result_array = array();
                        $cook_item_waste_total = 0;
                        while($row = mysqli_fetch_assoc($cook_item_waste_data)){
                            $cook_item_waste_result_array[$row['day']] = array('breakfast'=>$row['breakfast'], 'lunch'=>$row['lunch'], 'snacks'=>$row['snacks'], 'dinner'=>$row['dinner']);
                            $cook_item_waste_total += $row['breakfast']+$row['lunch']+$row['snacks']+$row['dinner'];
                        }
                        
                        ?>
                        <div class="container mx-5">
                            <div class="container">
                                <div class="my-4">
                                    <div class="text-center">
                                        <p id="venue_info_for_export" class="display-6 text-capitalize">Venue: <?php echo($venue_array[$selected_venue]);?></p>
                                        <p id="report_dates_info_for_export" class="display-6"><?php echo(getDateFormat($starting_date)." to ".getDateFormat($ending_date));?></p>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-success text-left" id="exportButton" type="button">Export as PDF</button>
                                </div>
                                <div class="my-4">
                                    <div id="analysis_summary">
                                        <h1 class="display-6">Analysis Summary</h1>
                                        <table class="table table-dark table-striped text-capitalize text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S.No</th>
                                                    <th scope="col">Waste Info</th>
                                                    <th scope="col">Weight</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td>Food waste</td>
                                                    <td><?php echo($food_waste_total); ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>Cook waste</td>
                                                    <td><?php echo($cook_waste_total); ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">3</th>
                                                    <td>Cook item waste</td>
                                                    <td><?php echo($cook_item_waste_total); ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">4</th>
                                                    <td>Total waste</td>
                                                    <td><?php echo($food_waste_total+$cook_waste_total+$cook_item_waste_total); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- food waste table -->
                                <div class="my-4">
                                    <div id="food_waste_table">	
                                        <h1 class="display-6">Food waste</h1>
                                        <table class="table table-dark table-striped text-capitalize text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Breakfast</th>
                                                    <th scope="col">Lunch</th>
                                                    <th scope="col">Snacks</th>
                                                    <th scole="col">Dinner</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach ($food_waste_result_array as $day => $sessions) {
                                                    $day_waste_total = 0;
                                                    echo('<tr>
                                                        <th scope="row">'.$days_info_array[$day].'</th>
                                                        <td>'.$sessions["breakfast"].'</td>
                                                        <td>'.$sessions["lunch"].'</td>
                                                        <td>'.$sessions["snacks"].'</td>
                                                        <td>'.$sessions["dinner"].'</td>');
                                                    $day_waste_total = $sessions["breakfast"] + $sessions["lunch"] + $sessions["snacks"] + $sessions["dinner"];
                                                    echo('<td>'.$day_waste_total.'</td>
                                                    </tr>');
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="food_waste_chartContainer" style="height: 360px; width: 100%;"></div>
                                </div>

                                <!-- cook waste table -->
                                <div class="my-4">
                                    <div id="cook_waste_table">
                                        <h1 class="display-6">Cook waste</h1>
                                        <table class="table table-dark table-striped text-capitalize text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Breakfast</th>
                                                    <th scope="col">Lunch</th>
                                                    <th scope="col">Snacks</th>
                                                    <th scole="col">Dinner</th>
                                                    <th scole="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach ($cook_waste_result_array as $day => $sessions) {
                                                    $day_waste_total = 0;
                                                    echo('<tr>
                                                        <th scope="row">'.$days_info_array[$day].'</th>
                                                        <td>'.$sessions["breakfast"].'</td>
                                                        <td>'.$sessions["lunch"].'</td>
                                                        <td>'.$sessions["snacks"].'</td>
                                                        <td>'.$sessions["dinner"].'</td>');
                                                    $day_waste_total = $sessions["breakfast"] + $sessions["lunch"] + $sessions["snacks"] + $sessions["dinner"];
                                                    echo('<td>'.$day_waste_total.'</td>
                                                    </tr>');
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="cook_waste_chartContainer" style="height: 360px; width: 100%;"></div>
                                </div>
                                <!-- cook item waste table -->
                                <div class="my-4">
                                    <div id="cook_item_waste_table">
                                        <h1 class="display-6">Cook item waste</h1>
                                        <table class="table table-dark table-striped text-capitalize text-center">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Breakfast</th>
                                                    <th scope="col">Lunch</th>
                                                    <th scope="col">Snacks</th>
                                                    <th scole="col">Dinner</th>
                                                    <th scole="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach ($cook_item_waste_result_array as $day => $sessions) {
                                                    $day_waste_total = 0;
                                                    echo('<tr>
                                                        <th scope="row">'.$days_info_array[$day].'</th>
                                                        <td>'.$sessions["breakfast"].'</td>
                                                        <td>'.$sessions["lunch"].'</td>
                                                        <td>'.$sessions["snacks"].'</td>
                                                        <td>'.$sessions["dinner"].'</td>');
                                                    $day_waste_total = $sessions["breakfast"] + $sessions["lunch"] + $sessions["snacks"] + $sessions["dinner"];
                                                    echo('<td>'.$day_waste_total.'</td>
                                                    </tr>');
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="cook_item_waste_chartContainer" style="height: 360px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                        <script>
                                window.onload = function () {

                                // food waste chart
                                var food_waste_chart = new CanvasJS.Chart("food_waste_chartContainer", {
                                    animationEnabled: false,
                                    title:{
                                        text: "Food Waste Report"
                                    },	
                                    axisY: {
                                        title: "Waste Weights (Kg)",
                                        titleFontColor: "red",
                                        lineColor: "#555555",
                                        labelFontColor: "blue",
                                        tickColor: "#4F81BC"
                                    },	
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        cursor:"pointer",
                                        itemclick: toggleDataSeries
                                    },
                                    data: [{
                                        type: "column",
                                        name: "Breakfast",
                                        legendText: "Breakfast",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($food_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['breakfast'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Lunch",
                                        legendText: "Lunch",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($food_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['lunch'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Snacks",
                                        legendText: "Snacks",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($food_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['snacks'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Dinner",
                                        legendText: "Dinner",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($food_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['dinner'].' },');
                                        }
                                    ?>
                                        ]
                                    }]
                                });
                                food_waste_chart.render();

                                // cook waste chart
                                var cook_waste_chart = new CanvasJS.Chart("cook_waste_chartContainer", {
                                    animationEnabled: false,
                                    title:{
                                        text: "Cook Waste Report"
                                    },	
                                    axisY: {
                                        title: "Waste Weight (Kg)",
                                        titleFontColor: "red",
                                        lineColor: "#555555",
                                        labelFontColor: "blue",
                                        tickColor: "#4F81BC"
                                    },	
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        cursor:"pointer",
                                        itemclick: toggleDataSeries
                                    },
                                    data: [{
                                        type: "column",
                                        name: "Breakfast",
                                        legendText: "Breakfast",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['breakfast'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Lunch",
                                        legendText: "Lunch",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['lunch'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Snacks",
                                        legendText: "Snacks",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['snacks'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Dinner",
                                        legendText: "Dinner",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['dinner'].' },');
                                        }
                                    ?>
                                        ]
                                    }]
                                });
                                cook_waste_chart.render(); 

                                // cook item waste chart
                                var cook_item_waste_chart = new CanvasJS.Chart("cook_item_waste_chartContainer", {
                                    animationEnabled: false,
                                    title:{
                                        text: "Cook Item Waste Report"
                                    },	
                                    axisY: {
                                        title: "Waste Weight (Kg)",
                                        titleFontColor: "red",
                                        lineColor: "#555555",
                                        labelFontColor: "blue",
                                        tickColor: "#4F81BC"
                                    },	
                                    toolTip: {
                                        shared: true
                                    },
                                    legend: {
                                        cursor:"pointer",
                                        itemclick: toggleDataSeries
                                    },
                                    data: [{
                                        type: "column",
                                        name: "Breakfast",
                                        legendText: "Breakfast",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_item_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['breakfast'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Lunch",
                                        legendText: "Lunch",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_item_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['lunch'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Snacks",
                                        legendText: "Snacks",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_item_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['snacks'].' },');
                                        }
                                    ?>
                                        ]
                                    },
                                    {
                                        type: "column",
                                        name: "Dinner",
                                        legendText: "Dinner",
                                        showInLegend: true, 
                                        dataPoints:[
                                    <?php 
                                        foreach($cook_item_waste_result_array as $day=>$sessions){
                                        echo('{ label: "'.$days_info_array[$day].'", y: '.$sessions['dinner'].' },');
                                        }
                                    ?>
                                        ]
                                    }]
                                });
                                cook_item_waste_chart.render(); 

                                var food_waste_canvas = $("#food_waste_chartContainer .canvasjs-chart-canvas").get(0);
                                var food_waste_dataURL = food_waste_canvas.toDataURL();

                                var cook_waste_canvas = $("#cook_waste_chartContainer .canvasjs-chart-canvas").get(0);
                                var cook_waste_dataURL = cook_waste_canvas.toDataURL();

                                var cook_item_waste_canvas = $("#cook_item_waste_chartContainer .canvasjs-chart-canvas").get(0);
                                var cook_item_waste_dataURL = cook_item_waste_canvas.toDataURL();

                                var venue_info = $('#venue_info_for_export').text();
                                var date_info = $('#report_dates_info_for_export').text();
                                $("#exportButton").click(function(){
                                    
                                    var pdf = new jsPDF({ format: 'a4', orientation: 'portrait' });
                                    pdf.setFontSize(40);

                                    pdf.text("Analysis Report",58,40);
                                   
                                    pdf.text(venue_info,50,60);
                                    pdf.text(date_info,24,80);

                                    pdf.setFontSize(30);
                                    pdf.fromHTML($('#analysis_summary').html(),29,120,{ 'width': 180 });

                                    pdf.addPage();
                                    pdf.setPage(2);
                                    pdf.fromHTML($('#food_waste_table').html(),29,15,{ 'width': 180 });
                                    pdf.addImage(food_waste_dataURL, 'PNG', 15, 200, 180, 70);

                                    pdf.addPage();
                                    pdf.setPage(3);
                                    pdf.fromHTML($('#cook_waste_table').html(),29,15,{ 'width': 180 });
                                    pdf.addImage(cook_waste_dataURL, 'PNG', 15, 200, 180, 70);

                                    pdf.addPage();
                                    pdf.setPage(4);
                                    pdf.fromHTML($('#cook_item_waste_table').html(),29,15,{ 'width': 180 });
                                    pdf.addImage(cook_item_waste_dataURL, 'PNG', 15, 200, 180, 70);
                                    
                                    pdf.save("report.pdf");
                                });

                                function toggleDataSeries(e) {
                                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                        e.dataSeries.visible = false;
                                    }
                                    else {
                                        e.dataSeries.visible = true;
                                    }
                                    food_waste_chart.render();
                                    cook_waste_chart.render();
                                    cook_item_waste_chart.render();
                                }

                                }
                                </script>
                        <?php
                    }
                ?>
            </div>
            <!-- cook items analysis report tab-->
            <div class="tab-pane fade" id="cook-items-analysis-report" role="tabpanel" aria-labelledby="cook-items-analysis-report-tab">
                cook-items-analysis report
            </div>
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
}// end of else
?>
<?php 
    // utility functions
    function getDateFormat($date){
        $date = explode('-',$date);
        return $date[2]."-".$date[1]."-".$date[0];
    }
?>
<?php
/*

SELECT day,session,venue, recipe_name,weight, IF(is_active=1,'In Use','Not In Use') as is_in_use FROM recipes
 INNER JOIN (
    SELECT cook_item_waste.recipe_id, SUM(cook_item_waste_fetched_table.weight) as weight FROM cook_item_waste
     INNER JOIN (
         SELECT * FROM food_wastes WHERE date BETWEEN '2021-01-01' AND '2021-02-09' AND waste_category='COOK_ITEM_WASTE' AND venue='BOYS_DINING'
        ) as cook_item_waste_fetched_table ON cook_item_waste_fetched_table.id = cook_item_waste.food_waste_id
         GROUP BY cook_item_waste.recipe_id HAVING SUM(cook_item_waste_fetched_table.weight) >= 0
    ) as cook_item_waste_fetched_table_with_weight ON cook_item_waste_fetched_table_with_weight.recipe_id = recipes.id

*/

?>