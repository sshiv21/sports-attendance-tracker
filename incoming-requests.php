<?php
    session_start();
    if ($_SESSION["can_enter"] == 0 || $_SESSION["is_captain"] == 0){
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
    $sql = "SELECT all_users.name, game_change_requests.roll_number, game_change_requests.from_game, game_change_requests.to_game, game_change_requests.approve_from, game_change_requests.approve_to
        FROM game_change_requests
        JOIN all_users ON game_change_requests.roll_number = all_users.roll_number
        WHERE game_change_requests.to_game = '$game'";

    $res = mysqli_query($conn, $sql);
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
    <table class="container">
        <?php
            if (mysqli_num_rows($res) > 0){
                echo
                "
                    <th>Name</th>
                    <th>Roll Number</th>
                    <th>From Game</th>
                    <th>To Game</th>
                    <th>Approval By Other Captain</th>
                    <th>Approval By Me</th>
                    <th>Approve or not</th>
                ";
            }
            else{
                echo
                "
                    <h1>No pending reqests!</h1>
                ";
            }
        ?>
        <?php
            while ($row = mysqli_fetch_assoc($res)){
                $name = $row["name"];
                $roll_number = $row["roll_number"];
                $from_game = $row["from_game"];
                $to_game = $row["to_game"];

                $approval_by_other_captain = "";
                if ($row["approve_from"] == 1){
                    $approval_by_other_captain = "YES";
                }
                else if ($row["approve_from"] == -1){
                    $approval_by_other_captain = "REJECTED";
                }
                else{
                    $approval_by_other_captain = "PENDING";
                }
                
                $approval_by_me = "";
                if ($row["approve_to"] == 1){
                    $approval_by_me = "YES";
                }
                else if ($row["approve_to"] == -1){
                    $approval_by_me = "REJECTED";
                }
                else{
                    $approval_by_me = "PENDING";
                }
                echo
                "
                    <tr>
                        <td>$name</td>
                        <td>$roll_number</td>
                        <td>$from_game</td>
                        <td>$to_game</td>
                        <td>$approval_by_other_captain</td>
                        <td>$approval_by_me</td>
                        <td>
                            <form action='incoming-requests-update.php' method='post' class='forms'>
                                <input type='text' name='roll-number' value='$roll_number' style='display: none'>
                                <button type='submit' class='approval-buttons' name='approve' value='yes'>YES</button>
                                <button type='submit' class='approval-buttons' name='approve' value='no'>NO</button>
                            </form>
                        </td>
                    </tr>
                ";
            }
        ?>
    </table>
</body>
</html>