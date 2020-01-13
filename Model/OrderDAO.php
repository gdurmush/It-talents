<?php
namespace model;
use model\CartDAO;
use model\ProductDAO;
use PDO;
use PDOException;
include_once "PDO.php";
class OrderDAO
{

    static function addOrderProducts($orderId, $orderedProducts)
    {
            foreach ($orderedProducts as $product) {
                $params = [];
                $params[] = $orderId;
                $params[] = $product["product_id"];
                $params[] = $product["quantity"];
                $params[] = $product["price"];
                $pdo = getPDO();
                $sql = "INSERT INTO orders_have_products (order_id , product_id , quantity,price) VALUES (?,? ,? ,?)";
                $statement = $pdo->prepare($sql);
                $statement->execute($params);
            }
    }

    static function addOrder($addressId, $totalPrice)
    {
            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $params[] = $addressId;
            $params[] = $totalPrice;
            $pdo = getPDO();
            $sql = "INSERT INTO orders (user_id , address_id , price) VALUES (?,?,?)";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $id = $pdo->lastInsertId();
            return $id;
    }

    static function showOrders()
    {
            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $pdo = getPDO();
            $sql = "SELECT o.id, o.address_id , op.product_id , op.quantity, o.price,op.price as productPrice, p.name ,p.image_url , o.date_created  FROM orders as o
            JOIN orders_have_products as op
            ON o.id = op.order_id 
            JOIN products as p ON p.id = op.product_id
            WHERE o.user_id = ? ORDER BY o.date_created";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $rows;

    }

    static  function finishOrder($orderedProducts , $totalPrice){

        $id = OrderDAO::addOrder($_POST["address"], $totalPrice);
        OrderDAO::addOrderProducts($id , $orderedProducts);
        $quantity = new ProductDAO();
        $quantity->decreaseProductQuantity($orderedProducts);
        $cart = new CartDAO();
        $cart->deleteCart();

    }
}

