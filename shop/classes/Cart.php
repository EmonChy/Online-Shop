<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath . '/../lib/Database.php');
include_once ($filepath . '/../helpers/Format.php');
?>
<?php
class Cart{
    //put your code here
    private $db;
    private $fm;
    public function __construct() {
        $this->db = new Database(); ///obj create
        $this->fm = new Format();   ///obj create
    }
    /// product add in the cart table
    public function addToCart($quantity, $id) {
        $quantity = $this->fm->validation($quantity); /// validation
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);
        $productId = mysqli_real_escape_string($this->db->link, $id);

        $sId = session_id(); /// unique in each and every user browser

        $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
        $result = $this->db->select($query)->fetch_assoc();

        $productName = $result['productName'];
        $price = $result['price'];
        $image = $result['image'];

        // check whether the same product already added or not

        $checkQuery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId'";
        $getPro = $this->db->select($checkQuery);
        if ($getPro){
            $msg = 'Product Already Added !';
            return $msg;
        } else{
            $query = "INSERT INTO tbl_cart(sId,productId,productName,price,quantity,image) VALUES('$sId','$productId','$productName','$price','$quantity','$image')";
            $cartInsert = $this->db->insert($query);
            if ($cartInsert){                
               echo "<script>window.location = 'cart.php';</script>";                
                //header("Location:cart.php");                
            }else{                
                header("Location:404.php");
            }
        }
    }

    // product show in cart page of an user

    public function getCartProduct() {
        $sId    = session_id();
        $query  = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query);
        return $result;
        
    }

    // quantity update using cartId

    public function UpdateCartQuantity($cartId, $quantity) {

        $cartId = $this->fm->validation($cartId); /// validation
        $quantity = $this->fm->validation($quantity); /// validation
        $cartId = mysqli_real_escape_string($this->db->link, $cartId);
        $quantity = mysqli_real_escape_string($this->db->link, $quantity);

        $query = "UPDATE tbl_cart
                  SET
                  quantity = '$quantity'
                  WHERE cartId = '$cartId' ";

        $updateQuantity = $this->db->update($query);
        if ($updateQuantity) {
            //echo "<script>window.location = 'cart.php';</script>";
            header("Location: cart.php");           
        }else{
            $msg = "<span class = 'error'>Quantity update is failed</span>";
            return $msg;
        }
    }

    /// delete product from cart

    public function delCartProduct($delpro) {
        $delpro = $this->fm->validation($delpro); /// validation

        $delpro = mysqli_real_escape_string($this->db->link, $delpro);
        $query = "DELETE FROM tbl_cart WHERE cartId = '$delpro'";
        $deletedata = $this->db->delete($query);
        if ($deletedata) {
            echo "<script>window.location = 'cart.php';</script>";
        }else{
            $msg = "<span class = 'error'>Product Not Deleted!!</span>";
            return $msg;
          }
    }
    
    // check whether the cart product empty or not
    // use getCartProduct() OR checkCartTable in cart option header page
    
    public function checkCartTable(){
        $sId    = session_id();
        $query  = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $result = $this->db->select($query);
        return $result;
    }
    // cart delete when user ordered product then cart will be empty by session
    public function deleteCustomerCart() {
        $sId = session_id();
        $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
        $this->db->delete($query);
    }
    /* product fetch from cart table by customer session id
     * and then added to the order table by customer id
     */
    public function orderProduct($cmrId){
        $sId    = session_id();
        $query  = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
        $getPro = $this->db->select($query);
        if($getPro){
            while($result = $getPro->fetch_assoc()){
                $productId = $result['productId'];
                $productName = $result['productName'];
                $quantity = $result['quantity'];
                $price = $result['price']*$quantity;
                $image = $result['image'];
            
           $query = "INSERT INTO tbl_order(cmrId,productId,productName,quantity,price,image) VALUES('$cmrId','$productId','$productName','$quantity','$price','$image')";
           $InsertOrder = $this->db->insert($query);    
                
            }
        }
        
    }
    // this method is used when same user enter in different times and buy products
    public function payableAmount($customerid){
        $query  = "SELECT * FROM tbl_order WHERE cmrId = '$customerid' AND date = now()";
        $result = $this->db->select($query);
        return $result;     
    }
    //in order page,the products will show using their customer id
    public function getOrderProduct($customerid){
        $query  = "SELECT * FROM tbl_order WHERE cmrId = '$customerid' ORDER BY date DESC";
        $result = $this->db->select($query);
        return $result;
    }
    //order check using customer id 
    public function checkOrder($customerid){
         $query  = "SELECT * FROM tbl_order WHERE cmrId = '$customerid'";
         $result = $this->db->select($query);
         return $result; 
    }
    
    // all order product showed in admin page named inbox.php
    public function getAllOrderProduct(){
         $query  = "SELECT * FROM tbl_order";
         $result = $this->db->select($query);
         return $result; 
    }
    // this method is controlled by admin for product shifting
    public function productshifted($shiftId){
         $shiftId = $this->fm->validation($shiftId);
         //$price   = $this->fm->validation($price); 
         //$date  = $this->fm->validation($date);
          
        $shiftId    = mysqli_real_escape_string($this->db->link, $shiftId); 
        //$price      = mysqli_real_escape_string($this->db->link, $price);
        //$date  = mysqli_real_escape_string($this->db->link, $date);
        $query = "UPDATE tbl_order
                  SET 
                  status = 1 
                  WHERE orderId='$shiftId'";
                   
           $orderupdate = $this->db->update($query);
           if($orderupdate){              
               $msg = "<span class='success'>Updated successfully</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Update failed</span>";
               return $msg;
           }
    }
    // when user confirmed the product,admin will remove it from admin panel
    public function DelproductOrder($delProId){
          $query = "DELETE FROM tbl_order WHERE orderId = '$delProId'";
          $deletedata = $this->db->delete($query);
          if($deletedata){
              
               $msg = "<span class='success'>Data deleted successfully</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Data Not Deleted!!</span>";
               return $msg;
           }        
    }
    // this method is controlled by user,when they confirmed the product
    public function productshiftConfirm($confirmId){
         $confirmId = $this->fm->validation($confirmId);
         //$price   = $this->fm->validation($price); 
         //$date  = $this->fm->validation($date);
          
        $confirmId    = mysqli_real_escape_string($this->db->link, $confirmId); 
        //$price      = mysqli_real_escape_string($this->db->link, $price);
        //$date  = mysqli_real_escape_string($this->db->link, $date);
        $query = "UPDATE tbl_order
                  SET 
                  status = 2 
                  WHERE orderId='$confirmId'";
                   
           $orderupdate = $this->db->update($query);
           if($orderupdate){              
               $msg = "<span class='success'>updated successfully</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Update failed</span>";
               return $msg;
           }
    }
    
}