<?php
namespace Controller;
use model\SearchDAO;
use model\Search;
use model\Product;
use model\ProductDAO;
use model\Type;
use model\TypeDAO;
use PHPMailer;
include_once "credentials.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ProductController
{
    public function show()
    {
        try {
            if (isset($_GET["prdId"])) {
                $product = ProductDAO::findProduct($_GET["prdId"]);
                $product->show();
            }
            if (isset($_GET["ctgId"])) {
                $types = TypeDAO::getTypesFromCategorieId($_GET["ctgId"]);
                foreach ($types as $type) {
                    $typeObject = new Type($type["id"], $type["name"], $type["categorie_id"]);
                    $typeObject->show();
                }
            }
            if (isset($_GET["typId"]) && isset($_GET["order"])) {
                if ($_GET["order"] == "asc") {

                    $products = ProductDAO::getProductsFromTypeIdAsc($_GET["typId"]);
                    $type = TypeDAO::getTypeInformation($_GET["typId"]);
                    include_once "View/showProductsFromType.php";
                    foreach ($products as $product) {
                        $productList = ProductDAO::findProduct($product["id"]);
                        $productList->show();
                    }

                } elseif ($_GET["order"] == "desc") {
                    $products = ProductDAO::getProductsFromTypeIdDesc($_GET["typId"]);
                    $type = TypeDAO::getTypeInformation($_GET["typId"]);

                    include_once "View/showProductsFromType.php";
                    foreach ($products as $product) {
                        $productList = ProductDAO::findProduct($product["id"]);
                        $productList->show();
                    }

                }
            } elseif (isset($_GET["typId"])) {

                $products = ProductDAO::getProductsFromTypeId($_GET["typId"]);
                $type = TypeDAO::getTypeInformation($_GET["typId"]);
                include_once "View/showProductsFromType.php";

                foreach ($products as $product) {
                    $productList = ProductDAO::findProduct($product["id"]);

                    $productList->showByType();
                }
            }
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function showAsc()
    {

    }


    public function add()
    {

        $msg = '';
        if (isset($_POST["save"])) {
            if (empty($_POST["name"]) || empty($_POST["producer_id"])
                || empty($_POST["price"]) || empty($_POST["type_id"])
                || empty($_POST["quantity"])) {

                $msg = "All fields are required!";
            } else {
                if (!is_numeric($_POST["quantity"]) || $_POST["quantity"] < 0 || $_POST["quantity"] != round($_POST["quantity"])) {
                    $msg = "Invalid quantity format!";
                }

                if ($msg == "") {
                    $msg = $this->validatePrice($_POST["price"]);
                }

                if (!is_uploaded_file($_FILES["file"]["tmp_name"])) {

                    $msg = "Image is not uploaded!";
                } elseif ($msg == "") {
                    $file_name_parts = explode(".", $_FILES["file"]["name"]);
                    $extension = $file_name_parts[count($file_name_parts) - 1];
                    $filename = time() . "." . $extension;
                    $img_url = "images" . DIRECTORY_SEPARATOR . $filename;
                    if (!move_uploaded_file($_FILES["file"]["tmp_name"], $img_url)) {

                        $msg = "Image error!";
                    }
                }
                if ($msg == "") {


                    ProductDAO::add($_POST["name"], $_POST["producer_id"], $_POST["price"], $_POST["type_id"], $_POST["quantity"], $img_url);
                    $msg = "Product added successfully!";
                }

            }
        }
        include_once "View/addProduct.php";
    }


    public function edit()
    {


        if (isset($_POST["saveChanges"])) {
            $msg = "";
            if (empty($_POST["name"]) || empty($_POST["producer_id"])
                || empty($_POST["price"]) || empty($_POST["type_id"])
                || empty($_POST["quantity"])) {
                $msg = "All fields are required!";
            } else {
                $i = $_POST["quantity"];

                if (!is_numeric($i) || $i < 0 || $i != round($i)) {
                    $msg = "Invalid quantity format!";
                }


                if ($msg == "") {
                    $price = $_POST["price"];
                    $old_price = NULL;
                    if (!empty($_POST["newPrice"])) {
                        $msg = $this->validatePrice($_POST["newPrice"]);
                        if ($_POST["newPrice"] > $_POST["price"]) {
                            $msg = "New price of product must be lower than price !";
                        } else {
                            $price = $_POST["newPrice"];
                            $old_price = $_POST["price"];

                        }
                    }
                }
                if ($msg == "") {
                    $msg = $this->validatePrice($_POST["price"]);
                }


                if (!is_uploaded_file($_FILES["file"]["tmp_name"])) {
                    $img_url = $_POST["old_image"];
                } else {
                    $file_name_parts = explode(".", $_FILES["file"]["name"]);
                    $extension = $file_name_parts[count($file_name_parts) - 1];
                    $filename = time() . "." . $extension;
                    $img_url = "images" . DIRECTORY_SEPARATOR . $filename;
                    if (move_uploaded_file($_FILES["file"]["tmp_name"], $img_url)) {
                        unlink($_POST["old_image"]);
                    } else {
                        $msg = "Image error!";
                    }
                }
                if ($msg == "") {
                    $product = [];
                    $product["product_id"] = $_POST["product_id"];
                    $product["name"] = $_POST["name"];
                    $product["producer_id"] = $_POST["producer_id"];
                    $product["price"] = $price;
                    $product["old_price"] = $old_price;
                    $product["type_id"] = $_POST["type_id"];
                    $product["quantity"] = $_POST["quantity"];
                    $product["image_url"] = $img_url;

                    ProductDAO::edit($product);
                    $this->sendPromotionEmail($product["product_id"], $product["name"]);

                }

            }

        }
        $productId = $_POST["product_id"];
        include_once "View/editProduct.php";
    }

    public function validatePrice($price)
    {
        $msg = "";
        if (!preg_match('/^[0-9]+(\.[0-9]{1,2})?$/', $price) || !is_numeric($price)) {
            $msg = "Invalid price format!";
        }
        return $msg;
    }


    public static function checkIfIsInPromotion($product_id)
    {
        $product = ProductDAO::getById($product_id);

        $oldPrice = null;
        $inPromotion = false;
        $discount = null;
        if ($product["old_price"] != NULL) {
            $inPromotion = true;
            $oldPrice = $product["old_price"];
            $discount = round((($product["old_price"] - $product["price"]) / $product["old_price"]) * 100, 0);
        }


        $isInStock = null;
        if ($product["quantity"] == 0) {
            $isInStock = "Not available";
        } elseif ($product["quantity"] <= 10) {
            $isInStock = "Limited quantity";
        } elseif ($product["quantity"] > 10) {
            $isInStock = "In stock";
        }

        $status = [];
        $status["in_promotion"] = $inPromotion;
        $status["old_price"] = $oldPrice;
        $status["discount"] = $discount;
        $status["is_in_stock"] = $isInStock;
        return $status;
    }


    public function removeDiscount()
    {
        if (isset($_POST["remove"])) {
            if (isset($_POST["product_id"]) && isset($_POST["product_old_price"])) {
                if ($_POST["product_old_price"] != NULL) {
                    ProductDAO::removePromotion($_POST["product_id"], $_POST["product_old_price"]);
                }

                $productId = $_POST["product_id"];
                include_once "View/editProduct.php";
            }
        }


    }

    public function addProduct()
    {
        include_once "View/addProduct.php";
    }


    public function editProduct()
    {
        if (isset($_POST["editProduct"])) {
            if (isset($_POST["product_id"])) {
                $productId = $_POST["product_id"];
                include_once "View/editProduct.php";
            } else {
                header("Location:index.php");


            }
        } else {
            header("Location:index.php");
        }
    }


    public function showProduct()
    {
        include_once "View/showProduct.php";

    }

    public function filterProducts()
    {
        if (isset($_POST["checked"])) {
//      $a = new Product(1,"something",1,1000,1,5,'dfgd');
//      $b = new Product(1,"something",1,1000,1,5,'dfgd');
//      $c = [];
//      $c[] = $a;
//      $c[] = $b;
            if (isset($_POST["checked"]["os"]))

                if (isset($_POST["checked"]["name"]))
                    echo json_encode($_POST["checked"]);
        }
    }

    function sendPromotionEmail($productId, $productName)
    {
        $emails = ProductDAO::getUserEmailsByLikedProduct($productId);
        foreach ($emails as $email) {
            $this->sendemail($email["email"], $productName , $productId);
        }

    }


    function sendemail($email, $productName , $productId)
        {
            require_once "PHPMailer-5.2-stable/PHPMailerAutoload.php";
            $mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();
            $mail->SMTPDebug = 0;// Set mailer to use SMTP
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
            $mail->Username = EMAIL_USERNAME;                 // SMTP username
            $mail->Password = EMAIL_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            $mail->setFrom('emag9648@gmail.com');
            $mail->addAddress($email);     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML

            $mail->Subject = 'Your Product is on Sale !!!';
            $mail->Body = "$productName Product is in Sale Now !!! Go Check it out before the sale expires ";
            $mail->AltBody = 'Click For Register';

            if (!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Message has been sent';
            }
        }
}

