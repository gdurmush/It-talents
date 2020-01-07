<?php
namespace model;
use PDO;
use PDOException;

include_once "PDO.php";
class SearchDAO
{
   static function searchProduct ($keywords){
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

   static function searchCategorie ($keywords){
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

   static  function searchType ($keywords){
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
}
