<?php
    include_once('connection.php');

    if(isset($_POST['login-submit'])){
        $useremail = $_POST['login-email'];
        $userpassword = $_POST['login-password'];
        $query = "SELECT * FROM users WHERE email='$useremail' LIMIT 1";
        $data = mysqli_query($conn,$query);
        if(mysqli_num_rows($data)==1){
            $result = mysqli_fetch_assoc($data);
            if(password_verify($userpassword,$result['password'])){
                if($result['is_active']==1){
                    if($result['is_blocked']==0){
                        session_start();
                        $_SESSION['email']=$result['email'];
                        $_SESSION['name']=$result['name'];
                        $_SESSION['role']=$result['role'];
                        $_SESSION['venue']=$result['venue'];
                        $_SESSION['is_active']=$result['is_active'];
                        $_SESSION['is_blocked']=$result['is_blocked'];
                        $_SESSION['institution_id']=$result['institution_id'];

                        $q = "SELECT institution_name FROM institutions WHERE institution_id = '$_SESSION[institution_id]'";
                        $d = mysqli_query($conn, $q);
                        $r = mysqli_fetch_assoc($d);
                        $_SESSION['institution_name'] = $r['institution_name'];

                        header("location:home.php");
                    }else{
                        echo("<script>
                            alert('Your account is blocked by admin!');
                            window.location='index.php';
                        </script>");
                    }
                }else{
                    echo("<script>
                        alert('Your account not yet activated!');
                        window.location='index.php';
                    </script>"); 
                }
            }else{
                echo("<script>
                        alert('Incorrect password!');
                        window.location='index.php';
                    </script>");
            }
        }else{
            echo("<script>
                    alert('User does not exists!');
                    window.location='index.php';
                </script>");
        }
    }else{
        echo("<script>
                alert('Something went wrong!');
                window.location='index.php';
            </script>");
    }

?>