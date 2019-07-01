<?php ob_start();?>
<?php include 'inc/header.php' ?>
<?php
$login =  Session::get("customerlogin");
if($login==TRUE){
header("Location: orderdetails.php");
ob_end_flush();
}
?>
<?php
    
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['register'])){
       
    $insertCustomer = $cmr->customerInsert($_POST); /// belong to the customer class
        
    }
    
?>
<?php
    
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login'])){
       
    $loginCustomer = $cmr->customerlogin($_POST); /// belong to the customer class
        
    }
    
?>
<script type="text/javascript">
        
            function getCountry(val) {
                    $.ajax({
                        
                    type: 'POST',
                     url: 'common.php',
                    data: 'cityId='+val,
                    success: function(data){
                            $("#areas").html(data);                 
                        }
                    });
            } 
</script>
<div class="container">
    <div class="row">
        <div class="col-md-4" style="border-right: 2px solid black">
                  <?php
               if(isset($loginCustomer)){
                   echo $loginCustomer;
               }
               ?>
            <form action="" method="post">  
                
                <p class="text-center font-weight-bold" style="font-style: italic; font-size:20px; ">Existing Customers</p>
                <div class="form-group">
                    
                    <input type="email" id="em" class="form-control"  placeholder="Enter email" name="c_email">
                </div>
                <div class="form-group">
                    
                    <input type="password" class="form-control" placeholder="Enter password" name="c_pass">
                </div>
                
                <button type="submit" class="btn btn-dark" name="login">Sign In</button>

            </form>
        </div>
        
        <div class="col-md-8" style="">
            
            <?php
               if(isset($insertCustomer)){
                   echo $insertCustomer;
               }
               ?>
            <form action="" method="post">
                <p class="text-center font-weight-bold" style="font-style: italic;font-size:20px; ">Register New Account</p>
                
                <div class="form-row">
                    <div class="form-group col-md-6">

                        <input type="text" class="form-control" name="c_name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6">

                        <input type="text" class="form-control" name="c_address" placeholder="Address">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">

                        
                        <select class="form-control" onChange="getCountry(this.value);" name="c_city">
                                <option>Select City</option>
                            <?php 
                              
                               $getCity = $cmr->getAllCity();
                               if($getCity){
                                   while ($result = $getCity->fetch_assoc()){
                            ?>
                            <option value="<?php echo $result['city_id'] ?>"><?php echo $result['city_name']; ?></option>
                               <?php }}?>
                                   
                            </select>
                     </div>
                    <div class="form-group col-md-6 ">                        
                        <select class="form-control" id="areas" name="c_area">
                                <option>Select Area</option>
                              
                        </select>
                    </div>                    
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">

                        <input type="text" class="form-control"name="c_zip" placeholder="Zip Code">
                    </div>
                    <div class="form-group col-md-6">

                        <input type="text" class="form-control" minlength="11" maxlength="11" name="c_phone" placeholder="Phone">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">

                        <input type="email" class="form-control" name="c_email" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">

                        <input type="password" class="form-control" name="c_pass" placeholder="Password">
                    </div>
                </div>


                
                <button type="submit" class="btn btn-dark" name="register">Create Account</button>
            </form>

        </div>

    </div>
    <br>
</div>
<?php include 'inc/footer.php' ?>
