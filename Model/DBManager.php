<?php
include_once "PDO.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function existUser($email){

    try{
        $pdo=getPDO();
        $sql="SELECT id, first_name, last_name ,password FROM users WHERE email=?;";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$email]);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}


function addUser(array &$user) {
    try {
        $db = getPDO();
        $params = [];
        $params[] = $user["email"];
        $params[] = $user["password"];
        $params[] = $user["first_name"];
        $params[] = $user["last_name"];
        $params[] = $user["phone_number"];
        $sql = "INSERT INTO users (email, password, first_name,last_name,phone_number,date_created) VALUES (?, ?, ?,?,?,now());";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $user["id"]  = $db->lastInsertId();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

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
        $params[] = "{$keywords}%";
        $params[] = "{$keywords}%";

        $pdo = getPDO();

        $sql = "SELECT  c.name  FROM categories AS c
                WHERE name LIKE ?
                UNION
                SELECT s.name  FROM sub_categories AS s
                WHERE name LIKE ?
                UNION
                SELECT t.name  FROM types AS t  
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

function searchProducer ($keywords){
    try {
        $params = [];
        $params[] = "{$keywords}%";

        $pdo = getPDO();
        $sql = "SELECT id, name FROM producers WHERE name LIKE ? LIMIT 4;";
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