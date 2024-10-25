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
    if (isset($_POST["approve"])){
        $approve = $_POST["approve"];
        // echo $approve;
        if ($approve == "yes"){
            $roll_number = $_POST["roll-number"];
            $sql_fetch = "SELECT * FROM game_change_requests WHERE roll_number = '$roll_number'";
            $res_fetch = mysqli_query($conn, $sql_fetch);
            $row_fetch = mysqli_fetch_assoc($res_fetch);
            if ($row_fetch == null){
                header("Location: outgoing-requests.php");
                exit;
            }
            if ($row_fetch["approve_from"] == 1){
                echo
                "
                    <script>
                        alert('You have already approved this');
                    </script>
                ";
            }
            else{
                $sql_update = "UPDATE game_change_requests SET approve_from = 1";
                $res_update = mysqli_query($conn, $sql_update);
                if ($res_update){
                    echo
                    "
                        <script>
                            alert('Approved successfully');
                        </script>
                    ";
                }
                else{
                    echo
                    "
                        <script>
                            alert('Problem in updating please try again after some time');
                        </script>
                    ";
                }

            }
        }
        else{
            $roll_number = $_POST["roll-number"];
            $sql_fetch = "SELECT * FROM game_change_requests WHERE roll_number = $roll_number";
            $res_fetch = mysqli_query($conn, $sql_fetch);
            $row_fetch = mysqli_fetch_assoc($res_fetch);
            if ($row_fetch["approve_from"] == -1){
                echo
                "
                    <script>
                        alert('You have already rejected this');
                    </script>
                ";
            }
            else{
                $sql_update = "UPDATE game_change_requests SET approve_from = -1";
                $res_update = mysqli_query($conn, $sql_update);
                if ($res_update){
                    echo
                    "
                        <script>
                            alert('Rejected successfully');
                        </script>
                    ";
                }
                else{
                    echo
                    "
                        <script>
                            alert('Problem in updating please try again after some time');
                        </script>
                    ";
                }

            }
        }
        
        $roll_number = $_POST["roll-number"];
        $sql = "SELECT * FROM game_change_requests WHERE roll_number = '$roll_number';";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        if ($row["approve_from"] != 0 && $row["approve_to"] != 0){
            $to_game = $row["to_game"];
            $from_game = $row["from_game"];
            $from_response = $row["approve_from"];
            $to_response = $row["approve_to"];
            $status = 0;
            if ($row["approve_from"] + $row["approve_to"] == 2){
                $status = 1;
            }
            $sql_write = "INSERT INTO game_change_requests_history (roll_number, from_game, to_game, from_response, to_response, status) VALUES ('$roll_number', '$from_game', '$to_game', '$from_game', '$to_response', $status);";
            $result_write = mysqli_query($conn, $sql_write);
            $sql_delete = "DELETE FROM game_change_requests WHERE roll_number = '$roll_number';";
            $res_result = mysqli_query($conn, $sql_delete);
        }
    }

    echo
    "
        <script>
            window.location.href = 'outgoing-requests.php';
        </script>
    ";
?>