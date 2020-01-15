<?php
namespace model;

use PDO;
use PDOException;

//include_once "PDO.php";
class CartDAO{

  public  function checkIfInCart($id , $userId){

            $params = [];
            $params[] = $id;
            $params[] = $userId;
            $pdo = getPDO();
            $sql = "SELECT user_id , product_id , quantity FROM cart WHERE product_id = ? AND user_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $rows = $statement->fetch(PDO::FETCH_ASSOC);
            return $rows;
    }

    public  function putInCart($productId , $userId){

            $params = [];
            $params[] = $userId;
            $params[] = $productId;
            $params[] = 1;
            $pdo = getPDO();
            $sql = "INSERT INTO cart (user_id , product_id , quantity) VALUES (?,?,?)";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
    }
    public function updateQuantityOfProductInCart($id , $userId){


            $params = [];
            $params[] = $userId;
            $params[] = $id;
            $pdo = getPDO();
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);

    }
    public function showCart ($id){

            $params = [];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "SELECT c.product_id , c.quantity , price*c.quantity as price 
                    FROM cart as c JOIN products as p on c.product_id = p.id  WHERE user_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;


    }
    public  function updateCartQuantity($id , $quantity ,$userId){

            $params = [];
            $params[] = $quantity;
            $params[] = $userId;
            $params[] = $id;
            $pdo = getPDO();
            $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);


    }
    public  function deleteProductFromCart($id , $userId){

            $params = [];
            $params[] = $userId;
            $params[] = $id;
            $pdo = getPDO();
            $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ? ";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);

    }
    public  function deleteCart ($userId){

            $params = [];
            $params[] = $userId;
            $pdo = getPDO();
            $sql = "DELETE FROM cart WHERE user_id = ? ";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);

    }
}