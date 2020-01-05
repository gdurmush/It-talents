<?php
namespace model;
use model\Type;

class TypeDAO{
   static function getTypeInformation ($id){
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
  static  function getTypesFromCategorieId($id){
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
}