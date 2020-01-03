<?php

namespace Controller;


use Model\User;
use Model\UserDAO;

class userController{

const MIN_LENGTH=8;

    public function login(){
        if(isset($_POST["login"])) {
            $err = false;
            $msg='';
            if (!isset($_POST["email"]) || !isset($_POST["password"])) {
                $err = true;
                $msg='All fields are required!';
            } elseif (strlen($_POST["password"]) < self::MIN_LENGTH) {
                $err = true;
                $msg='Invalid username or password!';
            } else {
                $user = UserDAO::getUserByEmail($_POST["email"]);
                if ($user) {
                    if (password_verify($_POST["password"], $user->password)) {
                        $_SESSION["logged_user_id"] = $user->id;
                    } else {
                        $err = true;
                        $msg='Invalid username or password!';
                    }
                }
            }
            if(!$err){
                include_once "View/main.php";
            }else{
                include_once "View/login.php";
            }
        }
    }

    public function register(){
        $msg=$this->validate($_POST["email"],$_POST["password"],$_POST["first_name"],$_POST["last_name"],$_POST["phone_number"],$_POST["age"]);

        $result=UserDAO::getUserByEmail($_POST["email"]);
        if($result){
            $msg="This email already exist!";
        }

        if($msg==""){
            $role="user";
            $password=password_hash($_POST["password"],PASSWORD_BCRYPT);
            $user = new User($_POST["email"],$password,$_POST["first_name"],$_POST["last_name"],$_POST["age"],$_POST["phone_number"],$role);
            UserDAO::add($user);

            $_SESSION["logged_user_id"]=$user->getId();

            include_once "View/main.php";
        }else{
            include_once "View/register.php";
        }
    }






    public function edit(){
        $msg = '';
        $result=UserDAO::getUserById($_SESSION["logged_user_id"]);

        $msg=$this->validate($_POST["email"],$_POST["accountPassword"],$_POST["first_name"],$_POST["last_name"],$_POST["phone_number"],$_POST["age"]);


        if(password_verify($_POST["accountPassword"],$result->password)==false) {
            $msg = "Incorrect account password!";
        }

        if(empty($_POST["newPassword"])){
            $password=$result->password;
        }else {
            if (strlen($_POST["newPassword"]) < self::MIN_LENGTH) {
                $msg = "Your password must be at least 8 characters!";
            }else {
                $password=password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
            }

        }


        if($msg==""){
            $user=new User($_POST["email"],$password,$_POST["first_name"],$_POST["last_name"],$_POST["age"],$_POST["phone_number"],false);
            $user->setId($_SESSION["logged_user_id"]);
            UserDAO::update($user);
            $msg="You successfully update your account";
        }
        include_once "View/editProfile.php";
    }



 public function validate($email,$password,$firstName,$lastName,$phone_number,$age){
        $msg = '';
        if (empty($email) || empty($password)
            || empty($firstName) || empty($lastName)
            || empty($phone_number) || empty($age)) {
            $msg = "All fields are required!";
        }
        if (strlen($password) < self::MIN_LENGTH) {
            $msg = "Your password must be at least 8 characters!";
        }


        if(!preg_match('/^[8][0-9]{8}$/', $phone_number)) {
            $msg="Invalid Number format!";
        }
        if ($age < 18) {
            $msg = "You must be at least 18 years old to create account!";
        }

        if(!ctype_alpha($firstName) || !ctype_alpha($lastName)){
            $msg = "Invalid name format";
        }
        return $msg;
    }

    public function loginPage(){
        include_once "View/login.php";
    }

    public function registerPage(){
        include_once "View/register.php";
    }
    public function account(){
        include_once "View/account.php";
    }

    public function editPage(){
        include_once "View/editProfile.php";
    }


}

