<?php
  $filepath = realpath(dirname(__FILE__));
    
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
?>
<?php

class Brand {
    //put your code here
    private $db;
    private $fm;

    public function __construct() {

        $this->db = new Database(); ///obj create
        $this->fm = new Format();   ///obj create
    }
    /*
     *  category insert
     */
    
    public function brandInsert($brandName){
        $brandName = $this->fm->validation($brandName);/// validation

        $brandName = mysqli_real_escape_string($this->db->link, $brandName);   
        
        if (empty($brandName)) { /// validation
            $msg = "<span class = 'error'>Brand Name must not be empty</span>";
            return $msg;
        }else{
           $query = "INSERT INTO tbl_brand(brandName) VALUES(' $brandName')";
           $brandinsert = $this->db->insert($query);
           if($brandinsert){
              
               $msg = "<span class='success'>Brand Name inserted successfully</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Brand Name insertion is failed</span>";
               return $msg;
           }
           
        }
    }
        public function getAllBrand(){
        
        $query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
        $result = $this->db->select($query);
        return $result;
        
    }
    
        public function getBrandById($id){
        
        $query = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
        $result = $this->db->select($query);
        return $result;
         
    }
    
        public function brandUpdate($brandName,$id){
        
        $brandName = $this->fm->validation($brandName);

        $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        $id = mysqli_real_escape_string($this->db->link, $id);
        
        
        if (empty($brandName)) { /// validation
            $msg = "<span class = 'error'>Brand Name must not be empty</span>";
            return $msg;
        }else{
           $query = "UPDATE tbl_brand SET brandName = '$brandName' WHERE brandId = '$id'";
                   
           $brandupdate = $this->db->update($query);
           if($brandupdate){
              
               $msg = "<span class='success'>Brand Name updated successfully</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Brand Name Update failed</span>";
               return $msg;
           }
           
        }

    }
    
        public function delBrandById($id){
          $query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
          $deletedata = $this->db->delete($query);
          if($deletedata){
              
               $msg = "<span class='success'>Brand deleted successfully</span>";
               return $msg;
           }else{
               $msg = "<span class = 'error'>Brand Not Deleted!!</span>";
               return $msg;
           }

        
    }
    
}
