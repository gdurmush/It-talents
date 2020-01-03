<?php
namespace Controller;
use model\Types;
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
        $types = getTypesFromCategorieId($_GET["ctgId"]);
        foreach ($types as $type){
            $typeObject = new Types($type["id"] , $type["name"] , $type["categorie_id"]);
            $typeObject->show();
        }
    }
    if (isset($_GET["typId"])){
      $products =  getProductsFromTypeId($_GET["typId"]);
      foreach ($products as $product){
          $product = findProduct($product["id"]);
          $product->show();
      }
    }

}
}