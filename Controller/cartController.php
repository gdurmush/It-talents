<?php
namespace Controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";
use Model\Address;
use Model\AddressDAO;
use model\CartDAO;
use Model\ProductDAO;
use model\Cart;
use PDOException;
use PDO;
class CartController{
    public function add(){
        if (isset($_GET["id"])){
           $check = CartDAO::checkIfInCart($_GET["id"]);
           if ($check)
           {
               CartDAO::updateQuantityOfProduct($_GET["id"]);
           }
           else{
               try {
                   CartDAO::putInCart($_GET["id"]);
               }
               catch (PDOException $exception){

               }
           }
        }
    }

    public function show(){
        include_once "View/cart.php";
    }
    public function update(){
        if (isset($_POST["updateQuantity"])){
            $productQuantity =  ProductDAO::checkQuantity($_POST["productId"]);
            if ($productQuantity["quantity"] >= $_POST["quantity"]) {
                CartDAO::updateCartQuantity($_POST["productId"], $_POST["quantity"]);
                $this->show();
            }
            else{
                $this->show();
                echo "<h3>Quantity Not Available</h3>";
            }
        }

    }
    public function delete(){
        CartDAO::deleteProductFromCart($_GET["productId"]);
        $this->show();
    }
}


