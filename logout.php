<?php
    session_start();
    // $_SESSION["is_loggedin"]
    session_destroy();
    header("Location: index.php");
?>