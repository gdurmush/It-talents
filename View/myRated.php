<?php
namespace View;

use Model\ProductDAO;

$myRatings=ProductDAO::showMyRated($_SESSION["logged_user_id"]);
print_r($myRatings);

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
<?php foreach ($myRatings as $myRating) {
    ?>
    <table>
        <tr>

            <td><img src="<?= $myRating->image_url?>"width="150"></td>
        </tr>
        <tr>
            <td>Product name</td>
            <td><?= $myRating->product_name;?></td>
        </tr>
        <tr>
            <td>My vote</td>
            <td><?= $myRating->stars?> stars</td>
        </tr>
        <tr>
            <td>My comment for this product:</td>
            <td><?= $myRating->text?></td>
        </tr>
        <tr><td><a href=""></a></td></tr>
    </table>
    <hr>
    <?php
}?>

</body>
</html>


