<?php
namespace View;
use Model\UserDAO;
use Model\AddressDAO;


$user=UserDAO::getUserByid($_SESSION["logged_user_id"]);
$addresses=AddressDAO::getAll($_SESSION["logged_user_id"]);

//TODO addresses
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<br>
First Name:   <?php echo $user->first_name ?> <br>
Last Name: <?php echo $user->last_name ?><br>
Email:  <?php echo $user->email ;?><br>
Age: <?php echo $user->age ?><br>
Phone Number: <?php echo $user->phone_number ?><br>
<a href="index.php?target=User&action=editPage"><button name="edit" class="btn btn-primary">Edit profile</button></a>
<hr>

My addresses:
<table>
    <?php foreach ($addresses as $address) {
    ?><tr>
        <td><?php echo $address->street_name .', '. $address->city_name ;?></td>
        <td>
            <form action='index.php?target=address&action=editAddress' method="post">
                <input type='hidden' name='address_id' value="<?php echo $address->id;?>">
                <input type="submit" name="editAddress" value="Edit">
            </form>
        </td>
        <td>
            <form action='index.php?target=address&action=delete' method="post">
                <input type='hidden' name='address_id' value="<?php echo $address->id;?>">
                <input type="submit" name="deleteAddress" value="Delete">
            </form>
        </td>

       </tr>
    <?php
    } ?>

</table>
<a href="index.php?target=address&action=newAddress"><button name="addAddress" class="btn btn-primary">Add address</button></a>
<a href="index.php?target=order&action=show"><button>My Orders</button></a>

<a href="index.php?target=product&action=myRated"><button class="btn btn-primary">My rated</button></a>
</body>
</html>
