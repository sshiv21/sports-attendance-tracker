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
        <form action="fetch-roll-number-attendance.php" method="post">
            <?php
                $sql_roll_numbers = "SELECT games.roll_number, all_users.name
                FROM games
                INNER JOIN all_users ON games.roll_number = all_users.roll_number
                WHERE games.game = '$game';";
                $res_roll_numbers = mysqli_query($conn, $sql_roll_numbers);

                while ($row = mysqli_fetch_assoc($res_roll_numbers)){
                    $name = $row["name"];
                    $roll_number = $row["roll_number"];
                    echo "<input type='radio' class='radio-buttons' name='roll-number' value='$roll_number'>$name($roll_number)</input>";
                    // echo $row["name"] . "(" . $row["roll_number"] . ")";
                }
            ?>
            <button name="submit" type="submit">Get Details</button>
    </form>
</body>
</html>