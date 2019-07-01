<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/Cart.php');
include_once ($filepath.'/../helpers/Format.php');
?>
<?php
$crt = new Cart();
$fm = new Format();
// product confirmed by ADMIN
if(isset($_GET['shiftId'])){
    $shiftId    = $_GET['shiftId'];
    //$price = $_GET['prc'];
    //$date  = $_GET['date']; 
    $shift = $crt->productshifted($shiftId);
}
// order product delete by ADMIN
if(isset($_GET['delProId'])){
    $delProId = $_GET['delProId'];
    //$price = $_GET['prc'];
    //$date  = $_GET['date']; 
    $delOrder = $crt->DelproductOrder($delProId);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Inbox</h2>
        <div class="block"> 
            <?php
            if(isset($shift)){
                echo $shift;
            }
            if(isset($delOrder)){
                echo $delOrder;
            }
            ?>
            <table class="data display datatable" id="example">
                        <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Order Time</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Cust ID</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                            <tbody>
                                <?php
                                $getOrder = $crt->getAllOrderProduct();
                                if($getOrder){                                                
                                    while($result = $getOrder->fetch_assoc()){
                                            ?>
                                    <tr class="odd gradeX">
                                            <td><?php echo $result['productId']?></td>
                                            <td><?php echo $fm->formatDate($result['date'])?></td>
                                            <td><?php echo $result['productName']?></td>
                                            <td><?php echo $result['quantity']?></td>
                                            <td><?php echo $result['price']?></td>
                                            <td><?php echo $result['cmrId']?></td>
                                            <td><a href="customer.php?custId=<?php echo $result['cmrId'];?>">View Details</a></td>
                                            <?php
                                                if($result['status']==0){?>
                                            <td><a href="?shiftId=<?php echo $result['orderId'];?>">Shifted</a></td>
                                                <?php }elseif($result['status']==1){?>
                                            <td>Pending</td>
                                                <?php } else { ?>
                                            <td><a href="?delProId=<?php echo $result['orderId'];?>">Remove</a></td>
                                                <?php }?>
                                    </tr>
                                <?php } }?>
                            </tbody>
                        </table>
       </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';
