<?php

    //start session
    session_start();
    //If user has alredy loged in than redirect to notes.php page.
    if(isset($_SESSION['user_id'])){
        //Redirect to login.php
        header('Location: notes.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>Notes</title>
</head>

<body>
    <div class="auth">
        <a href="register.php">REGISTER</a>
        <a href="login.php">LOGIN</a>
    </div>
</body>

</html>