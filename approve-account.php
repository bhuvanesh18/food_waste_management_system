<?php
    include_once("connection.php");
    error_reporting(0);
    session_start();
    if(isset($_POST['approve'])){
        $selected_user_email = $_POST['selectedUserEmail'];
        $current_user_email = $_SESSION['email'];
        if($selected_user_email!="" && $current_user_email!=""){

            $query = "SELECT is_active, is_blocked from users WHERE email = '$selected_user_email'";
            $data = mysqli_query($conn, $query);
            $result = mysqli_fetch_assoc($data);
            if($result['is_active']==0 || ($result['is_active']==1 && $result['is_blocked']==1)){
                $query = "UPDATE users SET is_active=1, is_blocked=0 WHERE email = '$selected_user_email' LIMIT 1";
                $data = mysqli_query($conn, $query);
                if($data){
                    $query = "INSERT INTO users_log_status (user_email, is_approved, action_by) VALUES ('$selected_user_email', 1, '$current_user_email')";
                    $data = mysqli_query($conn, $query);
                    if($data){
                        echo("<script>
                            alert('Account activated successfully!');
                            window.location='account-activations.php';
                        </script>");
                    }else{
                        echo("<script>
                            alert('Sorry internal server error occured!');
                            window.location='account-activations.php';
                        </script>");
                    }
                }else{
                    echo("<script>
                        alert('Error occured! Sorry account not activate!');
                        window.location='account-activations.php';
                    </script>");
                }
            }else{
                echo("<script>
                    alert('Account already activated by someone!');
                    window.location='account-activations.php';
                </script>");
            }
        }else{
            echo("<script>
                alert('All feilds required!');
                window.location='account-activations.php';
            </script>");
        }
    }else{
        echo("<script>
            alert('Something went wrong!');
            window.location='home.php';
        </script>");
    }
?>