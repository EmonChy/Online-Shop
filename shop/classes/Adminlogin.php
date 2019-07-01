<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath. '/../lib/Session.php');
    Session::checkLogin();
    include_once ($filepath. '/../lib/Database.php');
    include_once ($filepath. '/../helpers/Format.php');
    
 ?>
<?php

class Adminlogin {

    //put your code here
    private $db;
    private $fm;

    public function __construct() {
        $this->db = new Database(); ///obj create
        $this->fm = new Format();   ///obj create
    }

    public function adminlogin($adminUser, $adminPass) {

        $adminUser = $this->fm->validation($adminUser);
        $adminPass = $this->fm->validation($adminPass);

        $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
        $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

        if (empty($adminUser) || empty($adminPass)) { /// validation
            $loginmsg = "User Or Password must not be empty";
            return $loginmsg;
        } else {
            $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass'";

            $result = $this->db->select($query);

            if ($result) {
                $value = $result->fetch_assoc();

                Session::set(adminlogin, true);
                Session::set(adminId,   $value['adminId']);
                Session::set(adminUser, $value['adminUser']);
                Session::set(adminName, $value['adminName']);
                Session::set(adminPass, $value['adminPass']);

                header("Location: dashboard.php");
                
            } else {

                $loginmsg = "User Or Password not match";
                return $loginmsg;
            }
        }
    }
    public function adminforgotPass($adminEmail){
       $adminEmail = $this->fm->validation($adminEmail);
       $adminEmail = mysqli_real_escape_string($this->db->link, $adminEmail);
       
       if(!filter_var($adminEmail,FILTER_VALIDATE_EMAIL)){
         $messages = "<span style='color:red;font-size:18px;'>Invalid Email !!</span>"; 
         return $messages;
       }else{
           
           $mailquery = "SELECT * FROM tbl_admin WHERE adminEmail = '$adminEmail' LIMIT 1";

           $mailcheck = $this->db->select($mailquery);
           if($mailcheck!=FALSE){
               while ($value = $mailcheck->fetch_assoc()) {
                     $adminId = $value['adminId'];
                     $adminName = $value['adminName'];
                     $adminEmail = $value['adminEmail'];
                     
               }
            $text = substr($adminEmail, 0,3);
            $rand = rand(10000, 99999);
            $newpass = "$text$rand";
            $password = md5($newpass);
            
            
            $query = "UPDATE tbl_admin SET adminPass = '$password' WHERE adminId = '$adminId'";
                   
            $passwordupdate = $this->db->update($query);
            
            require 'PHPMailer-master/src/Exception.php';
            require 'PHPMailer-master/src/PHPMailer.php';
            require 'PHPMailer-master/src/SMTP.php';
           
            $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'emonchy35@gmail.com';                  // SMTP username
                $mail->Password = 'Emon@@@3Chy';                      // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('emonchy35@gmail.com', 'Admin');
                //$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
                $mail->addAddress($adminEmail);                         // Name is optional
                $mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');
                //Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Recovery Password For Admin";
                $mail->Body = "<i>Your UserName is : </i>$adminName<br><i> and password is : </i>$newpass<br>
                        Please visit website to login.";
                $mail->AltBody = "This is the plain text version of the email content";
                $mail->send();
                
                $messages = "<span style='color:green;font-size:18px;'>Please Check Your Email !!</span>"; 
                
                return $messages;
                //header('Location:forgot_password.php');
                //exit();

              }catch (Exception $e) {
                $messages = 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
                return $messages;
                
               }
               
           }else{
               $messages = "<span style='color:red;font-size:18px;'>Email Not Exist !!</span>"; 
               return $messages;
               
           }
           
       }

        
    }
    // password change for admin
    public function changePassword($adminId,$new_password){
        $adminId      = $this->fm->validation($adminId);
        $new_password = $this->fm->validation($new_password);

        $adminId      = mysqli_real_escape_string($this->db->link, $adminId);
        $new_password = mysqli_real_escape_string($this->db->link, $new_password);
        
        if(empty($new_password)){
            $msg = "<span style='color:red;font-weight:bold'>Password must not be empty</span>";
            return $msg;
        }else{
               $query = "UPDATE tbl_admin
                         SET    
                         adminPass      = '$new_password' 
                         WHERE adminId  = '$adminId'";

            $passwordupdate = $this->db->update($query);
                       
            if ($passwordupdate) {
                $msg = "<span style='color:green;font-weight:bold'>Password Updated successfully</span>";
                return $msg;
            } else {
                $msg = "<span style='color:red;font-weight:bold'>Password update is failed</span>";
                return $msg;
            }            
        }        
    }

}
