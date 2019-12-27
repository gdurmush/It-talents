<?php
include_once "PDO.php";


function existUser($email){

    try{
        $pdo=getPDO();
        $sql="SELECT id, first_name, last_name ,password FROM users WHERE email=?;";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([$email]);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row;

    }
    catch (PDOException $e){
        echo $e->getMessage();
    }
}


function addUser(array &$user) {
    try {
        $db = getPDO();
        $params = [];
        $params[] = $user["email"];
        $params[] = $user["password"];
        $params[] = $user["first_name"];
        $params[] = $user["last_name"];
        $params[] = $user["phone_number"];
        $sql = "INSERT INTO users (email, password, first_name,last_name,phone_number,date_created) VALUES (?, ?, ?,?,?,now());";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        $user["id"]  = $db->lastInsertId();

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}