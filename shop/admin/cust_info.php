<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
$filepath = realpath(dirname(__FILE__));
//include_once ($filepath . '/../lib/Database.php');
include_once ($filepath . '/../classes/Customer.php');
include_once ($filepath.'/../helpers/Format.php');
?>
<?php
$cmr = new Customer();
$db  = new Database();
$fm  = new Format();
?>
<?php
if(isset($_POST['cust_active'])){
    $cust_active = $_POST['cust_active'];
     $query = "UPDATE tbl_customer
               SET    
               c_status    = 1 
               WHERE c_id  = '$cust_active'";
     $customerupdate = $db->update($query);
}

if(isset($_POST['cust_deactive'])){
     
    $cust_deactive = $_POST['cust_deactive'];
     $query = "UPDATE tbl_customer
               SET    
               c_status    = 0
               WHERE c_id  = '$cust_deactive'";
     $customerupdate = $db->update($query);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Customer Records</h2>
        <div class="block"> 
            <?php
           
            ?>
            <table class="data display datatable" id="example">
                        <thead>
                               <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Addess</th>
                                    <th>City</th>
                                    <th>Area</th>
                                    <th>Zip</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                            <tbody>
                                <?php
                                $getAllCust = $cmr->getAllCustomers();
                                if($getAllCust){
                                        $i=0;
                                    while($result = $getAllCust->fetch_assoc()){
                                            $i++;
                                            ?>
                                    <tr class="">
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $result['c_name'];?></td>
                                            <td><?php echo $result['c_address'];?></td>
                                            <td><?php echo $result['city_name'];?></td>
                                            <td><?php echo $result['area_name'];?></td>
                                            <td><?php echo $result['c_zip'];?></td>
                                            <td><?php echo $result['c_phone'];?></td>
                                            <td><?php echo $result['c_email'];?></td>
                                            <?php if($result['c_status']==0){ ?>
                                            
                                            <td><form action="cust_info.php" method="post">
                                                   <input type="hidden" value="<?php echo $result['c_id'] ; ?> " name="cust_active"/>
                                                   <input type="submit" class="" value="DeActive"/>
                                               </form></td>
                                            
                                            <?php } else{?>    
                                            
                                               <td><form action="cust_info.php" method="post">
                                                      <input type="hidden" value="<?php echo $result['c_id']; ?> " name="cust_deactive"/>
                                                      <input type="submit" class="" value="Active"/>
                                                  </form></td>
                                                  
                                              <?php } ?>

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


