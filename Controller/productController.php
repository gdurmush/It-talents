<?php
namespace Controller;
use model\Types;

use model\Product;
use Model\ProductDAO;

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
          $productList = findProduct($product["id"]);
          $productList->show();
      }

    }

}




    public function add(){
    $err=false;
    $msg='';
    if(isset($_POST["save"])){
        if(empty($_POST["name"]) || empty($_POST["producer_id"])
            || empty($_POST["price"]) || empty($_POST["type_id"])
            || empty($_POST["quantity"])) {
            $err = true;
            $msg = "All fields are required!";
        }else{
            if(!preg_match('/^[0-9]+$/',$_POST["quantity"]) || !is_numeric($_POST["quantity"])){
                $err=true;
                $msg="Invalid quantity format!";
            }

            if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["price"])){
                $err=true;
                $msg="Invalid price format!";
            }
            if(!is_uploaded_file($_FILES["file"]["tmp_name"])) {
                $err = true;
                $msg = "Image is not uploaded!";
            }elseif(!$err){
                $file_name_parts=explode(".",$_FILES["file"]["name"]);
                $extension=$file_name_parts[count($file_name_parts)-1];
                $filename=time().".".$extension;
                $img_url="images".DIRECTORY_SEPARATOR.$filename;
                if(!move_uploaded_file($_FILES["file"]["tmp_name"],$img_url)){
                    $err=true;
                    $msg="Image error!";
                }
            }
            if(!$err){


                ProductDAO::add($_POST["name"],$_POST["producer_id"],$_POST["price"],$_POST["type_id"],$_POST["quantity"],$img_url);

            }

        }
    }
        include_once "View/addProduct.php";
    }

    public function edit(){
        $err=false;
        $msg='';
        if(isset($_POST["saveChanges"])){
            if(empty($_POST["name"]) || empty($_POST["producer_id"])
                || empty($_POST["price"]) || empty($_POST["type_id"])
                || empty($_POST["quantity"])) {
                $msg = "All fields are required!";
            }else{
                if(!preg_match('/^[0-9]+$/',$_POST["quantity"]) || !is_numeric($_POST["quantity"])){
                    $err=true;
                    $msg="Invalid quantity format!";
                }

                if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $_POST["price"]) ||  !is_numeric($_POST["quantity"])){
                    $err=true;
                    $msg="Invalid price format!";
                }

                if(!is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    $img_url= $_POST["old_image"];
                }else{
                    $file_name_parts=explode(".",$_FILES["file"]["name"]);
                    $extension=$file_name_parts[count($file_name_parts)-1];
                    $filename=time().".".$extension;
                    $img_url="images".DIRECTORY_SEPARATOR.$filename;
                    if(move_uploaded_file($_FILES["file"]["tmp_name"],$img_url)){
                        unlink($_POST["old_image"]);
                    }else{
                        $err=true;
                        $msg="Image error!";
                    }
                }
                if(!$err){
                    $product=new Product($_POST["product_id"],$_POST["name"],$_POST["producer_id"],$_POST["price"],$_POST["type_id"],$_POST["quantity"],$img_url);
                    ProductDAO::edit($product);

                }

            }

        }
        include_once "View/editProduct.php";
    }


    public function rate(){
    if(isset($_POST["save"])){
        $msg="";

        if(empty($_POST["rating"]) || empty($_POST["comment"])){
            $msg = "All fields are required!";
        }else{
            if(!preg_match('/^[1-5]+$/',$_POST["rating"]) ||  !is_numeric($_POST["rating"])){
                $msg = "Rating must be from 1 to 5!";
            }
            if(strlen($_POST["comment"])>100){
                $msg = "Comment must be maximum 100 characters!";
            }
            if($msg==""){
                ProductDAO::addRating($_SESSION["logged_user_id"],$_POST["product_id"],$_POST["rating"],$_POST["comment"]);
                include_once "View/rateProduct.php";
            }
        }
    }
    }
    public function editRate(){
        if(isset($_POST["saveChanges"])){
            $msg="";
            if(empty($_POST["rating"]) || empty($_POST["comment"])){
                $msg = "All fields are required!";
            }else{
                if(!preg_match('/^[1-5]+$/',$_POST["rating"]) ||  !is_numeric($_POST["rating"])){
                    $msg = "Rating must be from 1 to 5!";
                }
                if(strlen($_POST["comment"])>100){
                    $msg = "Comment must be maximum 100 characters!";
                }
                if($msg==""){
                    ProductDAO::editRating($_POST["rating_id"],$_POST["rating"],$_POST["comment"]);
                    include_once "View/myRated.php";
                }
            }
        }
    }

    public static function showStars($product_id){
        $product_stars=ProductDAO::getStarsCount($product_id);

        $starsCountArr=[];
        for($i=1;$i<=5;$i++) {
            $isZero = true;
            foreach ($product_stars as $product_star) {
                if ($product_star["stars"] == $i) {
                    $starsCountArr[$i] = $product_star["stars_count"];
                    $isZero = false;
                }
            }
            if($isZero) {
                $starsCountArr[$i] = 0;
            }
        }

        return $starsCountArr;
    }




    public function myRated(){
        include_once "View/myRated.php";
    }
    public function addProduct(){
        include_once "View/addProduct.php";
    }
    public function editProduct(){

        include_once "View/editProduct.php";
    }
    public function showProduct(){
    include_once "View/showProduct.php";
    }



    public function rateProduct(){
        include_once "View/rateProduct.php";
    }

    public function editRatedPage(){
        include_once "View/editRatedProduct.php";
    }




}