<?php
namespace Model;
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
        catch (\PDOException $e){
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
            $sql="SELECT p.name, p.producer_id, pr.name AS producer_name,
                    p.price, p.type_id, t.name AS type_name,p.quantity,p.image_url
                    FROM products AS p 
                    JOIN producers AS pr ON(p.producer_id=pr.id)
                    JOIN types AS t ON (p.type_id=t.id)
                    WHERE p.id=?;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_OBJ);

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
    public static function edit(Product $product)
    {
        try {
            $db = getPDO();

            $params = [];
            $params[] = $product->name;
            $params[] = $product->getProducerId();
            $params[] = $product->price;
            $params[] = $product->getTypeId();
            $params[] = $product->quantity;
            $params[] = $product->imageUrl;
            $params[] = $product->getId();
            $sql = "UPDATE products SET name=?, producer_id=?,price=?, type_id=?, quantity=?, image_url=? WHERE id=? ;";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }




    public static function addRating($user_id,$product_id,$rating,$comment) {
        try {
            $db = getPDO();
            $params = [];
            $params[] = $user_id;
            $params[] = $product_id;
            $params[] = $rating;
            $params[] = $comment;

            $sql = "INSERT INTO user_rate_products (user_id, product_id, stars,text,date_created) VALUES (?,?,?,?,now());";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);


        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function editRating($id,$rating,$comment) {
        try {
            $db = getPDO();
            $params = [];
            $params[] = $rating;
            $params[] = $comment;
            $params[] = $id;

            $sql = "UPDATE user_rate_products SET stars=?, text=? WHERE id=? ;";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);


        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function showMyRated($user_id) {
        try {
            $db = getPDO();

            $sql="SELECT p.id AS product_id,p.name AS product_name,p.image_url,urp.id AS rating_id,urp.stars,urp.text
                    FROM user_rate_products AS urp
                    JOIN products AS p ON(p.id=urp.product_id)
                    WHERE urp.user_id=?;";
            $stmt=$db->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


public static function getAVGRating($product_id)
{
    try {
        $db = getPDO();

        $sql="SELECT round(avg(stars),2)  AS avg_stars  FROM user_rate_products WHERE product_id=?;";
        $stmt=$db->prepare($sql);
        $stmt->execute([$product_id]);
        return  $stmt->fetch(\PDO::FETCH_OBJ);


    } catch (\PDOException $e) {
        echo $e->getMessage();
    }
}
    public static function getStarsCount ($product_id)
    {
        try {
            $db = getPDO();

                $sql="SELECT stars,count(stars)  AS stars_count  FROM user_rate_products where product_id=? group by stars order by stars;";
                $stmt=$db->prepare($sql);
                $stmt->execute([$product_id]);
               return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
   static function getProductsFromTypeId($id){
        try{
            $params = [];
            $params[] = $id;
            $pdo = getPDO();
            $sql = "SELECT id , name FROM products WHERE type_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute($params);
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
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
        try{
            $pdo = getPDO();
            $sql = "SELECT id , name , producer_id , price , type_id , quantity , image_url FROM products WHERE id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute([$id]);
            $rows = $statement->fetch(PDO::FETCH_ASSOC);
            $product = new Product($rows["id"] , $rows["name"] , $rows["producer_id"] , $rows["price"] , $rows["type_id"]
                , $rows["quantity"] , $rows["image_url"]);

            return $product;
        }
        catch (PDOException $e){
            echo $e->getMessage();
        }
    }
    function decreaseProductQuantity($orderedProducts)
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





}
