<?php
session_start();
if(isset($_SESSION['adminlogin'])){
header("Location: dashboard.php");
}else{
include '../classes/Adminlogin.php';
$al  = new Adminlogin();
if(isset($_POST['login'])){
    $adminEmail = $_POST['adminEmail'];
    //$adminPass = md5($_POST['adminPass']);    
    $passForgot = $al->adminforgotPass($adminEmail);
}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Password Recovery</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
            <form action="" method="post">
			<h1>Password Recovery</h1>
                        <span class="bg-info">
                            <?php
                            if(isset($passForgot))
                            {
                                echo $passForgot;
                            }
                            ?>
                        </span>
			<div>
                            <input type="text" name="adminEmail" placeholder="Enter Valid Email" required=""/>
                        </div>
			<div>
                            <input type="submit" name="login" value="Send Mail" />
                        </div>     
		</form><!-- form -->
                	<div class="button">
                            <a href="login.php">Login !</a>
		</div>  
		<div class="button">
			<a href="#">&copy; Copyright 2019 Project</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
<?php }?>