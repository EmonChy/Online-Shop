<?php
ob_start();
?>
<?php include 'inc/header.php' ;
?>
<?php
$login = Session::get("customerlogin");
if($login==FALSE){
header("Location:login.php");}?>
<?php
// order product of an user
if(isset($_GET['orderid']) && $_GET['orderid']=='order'){
// customer id from tbl_customer table    
$cmrId = Session::get("customerId");
$insertOrder = $ct->orderProduct($cmrId);
$deldata     = $ct->deleteCustomerCart();
header("Location: success.php");
ob_end_flush();
}
?>

<style type="text/css">
    .tbl{
        width : 50%; 
        border: 2px solid black;
        float:right;
    }
    .tbl tr td{
        padding: 3px;
    }
</style>
    <div class="container">
        <div class="row">
            
            <div class="col-md-6">
                
                    <table class="table table-striped">
                    <thead class="bg-success">
                        <tr class="text-white text-center font-weight-bold ">
                            <th>No</th>
                            <th>Product</th>                            
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>                            
                        </tr>
                    </thead>                            
                    <tbody class=""> 
                            <?php
                            $getPro = $ct->getCartProduct();
                            // product add in cart using user session id 
                            if($getPro){
                                $i   = 0;
                                $sum = 0;
                                $qty = 0;

                                while($result = $getPro->fetch_assoc()){
                                    $i++;                                    
                                    ?>
                                <tr class="text-center">
                                    <td style="padding-top: 30px"><?php echo $i;?></td>
                                    <td style="padding-top: 30px"><?php echo $result['productName'];?></td>
                                    <td style="padding-top: 30px"><?php echo '$'.$result['price'];?></td>
                                    <td style="padding-top: 30px"><?php echo $result['quantity'];?></td>
                                    <td style="padding-top: 30px "><?php
                                        $total = $result['price'] * $result['quantity'];
                                        echo '$'.$total;
                                        ?></td>
                                </tr>
                                <?php
                                $qty = $qty + $result['quantity'];
                                $sum = $sum + $total;
                                ?>
                            <?php } }?>                        
                    </tbody>
                </table>
                <table class="tbl table-striped">
                    <tr>
                        <th class="text-right">Sub Total :</th>
                        <td><?php echo '$'.$sum;?></td>
                    </tr>
                    <tr>
                        <th class="text-right">VAT(10%) :</th>
                        <td>
                            <?php
                            $vat = $sum * 0.1;
                            echo $vat;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">Grand Total :</th>
                        <td>
                            <?php                                
                            $total_sum = $sum + $vat;                                
                            echo '$'.$total_sum;
                            ?>
                        </td>
                    </tr>
                     <tr>
                        <th class="text-right">Quantity :</th>
                        <td><?php echo $qty;?></td>
                    </tr>
                </table>
                
            </div>
            
            <div class="col-md-6">
                <?php
                    $id = Session::get("customerId");
                    $getCustomerData = $cmr->customerData($id);
                    if($getCustomerData){
                        while($result = $getCustomerData->fetch_assoc()){                    
                ?>                
            <table class="table table-striped table-condensed table-bordered">
                                    <thead>
                                        <tr class="btn-info text-center">
                                            <td colspan="2"><span style="font-family: cursive;font-weight: bold; font-size: 20px;">Information</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-right"><b>Name :</b></td>
                                            <td><b><?php echo $result['c_name'];?></b></td>
                                         
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Address :</b></td>
                                            <td><b><?php echo $result['c_address'];?></b></td>
                                         
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>City :</b></td>
                                            <td><b><?php echo $result['city_name'];?></b></td>
           
                                        </tr> 
                                        <tr>
                                            <td class="text-right"><b>Area :</b></td>
                                            <td><b><?php echo $result['area_name'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Zip :</b></td>
                                            <td><b><?php echo $result['c_zip'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Phone :</b></td>
                                            <td><b><?php echo $result['c_phone'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Email :</b></td>
                                            <td><b><?php echo $result['c_email'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right"><a class="btn btn-primary" href="editProfile.php">Update Details</a></td>
                                        </tr>                                          
                                    </tbody>
                    </table>
                    <?php } } ?>
            </div>
            
        </div>
        <div class="text-center">
               <a href="?orderid=order" style="margin-top: 15px" class="btn btn-danger">Order</a>
               <a style="margin-top: 15px;color: white" class="btn btn-info" onClick="window.open('invoice.php','SearchTip','width=700,height=630,resizable=yes,scrollbars=yes')">Download Invoice</a>
        </div>
        <br>
</div>
<?php include 'inc/footer.php' ;



