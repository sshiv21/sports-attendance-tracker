<?php
    session_start();
    if ($_SESSION["can_enter"] == 0){
        header("Location: login.php");
    }

    $roll_number = $_SESSION["roll_number"];
    // echo $roll_number;
    $db_server = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "iitk";
    $conn = "";
    try{
        $conn = mysqli_connect($db_server, 
                                $db_user, 
                                $db_password, 
                                $db_name);
    }
    catch (mysqli_sql_exception){
        echo "couldn't connect";
    }
    
    // echo $roll_number;
    $sql = "select * from games where roll_number = '$roll_number'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $_SESSION["game"] = $row["game"];
    $_SESSION["is_captain"] = 0;
    $sql = "select * from captains where roll_number = '$roll_number'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) == 0){
        header("Location: welcome-student.php");
    }
    else{
        // $row = mysqli_fetch_assoc($res);
        $_SESSION["is_captain"] = 1;
        header("Location: welcome-captain.php");
        // echo $row["game"];
    }
?>