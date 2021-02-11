<?php
include_once('connection.php');
if(isset($_POST['register-submit'])){
    $useremail = $_POST['register-email'];
    $username = $_POST['register-name'];
    $userpassword = $_POST['register-password'];
    $userrole = $_POST['register-role'];

    if($userrole == "ADMIN"){
        $uservenue = "ALL";
    }else{
        $uservenue = $_POST['register-venue'];
    }

    if($useremail!="" && $username!="" && $userpassword!="" && $userrole!="" && $uservenue!=""){
        $options = [
            'salt' => "This#Is#My#Hashing#Salt!", 
            'cost' => 10
        ];
        $hashedpassword = password_hash($userpassword, PASSWORD_DEFAULT, $options);
        if($hashedpassword){
            $query = "SELECT * FROM users WHERE email = '$useremail' LIMIT 1";
            $data = mysqli_query($conn, $query);
            if(mysqli_num_rows($data)==0){
                $query = "INSERT INTO users (email, name, password, role, venue) VALUES ('$useremail', '$username', '$hashedpassword', '$userrole', '$uservenue')";
                $data = mysqli_query($conn, $query);
                if($data){
                    echo("<script>
                            alert('Registeration successfull! Wait for admin approval!');
                            window.location='index.php';
                        </script>");
                }else{
                    echo("<script>
                            alert('Internal server error! Try again later!');
                            window.location='index.php';
                        </script>");
                }
            }else{
                echo("<script>
                        alert('User already exists!');
                        window.location='index.php';
                    </script>");
            }    
        }else{
            echo("<script>
                    alert('Error occurs in hashing user password!');
                    window.location='index.php';
                </script>");
        }
    }else{
        echo("<script>
            alert('All feilds are required!');
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