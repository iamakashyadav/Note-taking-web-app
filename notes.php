<?php

    //start session
    session_start();    
    //If user is not loged in than redirect to login page.
    if(!isset($_SESSION['user_id'])){
        //Redirect to login.php
        header('Location: login.php');
    }
    
    $user_id=$_SESSION['user_id'];

    //database connection occur
    include('config/db_connect.php');


    //********************Insertion********************
    if(isset($_POST['submit'])){
        
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $note=mysqli_real_escape_string($conn,$_POST['note']);

        // make sql query
        $query = "INSERT INTO notes(user_id,title,note) VALUES('$user_id','$title','$note')";

        if(mysqli_query($conn, $query)){

        }else{
            //failure
            echo 'query error: '. mysqli_error($conn);
        }

    }

    //********************Deletion********************
    if(isset($_POST['delete'])){

        $note_id=$_POST['note_id'];

        // make sql query
        $query = "DELETE FROM notes WHERE note_id = \"$note_id\" ";

        if(mysqli_query($conn, $query)){

        }else{
            //failure
            echo 'query error: '. mysqli_error($conn);
        }

    }

    //********************Updation********************
    if(isset($_POST['update'])){

        $note_id=$_POST['note_id'];

        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $note=mysqli_real_escape_string($conn,$_POST['note']);

        // make sql query
        $query = "UPDATE notes SET title=\"$title\",note=\"$note\",last_updated_at=CURRENT_TIMESTAMP WHERE note_id = \"$note_id\" ";

        if(mysqli_query($conn, $query)){

        }else{
            //failure
            echo 'query error: '. mysqli_error($conn);
        }

    }

    //********************Selection********************
    // make sql query    
    // $query = "SELECT note_id,title,note FROM notes WHERE user_id = \"{$_SESSION['user_id']}\" ";
    $query = "SELECT note_id,title,note FROM notes WHERE user_id = \"$user_id\" ";

    if(mysqli_query($conn, $query)){

        // get the query result
        $result = mysqli_query($conn, $query);

        // fetch result in array format
        $notesArray= mysqli_fetch_all($result , MYSQLI_ASSOC);

        // print_r($notesArray);

    }else{
        //failure
        echo 'query error: '. mysqli_error($conn);
    }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="css/notes.css">
    <title>Notes</title>
</head>

<body>
    <div class="take-note">
        <div class="user">
            <p>Hello, <span><?php echo $_SESSION['user_name'] ?></span></p>
            <a href="logout.php">Logout</a>
        </div>
        <form action="notes.php" method="POST">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="note" rows="5" placeholder="Take a note..." required></textarea>
            <button type="submit" name="submit" value="submit">Add</button>
        </form>
    </div>
    <hr><br>
    <div class="notes">    
        <?php foreach($notesArray as $note){ ?>
        <div class="note" data-aos="fade-up">
            <h2><?php echo $note['title'] ?></h2>
            <hr>
            <p><?php echo $note['note'] ?></p> 
            <input type="hidden" value=<?php echo $note['note_id'] ?>>      
            <div class="note-edit">
                <button onclick="buttonShowModal(this)">Show</button>
                <button onclick="buttonEditModal(this)" class="edit-button"><img src="img/edit.png" alt="edit"></button>
                <form action="notes.php" method="POST"><input type="hidden" name="note_id" value=<?php echo $note['note_id'] ?>><button type="submit" name="delete" value="delete"><img
                            src="img/delete.png" alt="delete"></button></form>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="edit-modal" id="editModal">
    </div>
    <div class="show-modal" id="showModal">
    </div>
    <script src="js/notes.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 120,
            duration: 900
        });
    </script>
</body>

</html>