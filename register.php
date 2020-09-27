<?php

    //start session
    session_start();
    //If user has alredy loged in than redirect to notes.php page.
    if(isset($_SESSION['user_id'])){
        //Redirect to login.php
        header('Location: notes.php');
    }

    $error=false;
    
    if(isset($_POST['submit'])){

        //database connection occur
	    include('config/db_connect.php');

        //make lowercase email
        $email= strtolower($_POST['email']);

        // escape sql chars
        $email = mysqli_real_escape_string($conn,$email);        

        // make sql query
        $query = "SELECT user_id FROM user WHERE email = \"$email\" ";

        if(mysqli_query($conn, $query)){
            // get the query result
            $result = mysqli_query($conn, $query);

            // fetch result in array format
            $isEmailPresent = mysqli_fetch_all($result , MYSQLI_ASSOC);
            
            //To Check whether the user has registered or not.
            if(count($isEmailPresent)!=0){            
                $error=true;
            }else{                            
                $name=mysqli_real_escape_string($conn,$_POST['name']);
                $password=mysqli_real_escape_string($conn,$_POST['password']);
                //Encrypt the password before inserting into DataBase
                $hasedPassword =  password_hash($password, PASSWORD_DEFAULT);

                // make sql query
                $query = "INSERT INTO user(email,password,name) VALUES('$email','$hasedPassword','$name')";

                if(mysqli_query($conn, $query)){
                    //success
                    header('Location: login.php');
                }else {
                    //failure
                    echo 'query error: '. mysqli_error($conn);
                }
            }
        }else{
            //failure
            echo 'query error: '. mysqli_error($conn);
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/auth.css">
    <title>Register</title>
</head>
<body>
    <div class="center">
        <h1>Register</h1>

        <?php if($error){?>
            <p style="color: red; text-align: center; margin-bottom: 5px;"><?php echo "User already Registered!"; ?></p>
        <?php } ?>
        
        <hr>
        <form action="register.php" method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="email" required>
            <input type="password" name="password" placeholder="password" required>
            <button type="submit" name="submit" value="submit">Register</button>
            <p>Already a member? <a href="login.php">Login</a></p>
        </form>      
    </div>
</body>
</html>