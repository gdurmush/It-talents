<?php



namespace Model;
include_once "PDO.php";

class UserDAO{
    public static function getUserByEmail($email){
        try{
            $pdo=getPDO();
            $sql="SELECT * FROM users WHERE email=?;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch(\PDO::FETCH_OBJ);

        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function getUserById($id){
        try{
            $pdo=getPDO();
            $sql="SELECT * FROM users WHERE id=?;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_OBJ);

        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function add(User $user){
        try {
            $db = getPDO();
            $params = [];
            $params[] = $user->getEmail();
            $params[] = $user->getPassword();
            $params[] = $user->getFirstName();
            $params[] = $user->getLastName();
            $params[] = $user->getAge();
            $params[] = $user->getPhoneNumber();
            $params[] = $user->getRole();
            $sql = "INSERT INTO users (email, password, first_name,last_name,age,phone_number,role,date_created) VALUES (?, ?, ?,?,?,?,?,now());";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $user->setId($db->lastInsertId());

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }



    public static function update(User $user){
        try {
            $db = getPDO();
            $params = [];
            $params[] = $user->getEmail();
            $params[] = $user->getPassword();
            $params[] = $user->getFirstName();
            $params[] = $user->getLastName();
            $params[] = $user->getAge();
            $params[] = $user->getPhoneNumber();
            $params[] = $user->getId();

            $sql = "UPDATE users SET email=?, password=?, first_name=?,last_name=?,age=?,phone_number=? WHERE id=? ;";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

}