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

    public function getAllByType($id,$start,$productsPerPage){

         $pdo = getPDO();

        $sql = "SELECT * FROM products where type_id=? LIMIT ".$start.",".$productsPerPage.";";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_OBJ);

    }

    public function getAttributesByType($id){


        $pdo = getPDO();
        $sql = "SELECT distinct a.name, pha.value FROM attributes as a 
JOIN product_attributes as pha ON(a.id=pha.attribute_id)
where type_id=?;";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_OBJ);

    }
    public function getNumberOfProductsForType($id){

            $pdo = getPDO();
            $sql = "SELECT count(id) AS count FROM products where type_id=?;";
            $statement = $pdo->prepare($sql);
            $statement->execute([$id]);
            return $statement->fetch(PDO::FETCH_OBJ);

    }
    public function getTypes(){

        $pdo = getPDO();
        $sql = "SELECT * FROM emag.types;";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);

    }
    public function getCategories(){

        $pdo = getPDO();
        $sql = "SELECT * FROM emag.categories;";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);

    }
    public static function existsType($id){
      $params=[];
      $params[] = $id;
      $pdo = getPDO();
      $sql = "SELECT COUNT(id) as count FROM types WHERE id = ?";
      $statement = $pdo->prepare($sql);
      $statement->execute($params);
      return $statement->fetch(PDO::FETCH_ASSOC);
    }
}