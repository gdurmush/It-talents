<?php
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

function findProduct ($id){
    $pdo = getPDO();
    $sql = "SELECT id , name , producer_id , price , type_id , quantity , image_url FROM products WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$id]);
    $rows = $statement->fetch(PDO::FETCH_ASSOC);
   $product = new \model\Product($rows["id"] , $rows["name"] , $rows["producer_id"] , $rows["price"] , $rows["type_id"]
       , $rows["quantity"] , $rows["image_url"]);

    return $product;

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
    $params = [];
    $params[] = $_SESSION["logged_user_id"];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);

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
        $params[] = $_SESSION["logged_user_id"];
        $pdo = getPDO();
        $sql = "SELECT quantity FROM products WHERE product_id = ? AND user_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $quantity = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $quantity;
    }
    catch (PDOException $e){
        echo  $e->getMessage();
    }
}

function updateCartQuantity($id , $quantity){
    $params = [];
    $params[] = $quantity;
    $params[] = $_SESSION["logged_user_id"];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);

}
function deleteProductFromCart($id){
    $params = [];
    $params[] = $_SESSION["logged_user_id"];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ? ";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
}
function showFavourites (){
    $params = [];
    $params[] = $_SESSION["logged_user_id"];
    $pdo = getPDO();
    $sql = "SELECT product_id FROM user_favourite_products WHERE user_id = ? ";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $rows =$statement->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function addToFavourites ($id){
    $params = [];
    $params[] = $_SESSION["logged_user_id"];
    $params[] = $id;
    $pdo =getPDO();
    $sql = "INSERT INTO user_favourite_products (user_id , product_id ) VALUES (? ,?)";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
}
function deleteFromFavourites ($id){
    $params = [];
    $params[] = $_SESSION["logged_user_id"];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "DELETE FROM user_favourite_products WHERE user_id = ? AND product_id = ? ";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
}

function getProductsFromTypeId($id){
    $params = [];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "SELECT id , name FROM products WHERE type_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $products;
}
function findCategorie ($id){
    $pdo = getPDO();
    $sql = "SELECT id , name FROM categories WHERE id = ? ";
    $statement = $pdo->prepare($sql);
    $statement->execute([$id]);
    $rows = $statement->fetch(PDO::FETCH_ASSOC);
    $categorie = new Categories($rows["id"] , $rows["name"]);
    return $categorie;

}
function getTypesFromCategorieId($id){
    $params = [];
    $params[] = $id;
    $pdo = getPDO();
    $sql = "SELECT id , name , categorie_id FROM types WHERE categorie_id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $types = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $types;
}
function addOrderProducts ($orderId , $orderedProducts){
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
function addOrder ($addressId){
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

function deleteCart (){
    $params = [];
    $params[] = $_SESSION["logged_user_id"];
    $pdo = getPDO();
    $sql = "DELETE FROM cart WHERE user_id = ? ";
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
}

function showOrders(){
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