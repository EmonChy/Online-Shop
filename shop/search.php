<?php include 'inc/header.php' ?>
<?php
if(isset($_POST['product_search'])) {
    $search = $_POST['product_search'];
    $product_search = $pd->searchProductByUser($search); 
    //echo "<script>window.location = '404.php';</script>";
}
?>
<div class="container-12">
    <div class="card card-info">
                <div class="card-title">
                          
             <div class="alert alert-primary text-center"><h3>Searched Product</h3>
             </div>
                </div>        
                <div class="card-body">          
        <div class="row">
             <?php
            //$getProByCat = $pd->getProByCat($catid);
            if ($product_search) {
                
                while ($result = $product_search->fetch_assoc()){
                    ?>
            <div class="col-md-3">
                 <div class="card">
                            <a class="text-center" href="details.php?proId=<?php echo $result['productId']; ?>"><img class="rounded" src="admin/<?php echo $result['image'] ?>" height="180px" max-width="100%" alt="Card image" style=""/></a>
                            <div class="card-body">
                                <div class="card-title" style="font-weight: bold;"><?php echo $result['productName']; ?></div>
                                <div class="card-text"><p>Price: $<?php echo $result['price']; ?></p></div>

                                <a class="btn btn-primary" href="details.php?proId=<?php echo $result['productId']; ?>">Details</a>
                            </div>
                 </div>
            </div>
            <?php } }else { ?>
                </div>
            
       <p class="text-center text-danger font-weight-bold">No Products Available</p> 
             <?php } ?>
            </div>
           
        </div>
</div>
<?php include 'inc/footer.php' ?>
