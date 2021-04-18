<?php
    include_once("connection.php");
    error_reporting(0);
    session_start();
    if(isset($_POST['add-recipe']) && $_SESSION['email']){
        $user = $_SESSION['email'];

        if($_SESSION['venue']=="ALL"){
            $selected_venue = $_POST['venue'];
        }else{
            $selected_venue = $_SESSION['venue'];
        }

        $selected_day = $_POST['day'];
        $selected_session = $_POST['day-session'];
        $recipe_name = $_POST['recipe-name'];
        $recipe_image = $_FILES['recipe-image'];
        $institution = $_SESSION['institution_id'];

        if($selected_day!="" && $selected_session!="" && $recipe_name!="" && $recipe_image!="" && $selected_venue!=""){
            $fileName = $_FILES['recipe-image']['name'];
            $fileTmpname = $_FILES['recipe-image']['tmp_name'];
            $fileSize = $_FILES['recipe-image']['size'];
            $fileError = $_FILES['recipe-image']['error'];
            $fileType = $_FILES['recipe-image']['type'];
            
            $fileExt = explode('.',$fileName);
            $fileActualExt = strtolower(end($fileExt));
            
            $allowed  = array('jpg','jpeg','png');

            if(in_array($fileActualExt,$allowed)){
                if($fileError===0){
                    if($fileSize < 1000000){
                        $fileNameNew = uniqid('',true).".".$fileActualExt;
                        $fileDestination = 'uploads/'.$fileNameNew;
                        move_uploaded_file($fileTmpname,$fileDestination);
                        $query = "SELECT max_recipe_count FROM session_info WHERE session='$selected_session'";
                        $data = mysqli_query($conn, $query);
                        $result = mysqli_fetch_assoc($data);

                        $q = "SELECT COUNT(*) as already_available_recipe_count FROM recipes WHERE day='$selected_day' AND session='$selected_session' AND venue='$selected_venue' AND is_active=1";
                        $d = mysqli_query($conn, $q);
                        $r = mysqli_fetch_assoc($d);

                        if($result['max_recipe_count'] > $r['already_available_recipe_count']){
                            $query = "INSERT INTO recipes(day,session,recipe_name,recipe_image_path,venue,institution_id) VALUES ('$selected_day','$selected_session','$recipe_name','$fileDestination','$selected_venue','$institution')";
                            $data = mysqli_query($conn, $query);
                            if($data){
                                // it gives last inserted id
                                $added_recipe_id = mysqli_insert_id($conn);
                                $query = "INSERT INTO recipes_log_status(recipe_id, is_created, action_by) VALUES('$added_recipe_id',1,'$user')";
                                $data = mysqli_query($conn, $query);
                                if($data){
                                    echo("<script>
                                        alert('Recipe item added successfully');
                                        window.location='update-recipes.php';
                                    </script>");
                                }else{
                                    echo("<script>
                                        alert('Internal server error occured!');
                                        window.location='update-recipes.php';
                                    </script>");
                                }
                            }else{
                                echo("<script>
                                    alert('Internal server error occured! Try again later');
                                    window.location='update-recipes.php';
                                </script>");
                            }
                        }else{
                            echo("<script>
                                    alert('Sorry recipes maximum count reached in the selected session of the day!');
                                    window.location='update-recipes.php';
                                </script>");
                        }
                    }else{
                        echo("<script>
                                alert('Image size is to big!');
                                window.location='update-recipes.php';
                            </script>");
                    }
                }else{
                    echo("<script>
                            alert('Error occurred while uploading! Try again later!');
                            window.location='update-recipes.php';
                        </script>");
                }
            }else{
                echo("<script>
                        alert('This type of file is not allowed to upload!');
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