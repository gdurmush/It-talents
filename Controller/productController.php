<?php
namespace Controller;
use model\Product;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";
class ProductController {
public function show (){
    if (isset($_GET["prdId"])){
        $product = findProduct($_GET["prdId"]);
        $product->show();
    }
    if (isset($_GET["ctgId"])){
        echo "Categorie Products";
    }

}
}