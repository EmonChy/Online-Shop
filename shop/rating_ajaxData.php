<?php
require 'lib/Session.php';
Session::init();
require 'lib/Database.php';
require 'classes/Customer.php';
$cmr =  new Customer();
$db  =  new Database();
$cmrId =  Session::get("customerId"); 
if(isset($_POST['productId']) && isset($_POST['rating'])){
  $productId = $_POST['productId'];
  $rating    = $_POST['rating'];
  $ratingProcess = $cmr->processRatingByUser($cmrId,$productId,$rating); // belong to customer class  
  
  //get average
  $avgratingquery = "SELECT ROUND(AVG(rating),1) as averageRating FROM tbl_rating WHERE productId = '$productId'";
  $avgresult = $db->select($avgratingquery)->fetch_assoc();
  $averageRating = $avgresult['averageRating'];
  
  $return_arr = array("averageRating"=>$averageRating);

  echo json_encode($return_arr);  
}                    