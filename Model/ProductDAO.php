<?php
namespace Model;
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

    public static function add(Product $product) {
        try {
            $db = getPDO();
            $params = [];
            $params[] = $product->name;
            $params[] = $product->getProducerId();
            $params[] = $product->price;
            $params[] = $product->getTypeId();
            $params[] = $product->quantity;
            $params[] = $product->imageUrl;
            $sql = "INSERT INTO products (name, producer_id, price,type_id,quantity,image_url,date_created) VALUES (?,?,?,?,?,?,now());";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $product->setId($db->lastInsertId());

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


    public static function delete($id){
        try {
            $db = getPDO();
            $sql = "DELETE FROM products WHERE id=? ;";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);

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

        $sql="SELECT round(avg(stars),2)  AS avg_stars  FROM user_rate_products WHERE product_id;";
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

                $sql="SELECT stars,count(stars)  AS stars_count  FROM user_rate_products where product_id=? group by stars;";
                $stmt=$db->prepare($sql);
                $stmt->execute([$product_id]);
               return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }





}
