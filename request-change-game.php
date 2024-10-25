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
    $game = $_SESSION["game"];
    $roll_number = $_SESSION["roll_number"];

    $sql = "SELECT * FROM game_change_requests WHERE roll_number = $roll_number";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) == 1){
        echo
        "
            <script>
                alert('Your request is pending please wait');
                window.location.href = 'welcome.php';
            </script>
        ";
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="set.css">
    <style>
        form {
            margin: auto;
            box-shadow: 0 0 10px rgb(0 , 0, 100);
            border-radius: 5px;
            width: min(80rem, 60%);
            padding: 1rem;
        }

        form input[type="radio"] {
            cursor: pointer;
        }

        form button {
            cursor: pointer;
            margin-top: 10px;
            padding: 0.1rem;
        }
    </style>
</head>
<body>
    <div id="sent-request">
    </div>
    <script>
        document.getElementById("sent-request")
    </script>
    <form action="send-request-to-change-game.php" method="post">
        <label for="current-game">Current Game:</label>
        <input type="text" name="current-game" id="current-game" readonly>
        <script>
            document.getElementById("current-game").value = "<?php echo $_SESSION["game"] ?>";
        </script>
        <br>
        <label for="change-game">Change Game:</label>
        <?php
            $arr = ["Athletics", "Aquatics", "Badminton", "Basketball", "Cricket", "Football", "Hockey", "Lawn Tennis", "Squash", "Table Tennis", "Volleyball", "Chess", "Weightlifting"];
            foreach ($arr as $g){
                if ($g != $game){
                    echo "
                        <div>
                            <label for='to_game'>$g</label>
                            <input type='radio' name='to_game' value='$g' class='radio' required>
                        </div>
                        ";
                }
            }
        ?>
        <button type="submit" name="submit">Request</button>
    </form>
</body>
</html>