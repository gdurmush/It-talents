<?php
namespace view;
?>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="index.php?target=main&action=render"><img src="icons/emagLogo.svg" height="100" width="150"></a></a>
<?php
include_once "view/search.php";

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <?php
    if(isset($_SESSION["logged_user_role"]) && $_SESSION["logged_user_role"]=="admin"){
        ?>
        <a href="index.php?target=product&action=addProduct"><button>Add New Product</button></a>
        <a href="index.php?target=user&action=account"><img src="icons/user.svg" height="60" width="60">Моят Акаунт</a>
        <?php
    }else{
        ?>
        <a href="index.php?target=user&action=account"><img src="icons/user.svg" height="60" width="60">Моят Акаунт</a>
        <a  href="index.php?target=favourite&action=show"><img src="icons/like.svg" height="60" width="60">Любими</a>
        <a href="index.php?target=cart&action=show"><img src="icons/cart.svg" height="60" width="60">Моята Количка</a>
        <?php
    }
    ?>



<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</div>
 </nav>