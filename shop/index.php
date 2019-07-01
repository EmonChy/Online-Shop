<?php include 'inc/header.php' ?>
<?php include 'inc/slider.php' ?>
<head>
    <style type="text/css">
        .card:hover{
            -webkit-box-shadow: -1px 9px 40px -12px rgba(0,0,0,0.75);
               -moz-box-shadow: -1px 9px 40px -12px rgba(0,0,0,0.75);
                    box-shadow: -1px 9px 40px -12px rgba(0,0,0,0.75);

        }
    </style>
</head>
 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Feature Products</h3>
              
    		</div>
    		<div class="clear"></div>
        </div>
        <br>
        <div class="row">
                 <?php
                        $getFpd = $pd->getFeatureProduct();
                        if($getFpd){   
                            while($result = $getFpd->fetch_assoc()){
                  ?>
        <div class="col-md-3">
    <div class="card">
        <a class="text-center" href="details.php?proId=<?php echo $result['productId'];?>"><img class="rounded" src="admin/<?php echo $result['image'] ?>" height="180px" max-width="100%" alt="Card image" style=""/></a>
    <div class="card-body">
        <div class="card-title" style="font-weight: bold;"><?php echo $result['productName'];?></div>
      <div class="card-text"><?php echo $fm->textShorten($result['body'],60);?>
 
          <p>$<?php echo $result['price'];?></p></div>
      
      <a class="btn btn-primary" href="details.php?proId=<?php echo $result['productId'];?>">Details</a>
    </div>
       </div>
        </div>
              <?php } } ?>
           
        </div>
	      <div class="content_bottom">
    		<div class="heading">
    		<h3>New Products</h3>
    		</div>
    		<div class="clear"></div>
    	      </div>
            <br>
	      <div class="row">
                        <?php
                        $getNpd = $pd->getNewProduct();
                        if($getNpd){
                            while($result = $getNpd->fetch_assoc()){
                               ?>
                            <div class="col-md-3">
                        <div class="card">
                            <a class="text-center" href="details.php?proId=<?php echo $result['productId'];?>"><img class="rounded" src="admin/<?php echo $result['image'] ?>" height="200px" max-width="100%" alt="Card image" style=""/></a>
                        <div class="card-body">
                            <div class="card-title" style="font-weight: bold;"><?php echo $result['productName'];?></div>
                          <div class="card-text"><?php echo $fm->textShorten($result['body'],40);?>

                              <p>$<?php echo $result['price'];?></p></div>

                          <a class="btn btn-primary" href="details.php?proId=<?php echo $result['productId'];?>">Details</a>
                        </div>
                           </div>
                            </div>
                             <?php } }?>   
        </div>
    </div>
 </div>
<script type="text/javascript">
  $(document).ready(function(){
      $('.col-md-3').hover(
         // trigger when mouse hover
         function(){
             $(this).animate({
                marginTop:"-=1%", 
             },200);
         },
         // trigger when mouse out
         function(){
             $(this).animate({
                 marginTop:"0%",
             },200);
         }                 
      );
  });  
</script>
<?php include 'inc/footer.php' ;
