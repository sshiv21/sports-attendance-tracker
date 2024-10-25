<?php
    session_start();
    if ($_SESSION["can_enter"] == 0 || $_SESSION["is_captain"] == 0){
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
    catch(mysqli_sql_exception){
        echo "couldn't connect";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="set.css">
    <link rel="stylesheet" href="nav.css">
    <style>
        form {
            box-shadow: 0 0 10px rgb(0, 0, 100);
            border-radius: 10px;
            margin: auto;
            width: 50%;
            padding: 10px;
        }

        form label {
            display: block;
            margin: auto;
            width: fit-content;
        }

        .select-options label {
            display: inline;
        }

        form label, form input[type="radio"] {
            cursor: pointer;
        }

        form input[type="date"] {
            cursor: pointer;
        }

        form button {
            cursor: pointer;
        }
    </style>
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
    <form action="update-attendance.php" method="post">
        <p>Select the Roll Number:</p>
        <?php
            $game = $_SESSION["game"];
            $sql = "SELECT games.roll_number, all_users.name
                FROM games
                JOIN all_users ON games.roll_number = all_users.roll_number and games.game = '$game';
            ";
            $res = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($res)){
                $roll_number = $row["roll_number"];
                $name = $row["name"];

                echo "<label>$name($roll_number)<input type='radio' name='roll-number' value='$roll_number' class='radio' required></labeL>";
            }
            echo "<br>";
        ?>

        <label>Select the Date <input type="date" name="date" id="date" required></label> <br>
        <p >What to do?</p>
        <div class="select-options">
            <label><input type="radio" name="option" class="option" value="present" required>Present</label>
            <label><input type="radio" name="option" class="option" value="absent" required>Absent</label>
        </div>

        <br>
        <button name="submit" type="submit">Commit Changes</button>
    </form>
</body>
</html>