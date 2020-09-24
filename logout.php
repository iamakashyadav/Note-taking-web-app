<?php

    session_start();
    // To unset or delete the all session variable     
    session_destroy();

    //Redirect to notes.php
    header('Location: login.php');

?>