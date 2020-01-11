<?php
namespace model;

use PDO;
include_once "PDO.php";

class TypeDAO{
  public function getTypeInformation ($id){

            $pdo = getPDO();
            $sql = "SELECT id , name , categorie_id FROM types WHERE id = ? ";
            $statement = $pdo->prepare($sql);
            $statement->execute([$id]);
            $rows = $statement->fetch(PDO::FETCH_ASSOC);
            $type = new Type($rows["id"] , $rows["name"] , $rows["categorie_id"]);
            return $type;

    }
  public function getTypesFromCategorieId($id){

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