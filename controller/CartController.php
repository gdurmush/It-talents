<?php
namespace controller;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Model\Address;
use Model\AddressDAO;
use model\CartDAO;
use model\ProductDAO;
use model\Cart;
use PDOException;
use PDO;
class CartController{
    public function add(){
        try{
            if (isset($_GET["id"])){

                $cartDAO=new CartDAO();
                $check = $cartDAO->checkIfInCart($_GET["id"]);
                if ($check)
                {
                    $cartDAO->updateQuantityOfProduct($_GET["id"]);
                    include_once "view/cart.php";
                }
                else{

                    $cartDAO->putInCart($_GET["id"]);
                    include_once "view/cart.php";

                }
            }
        }catch (\PDOException $e){
            include_once "view/main.php";
            echo "Oops, error 500!";

        }

    }

    public function show(){
        $userController=new UserController();
        $userController->validateForLoggedUser();

        include_once "view/cart.php";
    }
    public function update(){
        if (isset($_POST["updateQuantity"])) {
            try {
                $productDAO=new ProductDAO();
                $productQuantity = $productDAO->checkQuantity($_POST["productId"]);
                if ($productQuantity["quantity"] >= $_POST["quantity"]) {
                    $cartDAO=new CartDAO();
                    $cartDAO->updateCartQuantity($_POST["productId"], $_POST["quantity"]);
                    $this->show();
                } else {
                    $this->show();
                    echo "<h3>Quantity Not Available</h3>";
                }

            } catch (\PDOException $e) {
                include_once "view/main.php";
                echo "Oops, error 500!";

            }
        }

    }
    public function delete(){

        try{
            $cartDAO=new CartDAO();
            $cartDAO->deleteProductFromCart($_GET["productId"]);
            $this->show();
        }catch (\PDOException $e){
            include_once "view/main.php";
            echo "Oops, error 500!";

        }
    }
}


