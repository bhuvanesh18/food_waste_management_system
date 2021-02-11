<?php
    include_once("connection.php");
    error_reporting(0);
    session_start();
    if(isset($_POST['waste-entry-submit']) && $_SESSION['email']){
        $user = $_SESSION['email'];

        if($_SESSION['venue']=="ALL"){
            $selected_venue = $_POST['venue'];
        }else{
            $selected_venue = $_SESSION['venue'];
        }

        $selected_date = $_POST['date'];
        $selected_day = $_POST['day'];
        $waste_category = $_POST['category'];
        $selected_session = $_POST['session'];
        $waste_weight = $_POST['weight'];

        if($waste_category == "COOK_ITEM_WASTE"){
            $selected_item_id = $_POST['recipe'];

            if($selected_item_id!="" && $selected_day!="" && $selected_session!="" && $selected_venue!="" && $selected_date!="" && $waste_weight!="" && $user!=""){
                $query = "SELECT IF(COUNT(recipe_id)=1,'YES','NO') as is_already_exist FROM cook_item_waste INNER JOIN (SELECT id FROM food_wastes WHERE date='$selected_date' AND day_id='$selected_day' AND session='$selected_session' AND venue='$selected_venue' AND waste_category='$waste_category') as cook_item_waste_on_date_session_venue ON cook_item_waste_on_date_session_venue.id = cook_item_waste.food_waste_id WHERE recipe_id = '$selected_item_id'";
                $data = mysqli_query($conn, $query);
                $result = mysqli_fetch_assoc($data);
                if($result['is_already_exist']=="NO"){
                if(is_numeric($waste_weight)){

                    $waste_weight = number_format(floor($waste_weight*100)/100,2, '.', '');

                    $query = "INSERT INTO food_wastes(venue, date, day_id, session, waste_category, weight, entry_by) 
                    VALUES('$selected_venue','$selected_date','$selected_day','$selected_session', '$waste_category','$waste_weight','$user')";
                    $data = mysqli_query($conn, $query);
                    if($data){
                        $waste_id = mysqli_insert_id($conn);

                        $query = "INSERT INTO cook_item_waste(food_waste_id,recipe_id) VALUES('$waste_id','$selected_item_id')";
                        $data = mysqli_query($conn,$query);
                        if($data){
                            echo("<script>
                                alert('Entry taken successfully!');
                                window.location='food-waste.php';
                            </script>");
                        }else{
                            echo("<script>
                                alert('Internal server error occured! Conduct technical team');
                                window.location='food-waste.php';
                            </script>");
                        }
                    }else{
                        echo("<script>
                            alert('Internal server error occured!');
                            window.location='food-waste.php';
                        </script>");
                    }
                }else{
                        echo("<script>
                        alert('Weight must be number!');
                        window.location='food-waste.php';
                    </script>");
                }
              }else{
                echo("<script>
                    alert('Entry already taken for the selected cook item!');
                    window.location='food-waste.php';
                </script>");
              }
            }else{
                echo("<script>
                    alert('All feilds required!');
                    window.location='food-waste.php';
                </script>");
            }
        }else{

            if($selected_day!="" && $selected_session!="" && $selected_venue!="" && $selected_date!="" && $waste_weight!="" && $user!=""){
                $query = "SELECT * FROM food_wastes WHERE date='$selected_date' AND day_id='$selected_day' AND session='$selected_session' AND venue='$selected_venue' AND waste_category='$waste_category'";
                $data = mysqli_query($conn, $query);
                if(mysqli_num_rows($data)==0){
                    if(is_numeric($waste_weight)){

                        $waste_weight = number_format(floor($waste_weight*100)/100,2, '.', '');

                        $query = "INSERT INTO food_wastes(venue, date, day_id, session, waste_category, weight, entry_by) 
                        VALUES('$selected_venue','$selected_date','$selected_day','$selected_session', '$waste_category','$waste_weight','$user')";
                        $data = mysqli_query($conn, $query);
                        if($data){
                            echo("<script>
                                alert('Entry taken successfully!');
                                window.location='food-waste.php';
                            </script>");
                        }else{
                            echo("<script>
                                alert('Internal server error occured!');
                                window.location='food-waste.php';
                            </script>");
                        }
                    }else{
                            echo("<script>
                            alert('Weight must be number!');
                            window.location='food-waste.php';
                        </script>");
                    }
            }else{
                    echo("<script>
                    alert('Entry already taken for the selected day and session in the selected venue. If you want to change, you can edit!');
                    window.location='food-waste.php';
                </script>");
            }
            }else{
                    echo("<script>
                        alert('All feilds required!');
                        window.location='food-waste.php';
                    </script>");
            }
    } // end of else(category!="COOK_ITEM_WASTE)
    }else{
        echo("<script>
            alert('Something went wrong!');
            window.location='home.php';
        </script>");
    }
?>