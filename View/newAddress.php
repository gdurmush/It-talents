<?php
namespace View;
use model\AddressDAO;

try{
    $addressDAO=new AddressDAO();
    $cities=$addressDAO->getCities();
}catch (\PDOException $e){
    include_once "view/main.php";
    echo "Oops, error 500!";

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="container">
    <?php
    if (isset($err) && $err){
        ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $msg;?>
        </div>
        <?php
    }
    ?>
    <form action="index.php?target=address&action=add" method="post">
        <table>
            <tr>
                <td>City</td>
                <td><select name="city" required>
                        <option value="">Select City</option>
                        <?php foreach ($cities as $city) {
                            echo "<option value='$city->id'>$city->name</option>";

                        } ?>
                    </select></td>
            </tr>
            <tr>
                <td>Street name</td>
                <td><input type="text" name="street" placeholder="Enter street name" min="5" required ></td>
            </tr>
            <tr><td colspan="2"><input type="submit" name="add" value="Add new address"></td></tr>
        </table>

    </form>
    <a href="index.php?target=user&action=account"><button>Back</button></a>
</div>
</body>
</html>