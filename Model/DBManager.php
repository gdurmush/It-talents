<?php

use model\Product;
use model\Type;

include_once "PDO.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function searchProduct ($keywords){
    try {
        $params = [];
        $params[] = "{$keywords}%";

        $pdo = getPDO();
        $sql = "SELECT id , name FROM products WHERE name LIKE ? LIMIT 4;";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

function searchCategorie ($keywords){
    try {
        $params = [];
        $params[] = "{$keywords}%";

        $pdo = getPDO();

        $sql = "
                SELECT c.id, c.name  FROM categories AS c  
			    WHERE name LIKE ?;";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

}

function searchType ($keywords){
    try {
        $params = [];
        $params[] = "{$keywords}%";

        $pdo = getPDO();
        $sql = "SELECT id, name FROM types WHERE name LIKE ? LIMIT 4;";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

}

function checkIfInCart($id){
    try {
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
    catch (PDOException $e){
      echo  $e->getMessage();
    }
}
function checkIfInFavourites($id){
    try {
        $params = [];
        $params[] = $id;
        $params[] = $_SESSION["logged_user_id"];
        $pdo = getPDO();
        $sql = "SELECT product_id FROM user_favourite_products WHERE product_id = ? AND user_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch (PDOException $e){
        echo  $e->getMessage();
    }
}
function putInCart($id){
    try {
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $id;
        $params[] = 1;
        $pdo = getPDO();
        $sql = "INSERT INTO cart (user_id , product_id , quantity) VALUES (?,?,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}
function updateQuantityOfProduct($id){
    try{

        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $id;
        $pdo = getPDO();
        $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}
function showCart (){
    try {
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $pdo = getPDO();
        $sql = "SELECT product_id , quantity FROM cart WHERE user_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    }
    catch (PDOException $e){
        echo  $e->getMessage();
    }
}

function checkQuantity ($id){
    try {
        $params = [];
        $params[] = $id;
        $pdo = getPDO();
        $sql = "SELECT quantity FROM products WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $quantity = $statement->fetch(PDO::FETCH_ASSOC);
        return $quantity;
    }
    catch (PDOException $e){
        echo  $e->getMessage();
    }
}
function updateCartQuantity($id , $quantity){
    try{
        $params = [];
        $params[] = $quantity;
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $id;
        $pdo = getPDO();
        $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

}
function deleteProductFromCart($id){
    try {
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $id;
        $pdo = getPDO();
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ? ";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

}
function showFavourites (){
    try{
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $pdo = getPDO();
        $sql = "SELECT product_id FROM user_favourite_products WHERE user_id = ? ";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows =$statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

}
function addToFavourites ($id){
    try{
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $id;
        $pdo =getPDO();
        $sql = "INSERT INTO user_favourite_products (user_id , product_id ) VALUES (? ,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }

}
function deleteFromFavourites ($id){
    try{

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
    $params = [];
    $params[] = $_SESSION["logged_user_id"];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "DELETE FROM user_favourite_products WHERE user_id = ? AND product_id = ? ";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
}

function getProductsFromTypeId($id){
    try{

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
    $params = [];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "SELECT id , name FROM products WHERE type_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $products;
}
function getTypeInformation ($id){
    try{
        $pdo = getPDO();
        $sql = "SELECT id , name , categorie_id FROM types WHERE id = ? ";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
        $type = new Type($rows["id"] , $rows["name"] , $rows["categorie_id"]);
        return $type;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }


}
function getTypesFromCategorieId($id){
    try{
        $params = [];
        $params[] = $id;
        $pdo = getPDO();
        $sql = "SELECT id , name , categorie_id FROM types WHERE categorie_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $types = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $types;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}
function addOrderProducts ($orderId , $orderedProducts){
    try{
        foreach ($orderedProducts as $product){
            $params = [];
            $params[] = $orderId;
            $params[] = $product["product_id"];
            $params[] = $product["quantity"];
            $pdo = getPDO();
            $sql = "INSERT INTO orders_have_products (order_id , product_id , quantity) VALUES (?,? ,?)";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
        }
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}
function addOrder ($addressId){
    try{
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $addressId;
        $pdo = getPDO();
        $sql = "INSERT INTO orders (user_id , address_id) VALUES (?,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $id = $pdo->lastInsertId();
        return $id;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

function deleteCart (){
    try {
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $pdo = getPDO();
        $sql = "DELETE FROM cart WHERE user_id = ? ";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

function decreaseProductQuantity($orderedProducts)
{
    try{
        foreach ($orderedProducts as $product) {
            $params = [];
            $params[] = $product["quantity"];
            $params[] = $product["product_id"];
            $pdo = getPDO();
            $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
        }
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}
function showOrders(){
    try{
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $pdo = getPDO();
        $sql = "SELECT o.address_id , op.product_id , op.quantity , p.name ,p.image_url , o.date_created  FROM orders as o
            JOIN orders_have_products as op
            ON o.id = op.order_id 
            JOIN products as p ON p.id = op.product_id
            WHERE o.user_id = ? ORDER BY o.date_created";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}
function findProduct ($id){
    try{
        $pdo = getPDO();
        $sql = "SELECT id , name , producer_id , price , type_id , quantity , image_url FROM products WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $rows = $statement->fetch(PDO::FETCH_ASSOC);
        $product = new Product($rows["id"] , $rows["name"] , $rows["producer_id"] , $rows["price"] , $rows["type_id"]
            , $rows["quantity"] , $rows["image_url"]);

        return $product;
    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}

function finishOrder($orderedProducts){
    try{
        $pdo = getPDO();
        $pdo->beginTransaction();
        $id = addOrder($_POST["address"]);
        addOrderProducts($id , $orderedProducts);
        decreaseProductQuantity($orderedProducts);
        deleteCart();
        $pdo->commit();
    }
    catch (PDOException $e){
        $pdo->rollBack();
        echo $e->getMessage();
    }
}