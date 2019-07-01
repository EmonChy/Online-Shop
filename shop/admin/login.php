<?php
include '../classes/Adminlogin.php';
?>
<?php
$al  = new Adminlogin();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $adminUser  = $_POST['adminUser'];
    $adminPass  = md5($_POST['adminPass']);    
    $logincheck = $al->adminlogin($adminUser,$adminPass);
}
?>
<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>
<body>
<div class="container">
	<section id="content">
            <form action="login.php" method="post">
			<h1>Admin Login</h1>
                        <span class="bg-info">
                            <?php
                            if(isset($logincheck)){
                                echo $logincheck;
                            }
                            ?>
                        </span>
			<div>
				<input type="text" placeholder="Username" required="" name="adminUser"/>
			</div>
			<div>
				<input type="password" placeholder="Password" required="" name="adminPass"/>
			</div>
                        
			<div>
                            <input type="submit" name="login" value="Login" />
			</div>
		</form><!-- form -->
                <div class="button">
			<a href="forgotpassword.php">Forgot Password !</a>
		</div>
		<div class="button">
                    <a href="#">&copy; Copyright 2019 Project</a>
		</div><!-- button -->
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
<?php  //}?>