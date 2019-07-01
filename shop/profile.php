<?php include 'inc/header.php' ;
?>
<?php
$login = Session::get("customerlogin");
if($login==FALSE){
header("Location:login.php");}
?>
<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
              
                <?php
                    $id = Session::get("customerId");
                    $getCustomerData = $cmr->customerData($id);
                    if($getCustomerData){
                        while ($result = $getCustomerData->fetch_assoc()){
                    
                ?>
                <br>
            <table class="table table-striped table-condensed table-bordered">
                                    <thead>
                                        <tr class="btn-info text-center">
                                            <td colspan="2"><span style="font-family: cursive;font-weight: bold; font-size: 20px;">Information</span></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-right"><b>Name :</b></td>
                                            <td><b><?php echo $result['c_name'];?></b></td>
                                         
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Address :</b></td>
                                            <td><b><?php echo $result['c_address'];?></b></td>
                                         
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>City :</b></td>
                                            <td><b><?php echo $result['city_name'];?></b></td>
           
                                        </tr> 
                                          <tr>
                                            <td class="text-right"><b>Area :</b></td>
                                            <td><b><?php echo $result['area_name'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Zip :</b></td>
                                            <td><b><?php echo $result['c_zip'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Phone :</b></td>
                                            <td><b><?php echo $result['c_phone'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Email :</b></td>
                                            <td><b><?php echo $result['c_email'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-right"><a class="btn btn-primary" href="editProfile.php">Update Details</a></td>
                                        </tr>
                                          
                                    </tbody>
                                </table>
                    <?php } } ?>
                
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php' ;
?>


