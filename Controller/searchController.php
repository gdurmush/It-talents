<?php
namespace Controller;
use model\Search;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once dirname(__FILE__) . "/../Model/DBManager.php";
class SearchController
{
public function render (){
    if (isset($_POST["searchProducts"])) {
        $controller = new Search($_POST["search"]);
        $controller->render();
        exit();
    }
}
}
