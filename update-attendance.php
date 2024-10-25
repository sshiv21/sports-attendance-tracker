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


<?php
    if (isset($_POST["submit"])){
        // echo 123;
        $roll_number = $_POST["roll-number"];
        // echo $roll_number . "<br>";
        $date = $_POST["date"];
        // echo $date . "<br>";
        $option = $_POST["option"];
        // echo $option . "<br>";

        $current_year = intval(date("Y")) - 1;
        $min_date = intval($current_year . "0801");
        $max_date = intval(date("Ymd"));
        // echo $max_date . "<br>";
        $date = intval($date[0] . $date[1] .$date[2] .$date[3] . $date[5] . $date[6] . $date[8] . $date[9]);
        // echo $date . "<br>";
        if ($min_date <= $date && $date <= $max_date){
            $table_name = "attendance_" . $_POST["date"][0] . $_POST["date"][1] . $_POST["date"][2] . $_POST["date"][3] . "_" . intval($_POST["date"][5] . $_POST["date"][6]);
            $day = intval($_POST["date"][8] . $_POST["date"][9]);
            // echo $table_name;
            $sql = "SELECT * FROM $table_name" . "_day where day = '$day'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            // echo $option;
            if ($option == "present"){
                if ($row["roll_number_$roll_number"]){
                    echo
                    "
                        <script>
                            alert('It is already marked as present');
                        </script>
                    "
                    ;
                }
                else{
                    $table_name1 = $table_name . "_roll";
                    $table_name2 = $table_name . "_day";
                    $sql1 = "UPDATE $table_name1 SET day_$day = 1 WHERE roll_number = '$roll_number';";
                    $sql2 = "UPDATE $table_name2 SET roll_number_$roll_number = 1 WHERE day = '$day';";
                    // echo $sql1 . "<br>";
                    // echo $sql2 . "<br>";
                    $res1 = mysqli_query($conn, $sql1);
                    $res2 = mysqli_query($conn, $sql2);
                    if (!$res1 || !$res2){
                        echo 
                        "
                            <script>
                                alert('Problem in updating.Please try again');
                            </script>
                        ";
                    }
                    else{
                        echo 
                        "
                            <script>
                                alert('Updated successfully!');
                            </script>
                        ";
                    }
                }
            }
            else{
                if ($row["roll_number_$roll_number"] == 0){
                    echo
                    "
                        <script>
                            alert('It is already marked as absent');
                        </script>
                    "
                    ;
                }
                else{
                    $table_name1 = $table_name . "_roll";
                    $table_name2 = $table_name . "_day";
                    $sql1 = "UPDATE $table_name1 SET day_$day = 0 WHERE roll_number = '$roll_number';";
                    $sql2 = "UPDATE $table_name2 SET roll_number_$roll_number = 0 WHERE day = '$day';";
                    // echo $sql1 . "<br>";
                    // echo $sql2 . "<br>";
                    $res1 = mysqli_query($conn, $sql1);
                    $res2 = mysqli_query($conn, $sql2);
                    if (!$res1 || !$res2){
                        echo 
                        "
                            <script>
                                alert('Problem in updating.Please try again');
                            </script>
                        ";
                    }
                    else{
                        echo 
                        "
                            <script>
                                alert('Updated successfully!');
                            </script>
                        ";
                    }
                }
            }
        }
        echo 
        "
            <script>
                window.location.href = 'welcome.php';
            </script>
        ";
        // header("Location: welcome.php");
    }
?>