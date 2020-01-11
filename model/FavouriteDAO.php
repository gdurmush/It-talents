<?php
namespace model;
use PDO;
use PDOException;

include_once "PDO.php";
class FavouriteDAO{
    public function showFavourites (){

        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $pdo = getPDO();
        $sql = "SELECT product_id FROM user_favourite_products WHERE user_id = ? ";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows =$statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
    public function addToFavourites ($id){

        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $id;
        $pdo =getPDO();
        $sql = "INSERT INTO user_favourite_products (user_id , product_id ) VALUES (? ,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);

    }
    public function deleteFromFavourites ($id){
        $params = [];
        $params[] = $_SESSION["logged_user_id"];
        $params[] = $id;
        $pdo = getPDO();
        $sql = "DELETE FROM user_favourite_products WHERE user_id = ? AND product_id = ? ";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
    }

    public function checkIfInFavourites($id , $userId){
        $params = [];
        $params[] = $id;
        $params[] = $userId;
        $pdo = getPDO();
        $sql = "SELECT product_id FROM user_favourite_products WHERE product_id = ? AND user_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rows;

    }

}