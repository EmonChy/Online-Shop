<?php
session_start();
if(!isset($_SESSION['adminlogin'])){
header("Location: login.php");
}else{
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/Adminlogin.php';
$al  = new Adminlogin();
$adminId   =  Session::get("adminId");
$adminPass = Session::get("adminPass");
//echo $adminPass;
$updatedPass = "";
if(isset($_POST['save'])){
    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $old_password = md5($oldpass); // old pass, when user input
    // match existing pass and user input pass
    if($adminPass==$old_password){
        $new_password = md5($newpass); // store new pass in db
        $updatedPass .= $al->changePassword($adminId,$new_password); // belong to the AdminLogin class
    }else{
        $updatedPass .= "<span style='color:red;font-weight:bold'>Your Old password not match</span>";
        }
        
}

?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Change Password</h2>
        
        <div class="block">
            <?php
            if(isset($updatedPass)){
                echo $updatedPass;
            }
            ?>
            <form action="" method="post">
            <table class="form">					
                <tr>
                    <td>
                        <label>Old Password</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Enter Old Password..."  name="oldpass" class="medium" />
                    </td>
                </tr>
				 <tr>
                    <td>
                        <label>New Password</label>
                    </td>
                    <td>
                        <input type="password" placeholder="Enter New Password..." name="newpass" class="medium" />
                    </td>
                </tr>
				 
				
		<tr>
                    <td>
                    </td>
                    <td>
                        <input type="submit" name="save" Value="Update" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; }?>
