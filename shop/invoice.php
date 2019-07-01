<?php
ob_start();
?>
<?php 
//$filepath = realpath(dirname(__FILE__));
include 'lib/Session.php';
//include_once ($filepath . '/lib/Session.php');
Session::init();
include 'lib/Database.php';
include 'helpers/Format.php';

//include_once($filepath . '/lib/Database.php');
//include_once($filepath . '/helpers/Format.php');

spl_autoload_register(function($class) {
     include_once "classes/" . $class . ".php";   
});

$db  = new Database();
$fm  = new Format();
$ct  = new Cart();
$pd  = new Product();
$cat = new Category();
$cmr = new Customer();
?>
<head>
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/menu.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>

    <script src="js/jquerymain.js"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script> 
    <script type="text/javascript" src="js/nav.js"></script>
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script> 
    <script type="text/javascript" src="js/nav-hover.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        $(document).ready(function ($) {
            $('#dc_mega-menu-orange').dcMegaMenu({rowItems: '4', speed: 'fast', effect: 'fade'});
        });
    </script>    
<style type="text/css">
    .tbl{
        width : 50%; 
        border: 2px solid black;
        float:right;
    }
    .tbl tr td{
        padding: 3px;
    }
</style>
</head>
    <div class="container-12">
        
        <div class="row">            
            <div class="col-md-6 offset-md-3">
                
                <br>
                    <table class="table table-striped table-condensed table-bordered">
                    <thead>
                        <tr>
                            <td colspan="5" class="text-center font-weight-bold">Product Information</td>
                        </tr>
                        <tr>
                            <td class="text-center font-weight-bold">No</td>
                            <td class="text-center font-weight-bold">Product</td>                            
                            <td class="text-center font-weight-bold">Price</td>
                            <td class="text-center font-weight-bold">Quantity</td>
                            <td class="text-center font-weight-bold">Total</td>                            
                        </tr>
                    </thead>                            
                    <tbody class=""> 
                            <?php
                            $getPro = $ct->getCartProduct();
                            // product add in cart using user session id 
                            if($getPro){
                                $i   = 0;
                                $sum = 0;
                                $qty = 0;

                                while($result = $getPro->fetch_assoc()){
                                    $i++;                                    
                                    ?>
                                <tr class="text-center">
                                    <td style="padding-top: 30px"><?php echo $i;?></td>
                                    <td style="padding-top: 30px"><?php echo $result['productName'];?></td>
                                    <td style="padding-top: 30px"><?php echo '$'.$result['price'];?></td>
                                    <td style="padding-top: 30px"><?php echo $result['quantity'];?></td>
                                    <td style="padding-top: 30px "><?php
                                        $total = $result['price'] * $result['quantity'];
                                        echo '$'.$total;
                                        ?></td>
                                </tr>
                                <?php
                                $qty = $qty + $result['quantity'];
                                $sum = $sum + $total;
                                ?>
                            <?php } }?>                        
                    </tbody>
                </table>
                <table class="tbl table-striped">
                    <tr>
                        <th class="text-right">Sub Total :</th>
                        <td><?php echo '$'.$sum;?></td>
                    </tr>
                    <tr>
                        <th class="text-right">VAT(10%) :</th>
                        <td>
                            <?php
                            $vat = $sum * 0.1;
                            echo $vat;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-right">Grand Total :</th>
                        <td>
                            <?php                                
                            $total_sum = $sum + $vat;                                
                            echo '$'.$total_sum;
                            ?>
                        </td>
                    </tr>
                     <tr>
                        <th class="text-right">Quantity :</th>
                        <td><?php echo $qty;?></td>
                    </tr>
                </table>    
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3">
                
                <br>
                <?php
                    $id = Session::get("customerId");
                    $getCustomerData = $cmr->customerData($id);
                    if($getCustomerData){
                        while($result = $getCustomerData->fetch_assoc()){                    
                ?>                
            <table class="table table-striped table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <td colspan="2" class="text-center font-weight-bold">Information</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-right"><b>Name :</b></td>
                                            <td><b><?php echo $result['c_name'];?></b></td>
                                         
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Address :</b></td>
                                            <td><b><?php echo $result['c_address'];?></b></td>
                                         
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>City :</b></td>
                                            <td><b><?php echo $result['city_name'];?></b></td>
           
                                        </tr> 
                                        <tr>
                                            <td class="text-right"><b>Area :</b></td>
                                            <td><b><?php echo $result['area_name'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Zip :</b></td>
                                            <td><b><?php echo $result['c_zip'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Phone :</b></td>
                                            <td><b><?php echo $result['c_phone'];?></b></td>           
                                        </tr>
                                        <tr>
                                            <td class="text-right"><b>Email :</b></td>
                                            <td><b><?php echo $result['c_email'];?></b></td>           
                                        </tr>                                          
                                    </tbody>
                    </table>
                    <?php } } ?>
            </div>
        </div>
        </div>
        
                            <button type="button" class="btn btn-sm btn float-left" onClick="window.close()">
                                <i class="fa fa-close"> <b>Close</b></i>
                            </button>
                            <button type="button" class="btn btn-sm btn float-right" onClick="window.print()">
                                <i class="fa fa-print"> <b>Print</b></i>
                            </button>
</div>



