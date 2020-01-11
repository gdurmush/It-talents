<?php
namespace controller;

use model\CartDAO;
use model\OrderDAO;

class OrderController{
    public function order(){
        if (isset($_POST["order"])){
            try{
                $cartDAO=new CartDAO();
                $orderedProducts = $cartDAO->showCart();

                $orderDAO=new OrderDAO();
                $orderDAO->finishOrder($orderedProducts);
            }catch (\PDOException $e){
                include_once "view/main.php";
                echo "Oops, error 500!";

            }

        }

    }


    public function show(){
      include_once "view/orders.php";
    }
}