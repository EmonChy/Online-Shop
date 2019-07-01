<?php
 ob_start();?>
<?php include 'inc/header.php' ;?>
<?php
$login = Session::get("customerlogin");
if($login==FALSE){
header("Location:login.php");
ob_end_flush();
}
?>
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-6 offset-md-3" style="border: 1px solid black">
                
                <h3 class="text-center text-success font-weight-bold" style="margin-top: 15px;">Success</h3>
                <hr class="btn-primary">
                <?php
                // customer id from tbl_customer table
                $customerid  = Session::get("customerId"); 
                $amount = $ct->payableAmount($customerid);         
                if($amount){
                       $sum = 0;                     
                        while($result=$amount->fetch_assoc()){
                        $price = $result['price'];
                        $sum   = $sum+$price;
                   }
                ?>               
                <p>Total Payable Account(Including Vat) :
                    <?php
                    $vat   = $sum*0.1;
                    $total = $sum+$vat;
                    echo '$'.$total;}                 
                    ?>
                </p>
                <p>Thanks for purchase.Receive your order successfully.We will contact you ASAP
                    with delivery details.Here is your order details...<a href="orderdetails.php">
                    Visit Here..</a></p>                       
                <div class="text-center">
                <a href="cart.php" style="margin-top: 40px" class="btn btn-dark">Previous</a>
               </div>
                <br>
        </div>        
    </div>
    <br>             
</div>
<?php include 'inc/footer.php' ;


