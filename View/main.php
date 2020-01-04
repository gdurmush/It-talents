<?php
if(isset($_SESSION["logged_user_role"]) && $_SESSION["logged_user_role"]=="admin"){
    ?>
    <a href="index.php?target=product&action=addProduct"><button>Add New Product</button></a>
    <?php
}else{
    ?>
    <a href="index.php?target=cart&action=show"><button>Cart</button></a>
    <a href="index.php?target=favourite&action=show"><button>Favourites</button></a>
    <?php
}
?>

<a href="index.php?target=user&action=account"><button>My Account</button></a>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?php

echo "You are in main";
include_once "View/search.php";

?>