<?php
namespace View;
session_start();


//TODO autoload fields
//TODO addresses



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
if (isset($err) && $err){
    ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $msg;?>
    </div>
    <?php
} ?>
<form action="../index.php?target=User&action=edit" method="post">


    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input name="email" type="email" value="<?php echo $user->email ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">First Name</label>
        <input type="text" name="first_name" value="<?php echo $user->first_name ?>" class="form-control" >

    </div>
    <div class="form-group">
        <label >Last Name</label>
        <input type="text" name="last_name" value="<?php echo $user->last_name ?>" class="form-control" >

    </div>
    <div class="form-group">
        <label >Age</label>
        <input type="number" name="age" value="<?php echo $user->age ?>" class="form-control" min="0" max="100">

    </div>
    <div class="form-group">
        <label >Phone number</label>
        <input type="number" name="phone_number" value="<?php echo $user->phone_number ?>" class="form-control" placeholder="0888888888" >

    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Change Password</label>
        <input name="newPassword" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your new password" >
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Enter current password</label>
        <input name="accountPassword" type="password" class="form-control" id="exampleInputPassword1"  required>
    </div>

    <button name="edit" type="submit" class="btn btn-primary">Save changes</button>
</form>
<a href="register.php"><button name="edit" type="submit" class="btn btn-primary">Save changes</button></a>
</body>
</html>
