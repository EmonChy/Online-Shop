<?php include 'inc/header.php';
?>
<?php
$login = Session::get("customerlogin");
if ($login == FALSE) {
    header("Location:login.php");
}
?>
<?php
    $cmrid =  Session::get("customerId"); 
    
    if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
    
    
    $updateCustomer = $cmr->customerUpdate($_POST,$cmrid); /// belong to the customer class
    
    
    }
    
?>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <?php
                $id = Session::get("customerId");
                // customer id in tbl_customer table 
                $getCustomerData = $cmr->customerData($id);
                if ($getCustomerData) {
                    while ($result = $getCustomerData->fetch_assoc()) {
                        ?>
                
                        <br>
                        <form action="" method="post">
                            
                            <table class="table table-striped table-condensed table-bordered">
                                <thead>
                                    <tr><td colspan="2"><?php
                                    if(isset($updateCustomer)){
                                        echo $updateCustomer;
                                    }
                                    ?></td></tr>
                                    <tr class="btn-info text-center">
                                        <td colspan="2"><span style="font-family: cursive;font-weight: bold; font-size: 20px;">Update Information</span></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-right"><b>Name :</b></td>
                                        <td><b><input class="form-control" type="text" name="c_name" value="<?php echo $result['c_name']; ?>" /></b></td>

                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Address :</b></td>
                                        <td><b><input class="form-control" type="text" name="c_address" value="<?php echo $result['c_address']; ?>" /></b></td>

                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>City :</b></td>
                                        <td><b> <select class="form-control" name="c_city">
                                                    <option>Select City</option>
                                                    <?php
                                                    $getCity = $cmr->getAllCity();
                                                    if ($getCity) {
                                                        while ($value = $getCity->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?php echo $value['city_id'] ?>"<?php if ($value['city_id'] == $result['c_city']) {
                                                echo 'selected';
                                            } ?>><?php echo $value['city_name']; ?></option>
                                                <?php }
                                            } ?>

                                                </select></b></td>

                                    </tr> 
                                    <tr>
                                        <td class="text-right"><b>Area :</b></td>
                                        <td><b> 
                                                <select class="form-control"  name="c_area">
                                                    <option value="">Select Area</option>
                                                    <?php
                                                    $getArea = $cmr->getAllArea();
                                                    if ($getArea) {
                                                        while ($value = $getArea->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?php echo $value['area_id'] ?>"<?php if ($value['area_id'] == $result['c_area']) {
                                                echo 'selected';
                                            } ?>><?php echo $value['area_name']; ?></option>
                                            <?php }
                                        } ?>
                                                </select></b></td>           
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Zip :</b></td>
                                        <td><b><input class="form-control" type="text" name="c_zip" value="<?php echo $result['c_zip']; ?>"/></b></td>           
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Phone :</b></td>
                                        <td><b><input class="form-control" type="text" name="c_phone" minlength="11" maxlength="11" value="<?php echo $result['c_phone']; ?>" /></b></td>           
                                    </tr>
                                    <tr>
                                        <td class="text-right"><b>Email :</b></td>
                                        <td><b><input class="form-control" type="email" name="c_email" value="<?php echo $result['c_email']; ?>" /></b></td>           
                                    </tr>
                                    <tr>
                                        <td colspan="2">

                                            <input class="form-control btn btn-light" type="submit" name="submit" value="Save"/>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </form>
    <?php }
} ?>                

            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php';
?>


