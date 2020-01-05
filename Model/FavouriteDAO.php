<?php
namespace model;
use PDO;
use PDOException;
class FavouriteDAO{
    static function showFavourites (){
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
 static function addToFavourites ($id){
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
   static function deleteFromFavourites ($id){
        try{
            $params = [];
            $params[] = $_SESSION["logged_user_id"];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "DELETE FROM user_favourite_products WHERE user_id = ? AND product_id = ? ";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    static function checkIfInFavourites($id){
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
}