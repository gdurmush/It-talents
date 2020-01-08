<?php
namespace Controller;
use Model\Address;
use Model\AddressDAO;
use model\CartDAO;
use model\OrderDAO;

class OrderController{
    public function order()
    {
        try{

            if (isset($_POST["order"])){
                $orderedProducts = CartDAO::showCart();

                OrderDAO::finishOrder($orderedProducts);

        }

        }
        catch (\PDOException $e){

        }


    }
    public function show(){
      include_once "View/orders.php";
    }
}