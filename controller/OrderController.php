<?php
namespace Controller;
use Model\Address;
use Model\AddressDAO;
use model\CartDAO;
use model\OrderDAO;
use PDOException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class OrderController{
    public function order()
    {

        try{
            if (isset($_POST["order"])){
                $orderedProducts = new CartDAO();
              $orderedProducts =  $orderedProducts->showCart($_SESSION["logged_user_id"]);
                /*echo json_encode($orderedProducts);*/
                OrderDAO::finishOrder($orderedProducts , $_POST["totalPrice"]);

        }

        }
        catch (PDOException $e){
          echo $e->getMessage();
        }
        $msg="Order received!";
        include_once "view/cart.php";
    }
    public function show(){
      include_once "View/orders.php";
    }
}