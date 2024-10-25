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
    <a download="<?php echo "present_" . $_POST["date"] . ".csv"; ?>" href="students_present.csv">Download Present</a>
    <a download="<?php echo "absent_" . $_POST["date"] . ".csv"; ?>" href="students_absent.csv">Download Absent</a>
</body>
</html>

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
    // echo "<br";
    if ($_SESSION["is_captain"] == 0){
        echo
        "
            <script>
                alert('You are not allowed to visit this page');
                window.location.href = 'welcome-student.php';
            </script>
        ";
    }
    if (isset($_POST["submit"])){
        $date = intval($_POST["date"][0] . $_POST["date"][1] . $_POST["date"][2] . $_POST["date"][3] . $_POST["date"][5] . $_POST["date"][6] . $_POST["date"][8] . $_POST["date"][9]);
        echo var_dump($date) . "<br>";
        $year = date("Y");
        $min_date = intval($year - 1 . "0801");
        echo var_dump($min_date) . "<br>";
        $temp_date = "";
        if (intval(date("j")) < 10){
            $temp_date = "0" . date("j");
        }
        echo var_dump($temp_date) . "<br>";
        $max_date = date("Ym") + $temp_date;
        echo var_dump($max_date) . "<br>";
        // $max_date = intval($max_date);
        // echo var_dump($max_date) . "<br>";
        $month = ($_POST["date"][5] . $_POST["date"][6]);
        $day = ($_POST["date"][8] . $_POST["date"][9]);
        
        $file_name = "students_present.csv";
        $students_present_file_ptr = fopen($file_name, "w");
        $file_name = "students_absent.csv";
        $students_absent_file_ptr = fopen($file_name, "w");
        fputcsv($students_present_file_ptr, ["Name", "Roll Number"]);
        fputcsv($students_absent_file_ptr, ["Name", "Roll Number"]);
        fputcsv($students_present_file_ptr, [$_POST["date"]]);
        fputcsv($students_absent_file_ptr, [$_POST["date"]]);
        $absent_students = 0;
        $present_students = 0;
        // if date lies in the given range
        if ($min_date <= $date && $date <= $max_date){
            $tabel_name = "attendance_" . $_POST["date"][0] . $_POST["date"][1] . $_POST["date"][2] . $_POST["date"][3] . "_" . $month . "_day";
            echo "<br>" . $tabel_name . "<br>";
            $sql = "SELECT * FROM $tabel_name WHERE day = '$day';";
            // echo $sql . "<br>";
            $res = mysqli_query($conn, $sql);
            // echo "Found rows: " .47 mysqli_num_rows($res) . "<br>";
            if (mysqli_num_rows($res) > 0){
                $row = mysqli_fetch_assoc($res);
                for ($roll = 1; $roll <= 100; $roll++){
                    $s = "SELECT * FROM all_users WHERE roll_number = '$roll'";
                    $r = mysqli_query($conn, $s);
                    $name = mysqli_fetch_assoc($r)["name"];
                    if ($row["roll_number_$roll"] == 1){
                        echo $name . "(" . $roll . ")<br>";
                        $present_students++;
                        fputcsv($students_present_file_ptr, [$roll, $name]);
                    }
                    else if ($row["roll_number_$roll"] == 0){
                        $absent_students++;
                        fputcsv($students_absent_file_ptr, [$roll, $name]);
                    }
                }
            }
            
            fputcsv($students_absent_file_ptr, [""]);
            fputcsv($students_present_file_ptr, [""]);
            fputcsv($students_absent_file_ptr, [""]);
            fputcsv($students_present_file_ptr, [""]);
            fputcsv($students_absent_file_ptr, [""]);
            fputcsv($students_present_file_ptr, [""]);

            fputcsv($students_absent_file_ptr, ["Number of absent students", $absent_students]);
            fputcsv($students_present_file_ptr, ["Number of present students", $present_students]);
            fputcsv($students_absent_file_ptr, ["Number of absent students%", (100 * $absent_students) / ($present_students + $absent_students) . "%"]);
            fputcsv($students_present_file_ptr, ["Number of present students%", (100 * $present_students) / ($present_students + $absent_students) . "%"]);

            fclose($students_absent_file_ptr);
            fclose($students_present_file_ptr);
        }
        else{
            echo "<h1>Please enter a valid date</h1>";
        }
    }
?>
