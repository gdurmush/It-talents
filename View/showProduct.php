<?php
namespace View;
use Model\ProductDAO;

$product_id=2; // only for test
$product=ProductDAO::getById($product_id);
$avgStars=ProductDAO::getAVGRating($product_id);
$countOfStars=ProductDAO::getStarsCount($product_id);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<table>
    <tr>
        <td><?= $product->name?></td>
    </tr>
    <tr>
        <td><img src="<?= $product->imageUrl ?>"width="150"></td>
    </tr>
    <tr>
        <td><a href="index.php?target=cart&action=add&id=<?=$product->id?>"><button>Add to cart</button> </a></td>
    </tr>
    <tr>
        <td><a href="index.php?target=favourite&action=add&id=<?=$product->id?>"></a><button>Add to Favourites</button> </a></td>
    </tr>
    <tr>
        <td><a href="index.php?target=product&action=ratePage"><button>Rate this product</button> </a></td>
    </tr>
</table>
<table>
    <tr><td>Average grade: <?= $avgStars->avg_stars?></td></tr>
    <?php foreach ($countOfStars as $countOfStar) {
        echo "<tr><td>Rate with $countOfStar->stars stars:  $countOfStar->stars_count</td></tr>";
    }
    ?>

</table>
</body>
</html>
