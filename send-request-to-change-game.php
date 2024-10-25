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
    if (isset($_POST["submit"])){
        $from_game = $_SESSION["game"];
        $to_game = $_POST["to_game"];
        $roll_number = $_SESSION["roll_number"];
        // echo $to_game;
        $sql = "INSERT INTO game_change_requests (roll_number, from_game, to_game) VALUES ('$roll_number', '$from_game', '$to_game')";
        // echo $sql;
        $res = mysqli_query($conn, $sql);

        if ($res){
            echo
            "
                <script>
                    alert('Request sent successfully to captains');
                    window.location.href = 'welcome.php';
                </script>
            "
            ;
        }
        else{
            echo
            "
                <script>
                    alert('Probelm in sending request to captains.Please try again later.');
                    window.location.href = 'welcome.php';
                </script>
            "
            ;
        }
    }
?>