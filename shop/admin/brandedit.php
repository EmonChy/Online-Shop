<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/Brand.php';?>
<?php
    if(!isset($_GET['brandId']) || $_GET['brandId']== NULL ){
        echo "<script>window.location = 'brandlist.php';</script>";
    }else{
        $id = preg_replace('/[^-a-z-A-Z-0-9_]/', '',$_GET['brandId']);
    }

    $brand = new Brand(); /// obj create
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $brandName = $_POST['brandName'];
    
    $updateBrand = $brand->brandUpdate($brandName,$id); /// belong to the category class
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Update Brand</h2>
                
               <div class="block copyblock">
                   <?php
                        if(isset($updateBrand)){
                            echo $updateBrand;
                            

                       }
                   ?>
                   <?php
                   $getBrand = $brand->getBrandById($id);
                   if($getBrand){
                      while($result = $getBrand->fetch_assoc()){    
                   
                   ?>
                                                                   
                   <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="brandName" value="<?php echo $result['brandName'] ;?>" class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                   <?php }} ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>