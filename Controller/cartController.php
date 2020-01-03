<?php
namespace Controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";
use Model\Address;
use Model\AddressDAO;

class CartController{
    public function add(){
        if (isset($_GET["id"])){
           $check = checkIfInCart($_GET["id"]);
           if ($check)
           {
                updateQuantityOfProduct($_GET["id"]);
           }
           else{
               try {
                   putInCart($_GET["id"]);
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
      $b =  checkQuantity($_POST["productId"]);
      if ($b <= $_POST["quantity"]) {
          updateCartQuantity($_POST["productId"], $_POST["quantity"]);
          $this->show();
      }
      else{
          echo "<h3>Quantity Not Available</h3>";
      }
    }
    public function delete(){
        deleteProductFromCart($_GET["productId"]);
        $this->show();
    }
}


