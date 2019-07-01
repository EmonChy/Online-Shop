<?php
    $filepath = realpath(dirname(__FILE__));
    
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');

    ///include_once '../helpers/Format.php';

?>
<?php
class Product {
    //put your code here
    private $db;
    private $fm;

    public function __construct() {

        $this->db = new Database(); ///obj create
        $this->fm = new Format();   ///obj create
    }
    
    public function productInsert($data,$file){
        $productName = $this->fm->validation($data['productName']);/// validation
        $catId       = $this->fm->validation($data['catId']);/// validation
        $brandId     = $this->fm->validation($data['brandId']);/// validation
        $body        = $this->fm->validation($data['body']);/// validation
        $price       = $this->fm->validation($data['price']);/// validation
        $keywords    = $this->fm->validation($data['keywords']);/// validation
        $type        = $this->fm->validation($data['type']);/// validation

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);   
        $catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
        $brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
        $body        = mysqli_real_escape_string($this->db->link, $data['body']);
        $price       = mysqli_real_escape_string($this->db->link, $data['price']);
        $keywords    = mysqli_real_escape_string($this->db->link, $data['keywords']);
        $type        = mysqli_real_escape_string($this->db->link, $data['type']);
        
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name); /// split the strings and store it in array
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "uploads/".$unique_image;
        
        if($productName==""||$catId==""||$brandId==""||$body==""||$price==""||$keywords==""||$file_name==""||$type=="")
                 {
                
                  $msg = "<span class = 'error'>Fields must not be empty</span>";
                  return $msg;
               
                 }
                
        else if ($file_size >1048567) {
                 echo "<span class='error'>Image Size should be less then 1MB!
                 </span>";
                }
                
        else if (in_array($file_ext, $permited) === false) {
                 echo "<span class='error'>You can upload only:-"
                 .implode(', ', $permited)."</span>";
                }
                
        else{
                    move_uploaded_file($file_temp, $uploaded_image);
                    $query = "INSERT INTO tbl_product(productName,catId,brandId,body,price,image,keywords,type) VALUES('$productName','$catId','$brandId','$body','$price','$uploaded_image','$keywords','$type')"; 
                    $pdinsert = $this->db->insert($query);
                        if($pdinsert){
                          
                           $msg = "<span class='success'>Product inserted successfully</span>";
                           return $msg;
                       }else{
                           $msg = "<span class = 'error'>Product insertion is failed</span>";
                           return $msg;
                       }
 
                }

    }
    
    public function getAllProduct(){
        /// using Aliases
        
        $query = "SELECT p.*,c.catName,b.brandName
                  FROM tbl_product as p,tbl_category as c,tbl_brand as b
                  WHERE p.catId = c.catId AND p.brandId = b.brandId
                  ORDER BY p.productId DESC";
        
        /// using inner join
        
        /*
        $query = "SELECT tbl_product.*,tbl_category.catName,tbl_brand.brandName
                  FROM tbl_product
                  INNER JOIN tbl_category
                  ON tbl_product.catId = tbl_category.catId
                  INNER JOIN tbl_brand
                  ON tbl_product.brandId = tbl_brand.brandId
                  ORDER BY tbl_product.productId DESC";
        */
        
        $result = $this->db->select($query);
        return $result;
    }
    public function getProductById($id){
        $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
        $result = $this->db->select($query);
        return $result;
         
        
    }
    public function productupdate($data,$file,$id) {
        $productName = $this->fm->validation($data['productName']);/// validation
        $catId       = $this->fm->validation($data['catId']);/// validation
        $brandId     = $this->fm->validation($data['brandId']);/// validation
        $body        = $this->fm->validation($data['body']);/// validation
        $price       = $this->fm->validation($data['price']);/// validation
        $keywords    = $this->fm->validation($data['keywords']);/// validation
        $type        = $this->fm->validation($data['type']);/// validation

        $productName = mysqli_real_escape_string($this->db->link, $data['productName']);   
        $catId       = mysqli_real_escape_string($this->db->link, $data['catId']);
        $brandId     = mysqli_real_escape_string($this->db->link, $data['brandId']);
        $body        = mysqli_real_escape_string($this->db->link, $data['body']);
        $price       = mysqli_real_escape_string($this->db->link, $data['price']);
        $keywords    = mysqli_real_escape_string($this->db->link, $data['keywords']);
        $type        = mysqli_real_escape_string($this->db->link, $data['type']);
        
        $permited  = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $div = explode('.', $file_name); /// split the strings and store it in array
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
        $uploaded_image = "uploads/".$unique_image;
        
        if($productName==""||$catId==""||$brandId==""||$body==""||$price==""||$keywords==""||$type=="")
                 {
                
                  $msg = "<span class = 'error'>Fields must not be empty</span>";
                  return $msg;
               
                 }
          else{
               if(!empty($file_name)){  /// input field a img select kora thkle
                
                 if ($file_size >1048567) {
                         echo "<span class='error'>Image Size should be less then 1MB!
                         </span>";
                        }

                else if (in_array($file_ext, $permited) === false) {
                         echo "<span class='error'>You can upload only:-"
                         .implode(', ', $permited)."</span>";
                        }

                   else{  
                            move_uploaded_file($file_temp, $uploaded_image);
                            $query = "UPDATE tbl_product
                                      SET
                                      productName = '$productName',
                                      catId       = '$catId',
                                      brandId     = '$brandId',
                                      body        = '$body',
                                      price       = '$price',
                                      image       = '$uploaded_image',
                                      keywords    = '$keywords',
                                      type        = '$type'
                                          
                                  WHERE productId = '$id' ";    
                                       
                            $pdupdate = $this->db->update($query);
                                if($pdupdate){

                                   $msg = "<span class='success'>Product updated successfully</span>";
                                   return $msg;
                               }else{
                                   $msg = "<span class = 'error'>Product updated is failed</span>";
                                   return $msg;
                               }

                        }
                    }
                    else{ /// input field a img select na thkle....
                             $query = "UPDATE tbl_product
                                      SET
                                      productName = '$productName',
                                      catId       = '$catId',
                                      brandId     = '$brandId',
                                      body        = '$body',
                                      price       = '$price',
                                      keywords    = '$keywords',
                                      type        = '$type'
                                          
                                  WHERE productId = '$id' ";    
                                       
                            $pdupdate = $this->db->update($query);
                                if($pdupdate){

                                   $msg = "<span class='success'>Product updated successfully</span>";
                                   return $msg;
                               }else{
                                   $msg = "<span class = 'error'>Product updated is failed</span>";
                                   return $msg;
                               }
   
                    }


            }

       }
       public function delProById($id){
           $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
           $getdata = $this->db->select($query);
           
           /// ei part ta use kora hoise prjct r folder thk img delete korar jnno
           
           if($getdata){
               while($delImg = $getdata->fetch_assoc()){
                   $dellink = $delImg['image'];
                   unlink($dellink);
               }
           }
           
          $query = "DELETE FROM tbl_product WHERE productId = '$id'";
          $deletedata = $this->db->delete($query);
          if($deletedata){
              
               $msg = "<span class='success'>Product deleted successfully</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Product Not Deleted!!</span>";
               return $msg;
           }
           
           
       }
       
       public function getFeatureProduct(){
        $query = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
       
       }
       
       public function getNewProduct() {
        $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result; 
           
       }
       
       /// details of a product from joining diff tables
       
       public function getSingleProduct($id){
            $query = "SELECT p.*,c.catName,b.brandName
                      FROM tbl_product as p,tbl_category as c,tbl_brand as b
                      WHERE p.catId = c.catId AND p.brandId = b.brandId 
                      AND p.productId = '$id'";
       
        
        $result = $this->db->select($query);
        return $result;
       }
       // used for topbrands page
       public function getlatestfromIphone(){
           
        $query = "SELECT * FROM tbl_product WHERE brandId='3' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
       }
        // used for topbrands page
       public function getlatestfromSamsung(){
               
        $query = "SELECT * FROM tbl_product WHERE brandId='2' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;  
       }
        // used for topbrands page
       public function getlatestfromAcer(){
                    
        $query = "SELECT * FROM tbl_product WHERE brandId='1' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;  
           
       }
        // used for topbrands page
       public function getlatestfromCanon(){
           
        $query = "SELECT * FROM tbl_product WHERE brandId='4' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;
        
       }
       // used for topbrands page
       public function getlatestfromPhilips(){
          
        $query = "SELECT * FROM tbl_product WHERE brandId='5' ORDER BY productId DESC LIMIT 4";
        $result = $this->db->select($query);
        return $result;  
       }
       
       public function getProByCat($catid){
        $catid = mysqli_real_escape_string($this->db->link,$catid);
        $query = "SELECT * FROM tbl_product WHERE catId = '$catid'";
        $result = $this->db->select($query);
        return $result; 
           
       }
       public function insertCompareData($cmrId,$productId){
       $cmrId = $this->fm->validation($cmrId);/// validation
       $productId = $this->fm->validation($productId);/// validation
    
       $cmrId = mysqli_real_escape_string($this->db->link,$cmrId);
       $productId = mysqli_real_escape_string($this->db->link,$productId);
       
        $checkQuery = "SELECT * FROM tbl_compare WHERE productId = '$productId' AND cmrId = '$cmrId'";
        $getCompare = $this->db->select($checkQuery);
        if ($getCompare){
            $msg = 'Already Added !';
            return $msg;
        } 
       
        $query  = "SELECT * FROM tbl_product WHERE productId = '$productId'";
        $result = $this->db->select($query)->fetch_assoc();
        if($result){
                $productId = $result['productId'];
                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];
            
           $query = "INSERT INTO tbl_compare(cmrId,productId,productName,price,image) VALUES('$cmrId','$productId','$productName','$price','$image')";
           $InsertProduct = $this->db->insert($query);
           if($InsertProduct){
              
               $msg = "<span class='success'>Added ! Check Compare Page</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Not Added!!</span>";
               return $msg;
               }
           
           }
           
       }
       public function getCompareData($customerid){
           $query  = "SELECT * FROM tbl_compare WHERE cmrId='$customerid' ORDER BY compareId DESC";
           $result = $this->db->select($query);
           return $result;
           
       }
       public function deleteCompareProduct($customerid){
          $query = "DELETE FROM tbl_compare WHERE cmrId = '$customerid'";
          $deletedata = $this->db->delete($query);
           
       }
       public function saveWishList($cmrId,$productId){
       $cmrId = $this->fm->validation($cmrId);/// validation
       $productId = $this->fm->validation($productId);/// validation
    
       $cmrId = mysqli_real_escape_string($this->db->link,$cmrId);
       $productId = mysqli_real_escape_string($this->db->link,$productId);
       
        $checkQuery = "SELECT * FROM tbl_wlist WHERE productId = '$productId' AND cmrId = '$cmrId'";
        $getCompare = $this->db->select($checkQuery);
        if ($getCompare){
            $msg = 'Already Added !';
            return $msg;
        } 
       
        $query  = "SELECT * FROM tbl_product WHERE productId = '$productId'";
        $result = $this->db->select($query)->fetch_assoc();
        if($result){
                $productId = $result['productId'];
                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];
            
           $query = "INSERT INTO tbl_wlist(cmrId,productId,productName,price,image) VALUES('$cmrId','$productId','$productName','$price','$image')";
           $InsertProduct = $this->db->insert($query);
           if($InsertProduct){
              
               $msg = "<span class='success'>Added ! Check Wlist Page</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Not Added!!</span>";
               return $msg;
               }
           
           } 
           
       }
       
       public function getWlistData($customerid){
        $query  = "SELECT * FROM tbl_wlist WHERE cmrId='$customerid' ORDER BY wlistId DESC";
        $result = $this->db->select($query);
        return $result;           
       }
       
       public function delWlistData($customerid,$productId){
          $query = "DELETE FROM tbl_wlist WHERE cmrId = '$customerid' AND productId='$productId'";
          $deletedata = $this->db->delete($query);
          
       }
       
       public function searchProductByUser($search){
        $query  = "SELECT * FROM tbl_product WHERE keywords LIKE '%$search%'";
        $result = $this->db->select($query);
        return $result;
           
       }
 }
