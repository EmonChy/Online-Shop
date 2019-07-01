<?php
$filepath = realpath(dirname(__FILE__));

include_once ($filepath . '/../lib/Database.php');
include_once ($filepath . '/../helpers/Format.php');
?>
<?php
class Customer {

    //put your code here
    private $db;
    private $fm;

    public function __construct() {

        $this->db = new Database(); ///obj create
        $this->fm = new Format();   ///obj create
    }

    /*
     *  show all city
     */

    public function getAllCity() {

        $query = "SELECT * FROM tbl_city";
        $result = $this->db->select($query);

        return $result;
    }

    /*
     *  show all area
     */

    public function getAllArea() {
//        
        $query = "SELECT * FROM tbl_area";
        $result = $this->db->select($query);
        return $result;
    }

    public function getallareabycityid($cityId){
        $cityId = $this->fm->validation($cityId);
        $cityId = mysqli_real_escape_string($this->db->link,$cityId);
        $query  = "SELECT * FROM tbl_area WHERE city = '$cityId'";
        $result = $this->db->select($query);
       
        return $result;
    }

    public function customerInsert($data) {
        $c_name = $this->fm->validation($data['c_name']); /// validation
        $c_address = $this->fm->validation($data['c_address']); /// validation
        $c_city = $this->fm->validation($data['c_city']); /// validation
        $c_area = $this->fm->validation($data['c_area']); /// validation
        $c_zip = $this->fm->validation($data['c_zip']); /// validation
        $c_phone = $this->fm->validation($data['c_phone']); /// validation
        $c_email = $this->fm->validation($data['c_email']); /// validation
        $c_pass = $this->fm->validation($data['c_pass']); /// validation

        $c_name = mysqli_real_escape_string($this->db->link, $data['c_name']);
        $c_address = mysqli_real_escape_string($this->db->link, $data['c_address']);
        $c_city = mysqli_real_escape_string($this->db->link, $data['c_city']);
        $c_area = mysqli_real_escape_string($this->db->link, $data['c_area']);
        $c_zip = mysqli_real_escape_string($this->db->link, $data['c_zip']);
        $c_phone = mysqli_real_escape_string($this->db->link, $data['c_phone']);
        $c_email = mysqli_real_escape_string($this->db->link, $data['c_email']);
        $c_pass = mysqli_real_escape_string($this->db->link, md5($data['c_pass']));

        if ($c_name == "" || $c_address == "" || $c_city == "" || $c_area == "" || $c_zip == "" || $c_phone == "" || $c_email == "" || $c_pass == "") {

            $msg = "<span style='color:red;font-weight:bold'>Fields must not be empty</span>";
            return $msg;
        }
        $mailquery = "SELECT * FROM tbl_customer WHERE c_email = '$c_email' LIMIT 1";
        $checkMail = $this->db->select($mailquery);
        if ($checkMail != False) {

            $msg = "<span class = 'error;font-weight:bold'>Email Already Exist!!</span>";
            return $msg;
        } else {
            $query = "INSERT INTO tbl_customer(c_name,c_address,c_city,c_area,c_zip,c_phone,c_email,c_pass) VALUES('$c_name','$c_address','$c_city','$c_area','$c_zip','$c_phone','$c_email','$c_pass')";
            $customerInsert = $this->db->insert($query);
            if ($customerInsert) {

                $msg = "<span style='color:green;font-weight:bold'>Customer inserted successfully</span>";
                return $msg;
            } else {
                $msg = "<span style='color:red;font-weight:bold'>Customer insertion is failed</span>";
                return $msg;
            }
        }
    }

    public function customerlogin($data) {
        $c_email  = $this->fm->validation($data['c_email']); /// validation
        $c_pass   = $this->fm->validation($data['c_pass']); /// validation
      
        
        $c_email  = mysqli_real_escape_string($this->db->link, $data['c_email']);
        $c_pass   = mysqli_real_escape_string($this->db->link, md5($data['c_pass']));
        
       
        if(empty($c_email) || empty($c_pass)){
            $msg = "<span style='color:red;font-weight:bold'>Fields must not be empty</span>";
            return $msg;
        }else{
            
            $query  = "SELECT * FROM tbl_customer WHERE c_email = '$c_email' AND c_pass = '$c_pass'";

            $result = $this->db->select($query);
            

            if($result != false){
                $value = $result->fetch_assoc();
                if($value['c_status']==0){
                $msg = "<span style='color:red;font-weight:bold'>Currently Your Account has been disabled!!!</span>";
                return $msg;
                }else{
                Session::set("customerlogin", true); 
                Session::set("customerId", $value['c_id']);
                Session::set("customerName", $value['c_name']);
                header('Location: cart.php');
                  }                
                }else{
                $msg ="<span style='color:red;font-weight:bold'>Email Or Password Not Match!!!</span>";
                return $msg;
            }
        }
    }
    public function customerData($id){
        $query = "SELECT cust.*,c.city_name,a.area_name
                  FROM tbl_customer as cust,tbl_city as c,tbl_area as a
                  WHERE cust.c_city = c.city_id AND cust.c_area = a.area_id
                  AND c_id = '$id'";
        // merge two more table in customer table by id
        $result = $this->db->select($query);
        return $result;
    }
    
    public function customerUpdate($data,$cmrid){
        $c_name = $this->fm->validation($data['c_name']); /// validation
        $c_address = $this->fm->validation($data['c_address']); /// validation
        $c_city = $this->fm->validation($data['c_city']); /// validation
        $c_area = $this->fm->validation($data['c_area']); /// validation
        $c_zip = $this->fm->validation($data['c_zip']); /// validation
        $c_phone = $this->fm->validation($data['c_phone']); /// validation
        $c_email = $this->fm->validation($data['c_email']); /// validation
       

        $c_name = mysqli_real_escape_string($this->db->link, $data['c_name']);
        $c_address = mysqli_real_escape_string($this->db->link, $data['c_address']);
        $c_city = mysqli_real_escape_string($this->db->link, $data['c_city']);
        $c_area = mysqli_real_escape_string($this->db->link, $data['c_area']);
        $c_zip = mysqli_real_escape_string($this->db->link, $data['c_zip']);
        $c_phone = mysqli_real_escape_string($this->db->link, $data['c_phone']);
        $c_email = mysqli_real_escape_string($this->db->link, $data['c_email']);
        

        if ($c_name == "" || $c_address == "" || $c_city == "" || $c_area == "" || $c_zip == "" || $c_phone == "" || $c_email == "") {

            $msg = "<span style='color:red;font-weight:bold'>Fields must not be empty</span>";
            return $msg;
        }
        else {
                $query = "UPDATE tbl_customer
                          SET    
                          c_name    = '$c_name', 
                          c_address = '$c_address',
                          c_city    = '$c_city',
                          c_area    = '$c_area',
                          c_zip     = '$c_zip',
                          c_phone   = '$c_phone',
                          c_email   = '$c_email'

                          WHERE c_id  = '$cmrid'";

            $customerupdate = $this->db->update($query);
            if ($customerupdate) {

                $msg = "<span style='color:green;font-weight:bold'>Customer Updated successfully</span>";
                return $msg;
            } else {
                $msg = "<span style='color:red;font-weight:bold'>Customer update is failed</span>";
                return $msg;
            }
        } 
    }
    
    public function getAllCustomers(){
        
     $query = "SELECT cust.*,c.city_name,a.area_name
               FROM tbl_customer as cust,tbl_city as c,tbl_area as a
               WHERE cust.c_city = c.city_id AND cust.c_area = a.area_id";
        // merge two more table in customer table
        $result = $this->db->select($query);
        return $result;   
        
    }
    
    public function processRatingByUser($cmrId,$productid,$rating){
     
        $cmrId     = $this->fm->validation($cmrId);     // validation
        $productid = $this->fm->validation($productid); // validation
        $rating    = $this->fm->validation($rating);    // validation
        
        $cmrId     = mysqli_real_escape_string($this->db->link, $cmrId);
        $productid = mysqli_real_escape_string($this->db->link, $productid);
        $rating    = mysqli_real_escape_string($this->db->link, $rating);
        
        $query     = "SELECT COUNT(*) AS cntproduct FROM tbl_rating WHERE cmrId = '$cmrId' AND productId = '$productid'";
        $result    =  $this->db->select($query)->fetch_assoc();
           
        $count = $result['cntproduct'];
       
        if($count==0){
            $insertquery  = "INSERT INTO tbl_rating(cmrId,productId,rating) VALUES('$cmrId','$productid','$rating')";
            $ratingInsert = $this->db->insert($insertquery);
                       
            }else{
                $updtquery    = "UPDATE tbl_rating
                                 SET    
                                 rating       = '$rating' 
                                 WHERE cmrId  = '$cmrId' AND productId = '$productid'";
                $ratingupdate = $this->db->update($updtquery);
             
            }                   
    }
    
    public function getRating($productId,$login){
        $query      = "SELECT * FROM tbl_rating WHERE productId='$productId' AND cmrId='$login'";
        $result = $this->db->select($query);       
        if($result){
            while($getresult = $result->fetch_assoc()){ 
               $rating = $getresult['rating'];
               return $rating;
            }
        }        
    }
    public function avgRating($productId){
           $query      = "SELECT ROUND(AVG(rating),1) as averageRating FROM tbl_rating WHERE productId='$productId'";
           $getresult  = $this->db->select($query);
            if($getresult){
                    while($result = $getresult->fetch_assoc()){
                        $averageRating = $result['averageRating'];
                        return $averageRating;

                    } 
            }
          
    }
    
    public function checkUserRating($productId,$login) {
        $query      = "SELECT * FROM tbl_rating WHERE productId='$productId' AND cmrId='$login'";
        $check = $this->db->select($query);
        if($check){
            $msg = 'You have already rated this product !';
            return $msg;
        }
    }

}

