<?php
    session_start();
    if ($_SESSION["can_enter"] == 0){
        header("Location: login.php");
    }
?>

<?php
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

    $game = $_SESSION["game"];
    // echo $game . "<br>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="set.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>

    <nav>
        <li><a href="welcome.php">Home</a></li>
        <li><a href="#" onclick="goBack()">Go Back</a></li>
        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </nav>
    <form action="fetch-day-attendance.php" method="post">
        <label for="date">Select the date</label>
        <input type="date" name="date" id="date" required>
        <button name="submit" type="submit">Show Attendance</button>
    </form>
</body>
</html>