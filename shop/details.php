<?php include 'inc/header.php' ?>
<?php
if (isset($_GET['proId'])) {
    $id = preg_replace('/[^-a-z-A-Z-0-9_]/', '', $_GET['proId']);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'&& isset($_POST['submit'])){
    $quantity = $_POST['quantity'];
    $addCart = $ct->addToCart($quantity, $id);    
}
?>
<?php
    $cmrId =  Session::get("customerId"); 
    
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['compare'])){
    
    $productId = $_POST['productId'];

    $insertCompare = $pd->insertCompareData($cmrId,$productId); /// belong to the product class
    }
?>
<?php
    $cmrId =  Session::get("customerId"); 
    
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['wlist'])){
    
    $productId = $_POST['productId'];

    $saveWlist = $pd->saveWishList($cmrId,$productId); /// belong to the product class
    }
?>
<head>
    <script type="text/javascript">
    $(function(){
            $('.rating').barrating({
                theme: 'fontawesome-stars',
                onSelect: function(value, text, event){
                    // Get element id by data-id attribute
                    var el = this;
                    var el_id = el.$elem.data('id');
                    // rating was selected by a user
                    if(typeof(event)!=='undefined'){
                        
                        var split_id  = el_id.split("_");
                        
                        var productId = split_id[1];  // productId
                        // AJAX Request
                        $.ajax({
                             url: 'rating_ajaxData.php',
                            type: 'post',
                            data: {productId:productId,rating:value},
                            dataType: 'json',
                            success: function(data){
                                // Update average
                                var average=data['averageRating'];
                                $('#avgrating_'+productId).text(average);
                            }
                        });
                    }
                }
            });
        });
</script>
<style type="text/css">
    .mybutton{
        width: 100px;
        float: left;
        margin-right: 40px
    }
</style>
</head>
<div class="main">
    <div class="content">
        <div class="section group">
            <div class="cont-desc span_1_of_2">
                <?php
                $getpd = $pd->getSingleProduct($id); /// product details
                if ($getpd) {

                    while ($result = $getpd->fetch_assoc()) {
                        ?>

                        <div class="grid images_3_of_2">
                            <img src="admin/<?php echo $result['image'] ?>" alt="" />
                        </div>
                        <div class="desc span_3_of_2">
                            <h2><?php echo $result['productName']; ?></h2>

                            <div class="price">
                                <p>Price: <span>$<?php echo $result['price']; ?></span></p>
                                <p>Category: <span><?php echo $result['catName']; ?></span></p>
                                <p>Brand:<span><?php echo $result['brandName']; ?></span></p>
                            </div>
                             
                               <?php
                               // User rating part start
                               $login = Session::get("customerId");                              
                               // if user is logged in,then rating will visible using session
                               if($login==TRUE){
                               $productId  = $result['productId'];
                               // get rating
                               $rating = $cmr->getRating($productId,$login); // fetch rating data
                                      
                               // get average
                               $averageRating = $cmr->avgRating($productId); // fetch avg rating data
                               if($averageRating <= 0){
                                  $averageRating = "No rating yet.";
                                  }
                                  
                               // check rating
                                  $checkQuery = $cmr->checkUserRating($productId,$login); // chech if user already rated
                                  
                                    ?>
                                  <div class="rate">
                                     <!-- Rating -->
                                    <select class="rating" id="rating_<?php echo $result['productId']; ?>" data-id="rating_<?php echo $result['productId']; ?>">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                   
                                 
                                     Average Rating : <span id="avgrating_<?php echo $result['productId']; ?>"><?php echo $averageRating;?></span><br>
                                    <?php if(isset($checkQuery)){?>
                                    <span class="" style="color: red; font-size: 18px;"><?php echo $checkQuery;
                                    }?></span>
                                    <!-- Set rating -->
                                    <script type='text/javascript'>
                                    $(document).ready(function(){
                                    $('#rating_<?php echo $result['productId'];?>').barrating('set',<?php echo $rating;?>);
                                   });
                            
                                    </script>
                                  </div>
                                  <?php }?>
                            <div class="add-cart">
                                <form action="" method="post">
                                    <input type="number" class="buyfield" name="quantity" value="1" min="1"/>
                                    <input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
                                </form>				
                            </div>
                            
                                <?php if (isset($addCart)){?>
                                <span class="" style="color: red; font-size: 18px;"><?php echo $addCart;
                                }?></span>
                                
                               <?php if (isset($insertCompare)){?>
                                <span class="" style="color: red; font-size: 18px;"><?php echo $insertCompare;
                                }?></span>
                                
                                <?php if (isset($saveWlist)){?>
                                <span class="" style="color: red; font-size: 18px;"><?php echo $saveWlist;
                                }?></span>
                                
                                <?php
                                $login = Session::get("customerId");
                                // if user is logged in,then these features will visible using session
                                if($login==TRUE){?>
                            <div class="add-cart">
                                <div class="mybutton">
                                <form action="" method="post">
                                    <input type="hidden" class="buyfield"  name="productId" value="<?php echo $result['productId']; ?>"/>
                                    <input type="submit" class="buysubmit" name="compare" value="Add to Compare"/>
                                </form>
                                </div>
                                <div class="mybutton">
                                <form action="" method="post">
                                    <input type="hidden" class="buyfield"  name="productId" value="<?php echo $result['productId']; ?>"/>
                                    <input type="submit" class="buysubmit" name="wlist" value="Add to List"/>
                                </form>
                                </div>
                            </div>
                                <?php }?>
                     
                        </div>
                        <div class="product-desc">
                            <h2>Product Details</h2>
                            <?php echo $result['body']; ?>
                        </div>
                    <?php }
                } ?>

            </div>
            <div class="rightsidebar span_3_of_1">
                <h2>CATEGORIES</h2>
                <ul>
                    <?php
                      $getCat = $cat->getAllCat();
                      if($getCat){
                          while ($result=$getCat->fetch_assoc()){
                    ?>
                    <li><a href="productbycat.php?catId=<?php echo $result['catId'];?>"><?php echo $result['catName'];?></a></li>
                      <?php }}?>
                </ul>

            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php' ?>
