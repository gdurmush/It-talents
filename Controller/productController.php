<?php
namespace Controller;
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
        echo "Categorie Products";
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
                $product=new Product($_POST["name"],$_POST["producer_id"],$_POST["price"],$_POST["type_id"],$_POST["quantity"],$img_url);
                ProductDAO::add($product);

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
                $err = true;
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
                    $product=new Product($_POST["name"],$_POST["producer_id"],$_POST["price"],$_POST["type_id"],$_POST["quantity"],$img_url);
                    $product->setId($_POST["product_id"]);
                    ProductDAO::edit($product);

                }

            }

        }
        include_once "View/editProduct.php";
    }

    public function delete(){
    $id=1;  //only for test
        //if(isset($_POST["deleteProduct"])){
            ProductDAO::delete($id);

       // }
    }


    public function addProduct(){
        include_once "View/addProduct.php";
    }


    public function editProduct(){
        include_once "View/editProduct.php";
    }

}