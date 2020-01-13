<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$controllerName = isset($_GET["target"]) ? $_GET["target"] : "main";
$methodName = isset($_GET["action"]) ? $_GET["action"] : "render";


$controllerClassName = "\\controller\\" . ucfirst($controllerName) . "controller";
spl_autoload_register(function ($class){
    require_once str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
});

if(!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'))
{
?>

<html lang="en">
<head>
    <link rel="icon" href="icons/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>eMAG</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>

<?php
include_once "view/main.php";
?>
<?php
}

if (class_exists($controllerClassName)){
    $controller = new $controllerClassName();

    if(method_exists($controller, $methodName)){
        try{
            $controller->$methodName();
        }catch (Exception $exception){
            echo "error -> " . $exception->getMessage();

            die();
        }
    }else{
        echo "error: method not found: $controllerClassName -> $methodName\n";

        die();
    }

    exit();
}else{
    echo "error: controller not found $controllerClassName\n";

    die();
}

?>



