<?php
    session_start();
    if ($_SESSION["can_enter"] == 0){
        header("Location: login.php");
    }

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
    catch(mysqli_sql_exception){
        echo "couldn't connect";
    }
?>

<?php
    $roll_number = $_SESSION["roll_number"];
    $sql = "SELECT * FROM game_change_requests_history WHERE roll_number = '$roll_number';";
    $res = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="set.css">
    <link rel="stylesheet" href="table.css">
    <link rel="stylesheet" href="nav.css">
    <style>
        .container {
            box-shadow: 0 0 10px rgb(1, 1, 100);
            border-radius: 10px;
            margin: auto;
            padding: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="welcome.php">Home</a>
        <a href="#" onclick="goBack()">Go Back</a>
    </nav>
    <script>
        function goBack(){
            window.history.back();
        }
    </script>
    <main class="container">
        <table>
            <?php
                if (mysqli_num_rows($res) > 0){
                    echo
                    "
                        <tr>
                            <th>S No</th>
                            <th>From Game</th>
                            <th>To Game</th>
                            <th>Response from 'From' Captain</th>
                            <th>Response from 'To' Captain</th>
                            <th>Final Status</th>
                            <th>Finalised Date and Time</th>
                        </tr>
                    ";
                }
                else{
                    echo
                    "
                        <h1>You have not made any game changes in this year.</h1>
                    ";
                }
            ?>
            <?php
                $serial_number = 1;
                while ($row = mysqli_fetch_assoc($res)){
                    $to_game = $row["to_game"];
                    $from_game = $row["from_game"];
                    $from_response = $row["from_response"];
                    $to_response = $row["to_response"];
                    $status = $row["status"];
                    $date_and_time = $row["time_stamp"];
                    echo
                    "
                        <tr>
                            <td>$serial_number</td>
                            <td>$from_game</td>
                            <td>$to_game</td>
                            <td>$from_response</td>
                            <td>$to_response</td>
                            <td>$status</td>
                            <td>$date_and_time</td>
                        </tr>
                    ";
                }
            ?>
        </table>
    </main>
</body>
</html>