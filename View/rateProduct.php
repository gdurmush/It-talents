<?php
namespace View;
$_POST['product_id']=2;// only for test
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
<form action="index.php?target=product&action=rate" method="post">
    <table>
        <tr><input type="hidden" name="product_id" value="<?php echo $_POST['product_id'] ?>"></tr>
        <tr>
            <td>Give your vote from 1 to 5 for this product</td>
            <td><input type="number" name="rating" ></td>
        </tr>
        <tr>
            <td>Write comments for this product</td>
            <td><textarea name="comment" id="" cols="30" rows="10"></textarea></td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit" name="save" value="Save"></td>
        </tr>
    </table>
</form>
</body>
</html>