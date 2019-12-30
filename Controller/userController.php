<?php

namespace Controller;


use Model\User;
use Model\UserDAO;

class userController{

const MIN_LENGTH=8;

    public function login(){
        $email=$_POST["email"];
        $password=$_POST["password"];
        $err=false;

        if(!isset($email) || !isset($password)){
            $err=true;

        }elseif(strlen($password)<self::MIN_LENGTH){
            $err=true;
        }else{
            $user=UserDAO::getUserByEmail($email);


            if($user){
                if(password_verify($_POST["password"],$user->password)){
                    $_SESSION["logged_user_id"]=$user->id;
                }else{
                    $err=true;
                }
            }
        }

        if(!$err){
            include_once "View/main.php";
        }else{
            include_once "View/login.php";
        }
    }

    public function register(){

        $err=false;
        $msg='';

        if(!isset($_POST["email"]) || !isset($_POST["password"])
            || !isset($_POST["first_name"]) || !isset($_POST["last_name"])
            || !isset($_POST["phone_number"]) || !isset($_POST["age"]) ){

            $err=true;
            $msg="All fields are required!";
        }
//TODO verifier for password,age,phone_number

//TODO phone_number validate

        if(strlen($_POST["password"])<self::MIN_LENGTH){
            $err=true;
            $msg="Your password must be at least 8 characters!";
        }

        if(!preg_match('/^[0-9]{10}$/', $_POST["phone_number"])) {
            $err=true;
            $msg="Invalid Number!";
        }
        if($_POST["age"]<18) {
            $err=true;
            $msg="You must be at least 18 years old to create account!";
        }


        $result=UserDAO::getUserByEmail($_POST["email"]);
        if($result){
            $err=true;
            $msg="This email already exist!";
        }
        if(!$err){
            $isAdmin="false";
            $password=password_hash($_POST["password"],PASSWORD_BCRYPT);
            $user = new User($_POST["email"],$password,$_POST["first_name"],$_POST["last_name"],$_POST["age"],$_POST["phone_number"],$isAdmin);
            UserDAO::add($user);
            $_SESSION["logged_user_id"]=$user->getId();


            include_once "View/main.php";
        }else{
            include_once "View/register.php";
        }

    }



    public function edit(){
        $err = false;
        $msg = '';
        $result=UserDAO::getUserById($_SESSION["logged_user_id"]);


        if (empty($_POST["email"]) || empty($_POST["accountPassword"])
            || empty($_POST["first_name"]) || empty($_POST["last_name"])
            || empty($_POST["phone_number"]) || empty($_POST["age"])) {
            $err = true;
            $msg = "Fields must not be empty";
        }
        if (strlen($_POST["accountPassword"]) < self::MIN_LENGTH) {
            $err = true;
            $msg = "Your password must be at least 8 characters!";
        }


        if (!preg_match('/^[0-9]{10}+$/', $_POST["phone_number"])) {
            $err = true;
            $msg = "Invalid Number!";
        }
        if ($_POST["age"] < 18) {
            $err = true;
            $msg = "You must be at least 18 years old to create account!";
        }

        if(password_verify($_POST["accountPassword"],$result->password)==false) {
            $err = true;
            $msg = "Incorrect account password!";
        }

        if(empty($_POST["newPassword"])){
            $password=$result->password;
        }else {
            if (strlen($_POST["newPassword"]) < self::MIN_LENGTH) {
                $err = true;
                $msg = "Your password must be at least 8 characters!";
            }else {
                $password=password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
            }

        }


        if (!$err) {
            $user=new User($_POST["email"],$password,$_POST["first_name"],$_POST["last_name"],$_POST["age"],$_POST["phone_number"],false);
            $user->setId($_SESSION["logged_user_id"]);
            UserDAO::update($user);
            $msg="You successfully update your account";
        }
        include_once "View/editProfile.php";
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

