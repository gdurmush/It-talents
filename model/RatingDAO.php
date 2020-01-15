<?php
namespace model;

include_once "PDO.php";
class RatingDAO
{




    public  function getRatingById($rating_id)
    {
        $db = getPDO();
        $sql = "SELECT * FROM user_rate_products WHERE id=?;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$rating_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);

    }

    public function addRating($user_id, $product_id, $rating, $comment)
    {
        $db = getPDO();
        $params = [];
        $params[] = $user_id;
        $params[] = $product_id;
        $params[] = $rating;
        $params[] = $comment;

        $sql = "INSERT INTO user_rate_products (user_id, product_id, stars,text,date_created) VALUES (?,?,?,?,now());";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
    }

    public function editRating($id, $rating, $comment)
    {
        $db = getPDO();
        $params = [];
        $params[] = $rating;
        $params[] = $comment;
        $params[] = $id;

        $sql = "UPDATE user_rate_products SET stars=?, text=? WHERE id=? ;";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);

    }

    public static function showMyRated($user_id)
    {

        $db = getPDO();

        $sql = "SELECT p.id AS product_id,p.name AS product_name,p.image_url,urp.id AS rating_id,urp.stars,urp.text
                    FROM user_rate_products AS urp
                    JOIN products AS p ON(p.id=urp.product_id)
                    WHERE urp.user_id=?;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }


    public function getReviewsNumber($product_id)
    {
        $db = getPDO();

        $sql = "SELECT round(avg(stars),2)  AS avg_stars , count(id) AS reviews_count FROM user_rate_products WHERE product_id=?;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public  function getStarsCount($product_id)
    {
        $db = getPDO();

        $sql = "SELECT stars,count(stars)  AS stars_count  FROM user_rate_products where product_id=? group by stars order by stars;";
        $stmt = $db->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function getComments($product_id)
    {
        $db = getPDO();

        $sql = "SELECT concat(u.first_name,\" \", u.last_name) AS full_name,
                    urp.stars,urp.text, cast(urp.date_created AS date) AS date FROM users AS u
                    JOIN user_rate_products AS urp ON(u.id=urp.user_id) WHERE product_id=?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);

    }

}