<?php include 'inc/header.php' ;
?>
<?php
$login = Session::get("customerlogin");
if($login==FALSE){
header("Location:login.php");}
//when product shifted,user will confirmed it
if(isset($_GET['confirmId'])){
    $confirmId = $_GET['confirmId'];
    //$price = $_GET['prc'];
    //$date  = $_GET['date']; 
    $confirm   = $ct->productshiftConfirm($confirmId);
}
?>
<div class="main">
    <div class="container">
        <div class="row">
          <div class="text-success font-weight-bold" style="font-size: 25px;">Your Ordered Details</div>

            <table class="table table-striped">
                
                    <thead class="bg-info">
                        <tr class="text-white text-center font-weight-bold ">
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>                            
                    <tbody class=""> 
                            <?php
                            // customer id from tbl_customer table
                            $customerid  = Session::get("customerId");
                            $getOrder = $ct->getOrderProduct($customerid);
                            // product details fetch from order table by customer id 
                            if($getOrder){
                                $i   = 0;
                                while($result = $getOrder->fetch_assoc()){
                                    $i++;                                    
                                    ?>
                                <tr class="text-center">
                                    <td style="padding-top: 30px"><?php echo $i;?></td>
                                    <td style="padding-top: 30px"><?php echo $result['productName'];?></td>
                                    <td><img src="admin/<?php echo $result['image'];?>" height="70" width="90" alt=""/></td>
                                    <td style="padding-top: 30px"><?php echo $result['quantity'];?></td>
                                    <td style="padding-top: 30px"><?php echo '$'.$result['price'];?></td>
                                    <td style="padding-top: 30px"><?php echo $fm->formatDate($result['date']);?></td>
                                    <td style="padding-top: 30px"><?php 
                                    if($result['status']==0){
                                        echo 'Pending';
                                    }elseif($result['status']==1){
                                         echo 'Shifted';
                                    }else{
                                        echo 'Confirm';
                                    }?>
                                    </td>
                                    <?php if($result['status']==1){?>
                                    <td style="padding-top: 30px"> <a href="?confirmId=<?php echo $result['orderId'];?>">Shifted</a></td>
                                    <?php }elseif($result['status']==2){?>
                                    <td style="padding-top: 30px">Ok</td>
                                    <?php }elseif($result['status']==0){?>
                                    <td style="padding-top: 30px">N/A</td>
                                    <?php }?>
                                </tr>
                            <?php } }?>                        
                    </tbody>
                </table>
        </div>
    </div>
</div>
<?php include 'inc/footer.php' ;
