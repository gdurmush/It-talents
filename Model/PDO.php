<?php
//include_once "../config.php";

define("DB_HOST","127.0.0.1");
define("DB_PORT","3306");
define("DB_NAME","emag");
define("DB_USER","root");
define("DB_PASS","");

function getPDO(){
    try{

        $options=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        $db = new PDO('mysql:host='.DB_HOST. ":" . DB_PORT . ';dbname='.DB_NAME , DB_USER, DB_PASS, $options);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;



    }
    catch (PDOException $e){
        /*echo $e->getMessage();*/
        echo "yes";
    }
}


getPDO();