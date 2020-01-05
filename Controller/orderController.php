<?php
namespace Controller;
use Model\Address;
use Model\AddressDAO;
use model\OrderDAO;

include_once dirname(__FILE__) . "/../Model/DBManager.php";
class OrderController{
    public function order()
    {
        try{

            if (isset($_POST["order"])){
                $orderedProducts = showCart();

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