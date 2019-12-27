<?php



namespace Model;
include_once "PDO.php";

class UserDAO{
    public function getByEmailPassword($email){
        try{
            $pdo=getPDO();
            $sql="SELECT * FROM users WHERE email=?;";
            $stmt=$pdo->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);

        }
        catch (\PDOException $e){
            echo $e->getMessage();
        }
    }

    public function add(User $user){
        try {
            $db = getPDO();
            $params = [];
            $params[] = $user->email;
            $params[] = $user->password;
            $params[] = $user->first_name;
            $params[] = $user->last_name;
            $params[] = $user->age;
            $params[] = $user->phone_number;
            $params[] = $user->is_admin;
            $sql = "INSERT INTO users (email, password, first_name,last_name,age,phone_number,is_admin,date_created) VALUES (?, ?, ?,?,?,?,?,now());";
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $user->id  = $db->lastInsertId();

        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function edit(){

    }
    public function delete(){

    }
}