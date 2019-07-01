<?php
ob_start();
?>
<?php include 'inc/header.php' ;
?>
<?php
$login = Session::get("customerlogin");
if($login==FALSE){
header("Location:login.php");
ob_end_flush();
//echo "<script>window.location = 'login.php';</script>";
}
?>
<div class="container">
    <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3 class="text-center text-success font-weight-bold" style="margin-top: 25px;">Choose Payment Option</h3>
                <hr class="btn-primary">
            </div>
    </div>  
    <div class="row">
        <div class="col-md-6 offset-md-3 text-center" style="margin-top: 30px;">
                <a href="paymentoffline.php" class="btn btn-primary font-weight-bold" style="margin-left:">Offline Payment</a>
                <a href="paymentonline.php" class="btn btn-danger font-weight-bold">Online Payment</a>
        </div>
    </div>    
        <div class="text-center">
           <a href="cart.php" style="margin-top: 40px" class="btn btn-dark">Previous</a>
        </div>
    <br>           
</div>
<?php include 'inc/footer.php';


