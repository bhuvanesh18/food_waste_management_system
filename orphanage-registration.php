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
                $('#orphanage-state').append(`<option class="text-capitalize" value='${JSONData.data[i]}'>${JSONData.data[i]}</option>`);
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
    $('#orphanage-state').change(function(){
        $('#orphanage-city').empty();
        $('#orphanage-city').append(`<option value="" selected>Choose city</option>`);
        var GetURL = "getCities.php?selected-state="+$("#orphanage-state").val();
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
                    $('#orphanage-city').append(`<option class="text-capitalize" value='${JSONData.data[i]}'>${JSONData.data[i]}</option>`);
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
        <h1 class="text-center display-6">Orphanage Registration</h1>
        <form class="row g-3 mx-5" method="POST" action="">
            <div class="col-md-6">
                <label for="orphanage-name" class="form-label">Orphanage Name</label>
                <input type="text" class="form-control" id="orphanage-name" name="orphanage_name" placeholder="Enter your Orphanage name here" required>
            </div>
            <div class="col-12">
                <label for="orphanage-address" class="form-label">Address</label>
                <input type="text" class="form-control" id="orphanage-address" name="orphanage_address" placeholder="Enter your Orphanage address here" required>
            </div>
            <div class="col-md-4">
                <label for="orphanage-state" class="form-label">State</label>
                <select id="orphanage-state" name="orphanage_state" class="form-select" required>
                    <option value="" selected>Choose state</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="orphanage-city" class="form-label">City</label>
                <select id="orphanage-city" name="orphanage_city" class="form-select" required>
                    <option value="" selected>Choose city</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="orphanage-pincode" class="form-label">Pincode</label>
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==6) return false;" class="form-control" id="orphanage-pincode" name="orphanage_pincode" placeholder="Enter Orphanage pincode" required>
            </div>
            <div class="col-md-6">
                <label for="contact-email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact-email" name="contact_email" placeholder="Enter Orphanage contact email" required>
            </div>
            <div class="col-md-6">
                <label for="contact-number" class="form-label">Contact Number</label>
                <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;" class="form-control" id="contact-number" name="contact_number" placeholder="Enter Orphanage contact email" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" name="orphanage_register">Register</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
    if(isset($_POST['orphanage_register'])){
        $name = $_POST['orphanage_name'];
        $address = $_POST['orphanage_address'];
        $city = $_POST['orphanage_city'];
        $state = $_POST['orphanage_state'];
        $pincode = $_POST['orphanage_pincode'];
        $email = $_POST['contact_email'];
        $phone = $_POST['contact_number'];
        
        $query = "INSERT INTO orphanages(orphanage_name,orphanage_address,orphanage_city,orphanage_state,orphanage_pincode,orphanage_email,orphanage_phone) values('$name','$address','$city','$state','$pincode','$email','$phone')";
        $data = mysqli_query($conn, $query);
        if($data){
            echo("<script>alert('orphanage regitered successfully')</script>");
        }else{
            echo("<script>alert('Some problem occur')</script>");
        }
    }
?>