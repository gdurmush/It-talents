<?php
namespace View;
use Model\ProductDAO;


if(isset($_POST["editProduct"])){
    if(isset($_POST["productId"])){
        $productId=$_POST["productId"];
    }else{
        header("Location:index.php");
    }
}else{
    header("Location:index.php");
}
$producers=ProductDAO::getProducers();
$types=ProductDAO::getTypes();
$product=ProductDAO::getById($productId);



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
<?php
if (isset($err) && $err) {
    echo $msg;
}?> <br>
<form action="index.php?target=product&action=edit" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" value="<?php echo $product->name?>" required></td>
        <td><input type="hidden" name="product_id" value="<?php echo $productId?>"></td>


        </tr>
        <tr>
            <td>Producer</td>
            <td><select name="producer_id" required>
                    <option  value="<?php echo $product->producer_id?>"><?php echo $product->producer_name?></option>
                    <?php foreach ($producers as $producer) {
                        echo "<option value='$producer->id'>$producer->name</option>";
                    } ?>
                </select></td>

            </select>
            </td>
        </tr>
        <tr>
            <td>Price</td>
            <td><input type="number" step="0.01" name="price" min="0.01" value="<?php echo $product->price?>" required></td>
        </tr>

        <tr>
            <td>Type</td>
            <td><select name="type_id" required>
                    <option value="<?php echo $product->type_id?>"><?php echo $product->type_name?></option>
                    <?php foreach ($types as $type) {
                        echo "<option value='$type->id'>$type->name</option>";

                    } ?>
                </select></td>
        </tr>
        <tr>
            <td>Quantity</td>
            <td><input type="number" name="quantity" min="1" value="<?php echo $product->quantity?>" required></td>

        </tr>
        <tr>
            <td>Upload image</td>
            <td><input type="file" name="file"></td>
            <tr><input type="hidden" name="old_image" value="<?php echo $product->image_url?>"></tr>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="saveChanges" value="Save"></td>
        </tr>
    </table>
</form>
</body>
</html>
