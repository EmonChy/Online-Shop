<?php
ob_start();
?>
<?php include 'inc/header.php'; ?>
<?php
$login = Session::get("customerlogin");
if ($login == FALSE) {
    header("Location:login.php");
}
?>
<div class="main">
    <div class="content">
        <div class="cartoption">		
            <div class="cartpage">
                <div class="text-success font-weight-bold" style="font-size: 25px;">Compare</div>

                <table class="table table-striped">
                    <thead class="bg-dark">
                        <tr class="text-white text-center font-weight-bold ">
                            <th>SL</th>
                            <th>Product Name</th>                            
                            <th>Price</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>                            
                    <tbody class=""> 
                            <?php
                            $customerid = Session::get("customerId");
                            $getPd = $pd->getCompareData($customerid);
                            // product add in cart using user session id 
                            if($getPd){
                                $i   = 0;
                                while($result = $getPd->fetch_assoc()){
                                    $i++;                                    
                                    ?>
                                <tr class="text-center">
                                    <td style="padding-top: 30px"><?php echo $i;?></td>
                                    <td style="padding-top: 30px"><?php echo $result['productName'];?></td>
                                    <td style="padding-top: 30px"><?php echo '$'.$result['price'];?></td>
                                    <td><img src="admin/<?php echo $result['image'];?>" height="80" width="95" alt=""/></td>
                                    <td style="padding-top: 30px"><a href="details.php?proId=<?php echo $result['productId'];?>">View</a></td>
                                </tr>
                            <?php }} ?>
                    </tbody>
                </table>                                       
            </div>
            <div class="shopping">
                <div class="shopleft" style="width: 100%;text-align: center;">
                    <a href="index.php"><img src="images/shop.png" alt=""/></a>
                </div>
                
            </div>
        </div>  	
        <div class="clear"></div>
    </div>
</div>
<?php include 'inc/footer.php' ;


