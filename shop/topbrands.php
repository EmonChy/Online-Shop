<?php include 'inc/header.php' ?>
<div class="container-12">
    <div class="card card-info">
                <div class="card-title">
                          
                    <div class="alert alert-success text-center font-weight-bold" style="">Canon</div>
                </div>        
                <div class="card-body">          
        <div class="row">
             <?php
            $getCanon = $pd->getlatestfromCanon();
            if ($getCanon){
                while ($result = $getCanon->fetch_assoc()){
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
            <?php } }?>
                </div>
            </div>
         <div class="card-title">                          
             <div class="alert alert-primary text-center font-weight-bold">Samsung</div>             
                </div>        
                <div class="card-body">          
        <div class="row">
             <?php
            $getSamsung = $pd->getlatestfromSamsung();
            if ($getSamsung) {
                while ($result = $getSamsung->fetch_assoc()) {
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
            <?php } }?>
                </div>
                    
            </div>
          <div class="card-title">                          
             <div class="alert alert-dark text-center font-weight-bold">Iphone</div>             
                </div>        
                <div class="card-body">          
        <div class="row">
              <?php
            $getIphone = $pd->getlatestfromIphone();
            if ($getIphone) {
                while ($result = $getIphone->fetch_assoc()) {
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
            <?php } }?>
                </div>
                    
            </div>
        <div class="card-title">                          
             <div class="alert alert-info text-center font-weight-bold">Acer</div>             
                </div>        
                <div class="card-body">          
        <div class="row">
              <?php
            $getAcer = $pd->getlatestfromAcer();
            if ($getAcer) {
                while ($result = $getAcer->fetch_assoc()) {
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
            <?php } }?>
                </div>
                    
            </div>
        <div class="card-title">                          
             <div class="alert alert-primary text-center font-weight-bold">Philips</div>             
                </div>        
                <div class="card-body">          
        <div class="row">
              <?php
            $getAcer = $pd->getlatestfromPhilips();
            if ($getAcer) {
                while ($result = $getAcer->fetch_assoc()) {
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
            <?php } }?>
                </div>
                    
            </div>
           
        </div>
</div>
<?php include 'inc/footer.php' ?>
