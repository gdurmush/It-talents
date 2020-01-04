<?php
namespace Controller;
use Model\Address;
use Model\AddressDAO;
include_once dirname(__FILE__) . "/../Model/DBManager.php";
class OrderController{

    public function order()
    {
        if (isset($_POST["order"])){
           $orderedProducts = showCart();
            $id = addOrder($_POST["address"]);
                addOrderProducts($id , $orderedProducts);
            decreaseProductQuantity($orderedProducts);
                deleteCart();



//            addOrder($_POST["totalPrice"] , $_POST["address"] , $_POST["orderedProducts"]);
        }


    }
    public function show(){
      include_once "View/orders.php";
    }
}