<?php
ob_start();
?>
<?php include 'inc/header.php'; ?>
<?php
if (isset($_GET['delpro'])){
    // product delete from cart
    $delpro    = preg_replace('/[^-a-z-A-Z-0-9_]/', '',$_GET['delpro']);
    $delCartPd = $ct->delCartProduct($delpro);
}?>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $cartId = $_POST['cartId'];
    $quantity = $_POST['quantity'];
    // update product quantity in cart
    $updateCart = $ct->UpdateCartQuantity($cartId,$quantity);
    // if user enter negative or zero in quantity field
    if($quantity <= 0){
        $delCartPd = $ct->delCartProduct($cartId);
    }
}?>

<?php
// code for reload the page to get the session
if (!isset($_GET['id'])){

    // refresh the page, here we can use other value instead of id,it's not compulsory

    echo "<meta http-equiv='refresh' content='0;URL=?id=live'/>";
}?>

<div class="main">
    <div class="content">
        <div class="cartoption">		
            <div class="cartpage">
                <div class="text-success font-weight-bold" style="font-size: 25px;">Your Cart</div>
                    <?php
                    //cart update msg
                    if(isset($updateCart)){
                        echo $updateCart;
                    }
                    if(isset($delCartPd)){
                        echo $delCartPd;
                    }?>
                <table class="table table-striped">
                    <thead class="bg-dark">
                        <tr class="text-white text-center font-weight-bold ">
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Action</th>
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
                                    <td><img src="admin/<?php echo $result['image'];?>" height="70" width="90" alt=""/></td>
                                    <td style="padding-top: 30px"><?php echo '$'.$result['price'];?></td>
                                    <td style="padding-top: 30px">
                                        <form action="" method="post">
                                            <input type="hidden" name="cartId" value="<?php echo $result['cartId']; ?>"/>
                                            <input type="number" name="quantity"  value="<?php echo $result['quantity']; ?>"/>
                                            <input class="btn btn-sm btn-primary" type="submit" name="submit" value="Update"/>
                                        </form>
                                    </td>
                                    <td style="padding-top: 30px "><?php
                                        $total = $result['price'] * $result['quantity'];
                                        echo '$'.$total;
                                        ?></td>
                                    <td style="padding-top: 30px"><a onclick="return confirm('Are you sure to delete')"
                                              href="?delpro=<?php echo $result['cartId'];?>">X</a></td>
                                </tr>
                                <?php
                                $qty = $qty + $result['quantity'];
                                $sum = $sum + $total;
                                SESSION::set("sum",$sum);
                                SESSION::set("qty",$qty);
                                ?>
                            <?php } }?>                        
                    </tbody>
                </table>
                <?php
                $getdata = $ct->checkCartTable();
                if($getdata){
                    // check the product is exist or not
                    ?>
                    <table style="float:right;text-align:center;" width="30%">
                        <tr>
                            <th>Sub Total :</th>
                            <td><?php echo '$'.$sum;?></td>
                        </tr>
                        <tr>
                            <th>VAT(10%) :</th>
                            <td>
                                <?php
                                $vat = $sum * 0.1;
                                echo $vat;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Grand Total :</th>
                            <td>
                                <?php                                
                                $total_sum = $sum + $vat;                                
                                echo '$'.$total_sum;
                                ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                    }else{
                    //echo "<script>location.replace('index.php');</script>";
                    header("Location: index.php");
                    ob_end_flush();
                    }
                ?>                                       
            </div>
            <div class="shopping">
                <div class="shopleft">
                    <a href="index.php"><img src="images/shop.png" alt=""/></a>
                </div>
                <div class="shopright">
                    <a href="payment.php"><img src="images/check.png" alt=""/></a>
                </div>
            </div>
        </div>  	
        <div class="clear"></div>
    </div>
</div>
<?php include 'inc/footer.php' ;


