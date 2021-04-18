<?php
    include_once('connection.php');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
// getting states
$(document).ready(function(){
    var GetURL = "getStates.php";
    $.get(GetURL, function(data, status){
      var JSONData = JSON.parse(data);
      if(JSONData.hasOwnProperty('Error')){
          alert(JSONData.Error);
      }else{
        if(JSONData.count==0){
            alert("No states available!");
        }else{
            var n=JSONData.data.length;
            var i=0;
            while(i<n){
                $('#college-state').append(`<option class="text-capitalize" value='${JSONData.data[i]}'>${JSONData.data[i]}</option>`);
                i++;
            }
        }
      }
  });
});
</script>
<script>
// getting cities
$(document).ready(function(){
    $('#college-state').change(function(){
        $('#college-city').empty();
        $('#college-city').append(`<option value="" selected>Choose city</option>`);
        var GetURL = "getCities.php?selected-state="+$("#college-state").val();
        $.get(GetURL, function(data, status){
        var JSONData = JSON.parse(data);
        if(JSONData.hasOwnProperty('Error')){
            alert(JSONData.Error);
        }else{
            if(JSONData.count==0){
                alert("No cities available!");
            }else{
                var n=JSONData.data.length;
                var i=0;
                while(i<n){
                    $('#college-city').append(`<option class="text-capitalize" value='${JSONData.data[i]}'>${JSONData.data[i]}</option>`);
                    i++;
                }
            }
        }
    });
    });
});
</script>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
    include_once('header.html');
?>
</head>
<body class="main-layout">
    <div class="container my-5">
        <h1 class="text-center display-6">Institution Registration</h1>
        <form class="row g-3 mx-5" method="POST" action="">
            <div class="col-md-6">
                <label for="college-name" class="form-label">Institution Name</label>
                <input type="text" class="form-control" id="college-name" name="college_name" placeholder="Enter your institution name here" required>
            </div>
            <div class="col-12">
                <label for="college-address" class="form-label">Address</label>
                <input type="text" class="form-control" id="college-address" name="college_address" placeholder="Enter your institution address here" required>
            </div>
            <div class="col-md-4">
                <label for="college-state" class="form-label">State</label>
                <select id="college-state" name="college_state" class="form-select" required>
                    <option value="" selected>Choose state</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="college-city" class="form-label">City</label>
                <select id="college-city" name="college_city" class="form-select" required>
                    <option value="" selected>Choose city</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="college-pincode" class="form-label">Pincode</label>
                <input type="number"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;" class="form-control" id="college-pincode" name="college_pincode" placeholder="Enter institution pincode" required>
            </div>
            <div class="col-md-6">
                <label for="contact-email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact-email" name="contact_email" placeholder="Enter institution contact email" required>
            </div>
            <div class="col-md-6">
                <label for="contact-number" class="form-label">Contact Number</label>
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" class="form-control" id="contact-number" name="contact_number" placeholder="Enter institution contact email" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" name="college_register">Register</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['college_register'])){
        $name = $_POST['college_name'];
        $address = $_POST['college_address'];
        $city = $_POST['college_city'];
        $state = $_POST['college_state'];
        $pincode = $_POST['college_pincode'];
        $email = $_POST['contact_email'];
        $phone = $_POST['contact_number'];
        echo("<script>alert('here')</script>");
        $query = "INSERT INTO institutions(institution_name,institution_address,institution_city,institution_state,institution_pincode,institution_email,institution_phone) values('$name','$address','$city','$state','$pincode','$email','$phone')";
        $data = mysqli_query($conn, $query);
        if($data){
            echo("<script>alert('Institution regitered successfully')</script>");
        }else{
            echo("<script>alert('Some problem occur')</script>");
        }
    }
?>