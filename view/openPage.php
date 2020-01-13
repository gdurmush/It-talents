<?php
namespace view;

use controller\ProductController;

$productController=new ProductController();
$products=$productController->getMostCelledProducts();
?>

    <html lang="en">
<head>
    <link rel="icon" href="icons/favicon.png">
</head>
<meta charset="UTF-8">
<meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>eMAG</title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <?php foreach ($products as $product) {
                    ?>

                    <div class="col-3">

                        <div class="card">
                            <img class="card-img-top" src="<?= $product->image_url ?>" alt="Card image cap" height="200"
                                 width="40">
                            <div class="card-body">
                                <h5 class="card-title"><?= $product->name ?></h5>
                                <p class="card-text"><?= $product->price ?> EURO</p>
                                <a href="index.php?target=cart&action=add&id=<?= $product->id ?>"
                                   class="btn btn-primary">Add to cart</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
