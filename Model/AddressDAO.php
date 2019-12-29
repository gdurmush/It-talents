<?php

namespace Model;
include_once "PDO.php";
class AddressDAO{
    public static function getById($id){

        try{
            $pdo=getPDO();
            $sql="SELECT a.id, a.city_id, c.name AS city_name,a.street_name 
                    FROM addresses AS a JOIN cities AS c ON(a.city_id=c.id)WHERE a.id=?;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_OBJ);

        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getCities(){

        try{
            $pdo=getPDO();
            $sql="SELECT * FROM cities;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }
    }


    public static function add(Address $address) {
        try {
            $db = getPDO();
            $params = [];
            $params[] = $address->getUserId();
            $params[] = $address->getCityId();
            $params[] = $address->getStreetName();
            $sql = "INSERT INTO addresses (user_id, city_id, street_name,date_created) VALUES (?, ?, ?,now());";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $address->setId($db->lastInsertId());

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


    public static function getAll($user_id) {
        try {
            $db = getPDO();
            $sql = "SELECT a.id, c.name AS city_name,a.street_name 
                    FROM addresses AS a JOIN cities AS c ON(a.city_id=c.id)WHERE user_id=?;";
            $stmt = $db->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function edit(Address $address)
    {
        try {
            $db = getPDO();

            $params = [];
            $params[] = $address->getCityId();
            $params[] = $address->getStreetName();
            $params[] = $address->getId();
            $sql = "UPDATE addresses SET city_id=?, street_name=? WHERE id=? ;";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }


    }

    public static function delete($id)
    {
        try {
            $db = getPDO();
            $sql = "DELETE FROM addresses WHERE id=? ;";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }


    }

}