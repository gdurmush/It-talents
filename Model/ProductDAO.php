<?php
namespace model;
use PDO;
use PDOException;

include_once "PDO.php";

class ProductDAO{

    public static function getProducers(){

        try{
            $pdo=getPDO();
            $sql="SELECT * FROM producers;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getTypes(){

        try{
            $pdo=getPDO();
            $sql="SELECT * FROM types;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }
    }
    public static function getById($id){

        try{
            $pdo=getPDO();
            $sql=   "SELECT p.name, p.producer_id, pr.name AS producer_name,
                    p.price,p.old_price, p.type_id, t.name AS type_name,p.quantity,p.image_url
                    FROM products AS p 
                    JOIN producers AS pr ON(p.producer_id=pr.id)
                    JOIN types AS t ON (p.type_id=t.id)
                    WHERE p.id=?;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);

        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function add($product_name,$producer_id,$product_price,$type_id,$quantity,$image_url) {
        try {
            $db = getPDO();
            $params = [];
            $params[] = $product_name;
            $params[] = $producer_id;
            $params[] = $product_price;
            $params[] = $type_id;
            $params[] = $quantity;
            $params[] = $image_url;
            $sql = "INSERT INTO products (name, producer_id, price,type_id,quantity,image_url,date_created) VALUES (?,?,?,?,?,?,now());";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $product_id=($db->lastInsertId());
            new Product($product_id,$product_name,$producer_id,$product_price,$type_id,$quantity,$image_url);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function edit(array $product)
    {
        try {
            $db = getPDO();

            $params = [];
            $params[] = $product["name"];
            $params[] = $product["producer_id"];
            $params[] = $product["price"];
            $params[]=$product["old_price"];
            $params[] = $product["type_id"];
            $params[] = $product["quantity"];
            $params[] = $product["image_url"];
            $params[] = $product["product_id"];

            $sql = "UPDATE products SET name=?, producer_id=?,price=?,old_price=?, type_id=?, quantity=?, image_url=? WHERE id=? ;";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

   static function getProductsFromTypeId($id){
            $params = [];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "SELECT id , name FROM products WHERE type_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $products;

    }
    static function getProductsFromTypeIdAsc($id){

            $params = [];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "SELECT id , name FROM products WHERE type_id = ? ORDER BY price ASC";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        }

    static function getProductsFromTypeIdDesc($id){

            $params = [];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "SELECT id , name FROM products WHERE type_id = ? ORDER BY price DESC";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $products;

    }
    public  static function filterProducts ($filters,$args){
       // echo $filters . "\n\n";
        $pdo = getPDO();
        $sql = $filters;
        $statement = $pdo->prepare($sql);
        $statement->execute($args);
        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($products);
        error_log(json_encode($products));
    }


   static function checkQuantity ($id){
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

   static function findProduct ($id){

            $pdo = getPDO();
            $sql = "SELECT id , name , producer_id , price , type_id , quantity , image_url FROM products WHERE id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute([$id]);
            $rows = $statement->fetch(PDO::FETCH_ASSOC);
            $product = new Product($rows["id"] , $rows["name"] , $rows["producer_id"] , $rows["price"] , $rows["type_id"]
                , $rows["quantity"] , $rows["image_url"]);

            return $product;
    }
   static function decreaseProductQuantity($orderedProducts)
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
    static function getProductAttributes ($id){

            $params = [];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "SELECT name  FROM attributes WHERE type_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

       static function getAttributeValues($typeId , $attributeName){
          $params = [];
          $params [] = $typeId;
          $params [] = $attributeName;
          $pdo = getPDO();
          $sql =" SELECT DISTINCT value FROM product_attributes JOIN attributes ON attribute_id = id WHERE type_id = ? AND name = ?";
          $statement = $pdo->prepare($sql);
          $statement->execute($params);
          return $statement->fetchAll(PDO::FETCH_ASSOC);
}


    public static function removePromotion($product_id,$price)
    {
        try {
            $db = getPDO();

            $params=[];
            $params[]=$price;
            $params[]=$product_id;
            $sql = "UPDATE products SET price=?, old_price=NULL WHERE id=? ;";
            $stmt=$db->prepare($sql);
            $stmt->execute($params);


        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getUserEmailsByLikedProduct($productId){

        $db = getPDO();
        $params = [];
        $params[] = $productId;
        $sql = "SELECT email FROM users as u JOIN user_favourite_products as uf ON u.id = uf.user_id
         WHERE uf.product_id = ? and u.subscription = 'yes'";
        $statement = $db->prepare($sql);
        $statement->execute($params);
        $emails = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $emails;

    }



}
