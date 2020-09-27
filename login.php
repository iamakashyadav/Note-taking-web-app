<?php
    
    //start session
    session_start();
    if(isset($_SESSION['user_id'])){
        //Redirect to login.php
        header('Location: notes.php');
    }

    $error=['email'=>false, 'password'=>false];
    
    if(isset($_POST['submit'])){

        //database connection occur
	    include('config/db_connect.php');

        //make lowercase email
        $email= strtolower($_POST['email']);

        // escape sql chars
        $email = mysqli_real_escape_string($conn,$email);        

        // make sql query
        $query = "SELECT user_id,email,password,name FROM user WHERE email = \"$email\" ";

        if(mysqli_query($conn, $query)){

            // get the query result
            $result = mysqli_query($conn, $query);

            // fetch result in array format
            $isEmailPresent = mysqli_fetch_all($result , MYSQLI_ASSOC);
            
            //To Check whether the user has registered or not.
            if(count($isEmailPresent)==0){                  
                $error['email'] = true;
            }else{    
                
                // escape sql chars
                $InputPassword=mysqli_real_escape_string($conn,$_POST['password']);
                
                //password which is fetch from database
                $hashedDbPassword=$isEmailPresent['0']['password'];    
                
                //Password Matching
                if(password_verify($InputPassword,$hashedDbPassword)){
                    
                    //to start the session
                    session_start();
                    $_SESSION['user_name']=$isEmailPresent['0']['name'];
                    $_SESSION['user_id']=$isEmailPresent['0']['user_id'];

                    //Redirect to notes.php
                    header('Location: notes.php');
                }else {
                    $error['password']=true;
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
    <title>Login</title>
</head>

<body>
    <div class="center">
        <h1>Login</h1>

        <?php if($error['email']){?>
            <p style="color: red; text-align: center; margin-bottom: 5px;"><?php echo "User does not Exist"; ?></p>
        <?php } ?>

        <?php if($error['password']){?>
            <p style="color: red; text-align: center; margin-bottom: 5px;"><?php echo "Enter Correct Password"; ?></p>
        <?php } ?>

        <hr>
        <form action="login.php" method="POST">
            <input type="email" name="email" required placeholder="email" value=<?php echo $email??"" ?>>
            <input type="password" name="password" placeholder="password" required>
            <button type="submit" name="submit" value="submit">Login</button>
            <p>Not a member? <a href="register.php">Register</a></p>
        </form>      
    </div>
</body>
</html>