<?php
namespace Controller;
use Model\Address;
use Model\AddressDAO;
include_once dirname(__FILE__) . "/../Model/DBManager.php";
class OrderController{
    public function order()
    {
        try{

            if (isset($_POST["order"])){
                $orderedProducts = showCart();

                finishOrder($orderedProducts);

        }

        }
        catch (\PDOException $e){

        }


    }
    public function show(){
      include_once "View/orders.php";
    }
}