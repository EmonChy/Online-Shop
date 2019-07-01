<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/Customer.php');
?>
<?php
    if(!isset($_GET['custId']) || $_GET['custId']== NULL ){
        echo "<script>window.location = 'inbox.php';</script>";
    }else{
        $id = preg_replace('/[^-a-z-A-Z-0-9_]/', '',$_GET['custId']);
    }

    $cmr = new Customer();  /// obj create
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    echo "<script>window.location = 'inbox.php';</script>";
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Customer Detail</h2>
                
               <div class="block copyblock">
                   
                   <?php
                   $getCusDetails = $cmr->customerData($id);
                   if($getCusDetails){
                      while($result = $getCusDetails->fetch_assoc()){    
                   
                   ?>
                                                                   
                   <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>Name:</td>
                            <td>
                                <input type="text" name="c_name" readonly="readonly" value="<?php echo $result['c_name'] ;?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>
                                <input type="text" name="c_address" readonly="readonly" value="<?php echo $result['c_address'] ;?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>City:</td>
                            <td>
                                <input type="text" name="c_city" readonly="readonly" value="<?php echo $result['city_name'] ;?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Area:</td>
                            <td>
                                <input type="text" name="c_area" readonly="readonly" value="<?php echo $result['area_name'] ;?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Zip:</td>
                            <td>
                                <input type="text" name="c_zip" readonly="readonly" value="<?php echo $result['c_zip'] ;?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td>
                                <input type="text" name="c_phone" readonly="readonly" value="<?php echo $result['c_phone'] ;?>" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>
                                <input type="text" name="c_email" readonly="readonly" value="<?php echo $result['c_email'] ;?>" class="medium" />
                            </td>
                        </tr>
		        <tr> 
                            <td>
                                <input type="submit" name="submit" Value="OK" />
                            </td>
                        </tr>
                    </table>
                    </form>
                   <?php }} ?>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>