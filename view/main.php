<?php
namespace view;

use model\TypeDAO;

$typeDAO=new TypeDAO();
$categories=$typeDAO->getCategories();
$types=$typeDAO->getTypes();


?>



<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="index.php?target=main&action=render"><img src="icons/emagLogo.svg" height="100" width="150"></a></a>

    <ul class="navbar-nav mr-auto" style="margin-right: 0px !important;">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left: 5px;">
                <i class="fa fa-bars fa-3x" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                <?php foreach ($categories as $category) {

                    echo "<li class='dropdown-submenu'><a class='dropdown-item dropdown-toggle' data-toggle='dropdown' href='index.php?target=product&action=show&ctgId=".$category->id."'>".$category->name."</a>";
                   echo " <ul class='dropdown-menu'>";
                    foreach ( $types as $type) {
                        if($type->categorie_id==$category->id){
                            echo "
                     
                        <a class='dropdown-item' href='index.php?target=product&action=show&typId=".$type->id."'>".$type->name."</a>
                        
                        ";
                        }
                    }
                    echo "</ul>";
                    echo "</li>";
                }?>
                <!--<li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle" data-toggle="dropdown" href="#">Something else here</a>
                    <ul class="dropdown-menu">
                        <a class="dropdown-item" href="#">A</a>
                        <a class="dropdown-item" href="#">b</a>
                    </ul>
                </li>-->
            </ul>
        </li>
    </ul>

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
<link rel="stylesheet" href="view/css.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>




