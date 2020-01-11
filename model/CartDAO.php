<?php
namespace model;

use PDO;
use PDOException;

include_once "PDO.php";
class CartDAO{
  public  function checkIfInCart($id){

            $params = [];
            $params[] = $id;
            $params[] = $_SESSION["logged_user_id"];
            $pdo = getPDO();
            $sql = "SELECT user_id , product_id , quantity FROM cart WHERE product_id = ? AND user_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
    }

    public  function putInCart($id){

            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $params[] = $id;
            $params[] = 1;
            $pdo = getPDO();
            $sql = "INSERT INTO cart (user_id , product_id , quantity) VALUES (?,?,?)";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
    }
    public function updateQuantityOfProduct($id){


            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);

    }
    public function showCart (){

            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $pdo = getPDO();
            $sql = "SELECT product_id , quantity FROM cart WHERE user_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;


    }
    public  function updateCartQuantity($id , $quantity){

            $params = [];
            $params[] = $quantity;
            $params[] = $_SESSION["logged_user_id"];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);


    }
    public  function deleteProductFromCart($id){

            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ? ";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);

    }
    public  function deleteCart (){

            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $pdo = getPDO();
            $sql = "DELETE FROM cart WHERE user_id = ? ";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);

    }
}