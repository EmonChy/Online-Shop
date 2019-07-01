<?php include 'inc/header.php' ?>
<?php
if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
    echo "<script>window.location = '404.php';</script>";
} else {
    $catid = preg_replace('/[^-a-z-A-Z-0-9_]/', '', $_GET['catId']);
}
?>
<div class="container-12">
    <div class="card card-info">
                <div class="card-title">
                          
             <div class="alert alert-primary text-center"><h3>Latest From Categories</h3>
             </div>
                </div>        
                <div class="card-body">          
        <div class="row">
             <?php
            $getProByCat = $pd->getProByCat($catid);
            if ($getProByCat) {
                
                while ($result = $getProByCat->fetch_assoc()){
                    ?>
            <div class="col-md-3">
                 <div class="card">
                            <a class="text-center" href="details.php?proId=<?php echo $result['productId']; ?>"><img class="rounded" src="admin/<?php echo $result['image'] ?>" height="180px" max-width="100%" alt="Card image" style=""/></a>
                            <div class="card-body">
                                <div class="card-title" style="font-weight: bold;"><?php echo $result['productName']; ?></div>
                                <div class="card-text"><?php echo $fm->textShorten($result['body'], 60); ?>

                                    <p>$<?php echo $result['price']; ?></p></div>

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
