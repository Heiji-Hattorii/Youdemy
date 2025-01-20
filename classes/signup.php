<?php
require_once 'class.users.php';
$user=new Users();
if(isset($_POST('identifiant')) && isset($_POST('email')) && isset($_POST('password'))){
    $user->signup()
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" id="identifiant" name="identifiant" placeholder="identifiant">
        <input type="email" id="email" name="email" placeholder="email">
        <input type="password" id="password" name="password" placeholder="identifiant">
        <button type="submit"></button>
    </form>
</body>
</html>
