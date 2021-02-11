<?php
    include_once("connection.php");
    error_reporting(0);
    session_start();
    if(isset($_POST['remove-recipe'])){
        $selected_recipe = $_POST['selected-recipe'];
        $current_user_email = $_SESSION['email'];
        if($selected_recipe!="" && $current_user_email!=""){
            $query = "SELECT is_active from recipes WHERE id = '$selected_recipe'";
            $data = mysqli_query($conn, $query);
            $result = mysqli_fetch_assoc($data);
            if($result['is_active']==1){
                $query = "UPDATE recipes SET is_active=0 WHERE id = '$selected_recipe' LIMIT 1";
                $data = mysqli_query($conn, $query);
                if($data){
                    $query = "INSERT INTO recipes_log_status (recipe_id, is_created, action_by) VALUES ('$selected_recipe',0, '$current_user_email')";
                    $data = mysqli_query($conn, $query);
                    if($data){
                        echo("<script>
                            alert('Recipe removed successfully!');
                            window.location='update-recipes.php';
                        </script>");
                    }else{
                        echo("<script>
                            alert('Sorry internal server error occured!');
                            window.location='update-recipes.php';
                        </script>");
                    }
                }else{
                    echo("<script>
                        alert('Error occured! Sorry recipe not removed!');
                        window.location='update-recipes.php';
                    </script>");
                }
            }else{
                echo("<script>
                    alert('Recipe already removed by someone!');
                    window.location='update-recipes.php';
                </script>");
            }
        }else{
            echo("<script>
                alert('All feilds required!');
                window.location='update-recipes.php';
            </script>");
        }
    }else{
        echo("<script>
            alert('Something went wrong!');
            window.location='home.php';
        </script>");
    }
?>