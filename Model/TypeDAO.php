<?php
namespace model;
use model\Type;
use PDOException;
use PDO;
include_once "PDO.php";

class TypeDAO{
   static function getTypeInformation ($id){

            $pdo = getPDO();
            $sql = "SELECT id , name , categorie_id FROM types WHERE id = ? ";
            $statement = $pdo->prepare($sql);
            $statement->execute([$id]);
            $rows = $statement->fetch(PDO::FETCH_ASSOC);
            $type = new Type($rows["id"] , $rows["name"] , $rows["categorie_id"]);
            return $type;

    }
  static function getTypesFromCategorieId($id){

            $params = [];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "SELECT id , name , categorie_id FROM types WHERE categorie_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $types = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $types;
        }


}