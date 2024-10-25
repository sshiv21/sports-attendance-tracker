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

    $months = ["", "JANUARY", "FEBRUARY", "MARCH", "APRIL", "MAY", "JUNE", 
    "JULY", "AUGUST", "SEPTMBER", "OCTOBER", "NOVEMBER", "DECEMBER"];

    // echo date("M");
    if (isset($_POST["submit"])){
        $roll_number = $_POST["roll-number"];
        if ($_SESSION["is_captain"] == 0 && $roll_number != $_SESSION["roll_number"]){
            // header("Location: welcome-student.php");
            echo
            "
                <script>
                    alert('You are only allowed to view your attendance.');
                    window.location.href = 'welcome-student.php';
                </script>
            "
            ;
        }
        $sql = "SELECT * FROM all_users WHERE roll_number = '$roll_number'";
        $res = mysqli_query($conn, $sql);
        $res_row = mysqli_fetch_assoc($res);
        $name = $res_row["name"];
        echo $name . "(" . $roll_number . ")<br>";
        $cur_month = intval(date("m"));
        $cur_year = intval(date("Y"));
        
        $file_name = "present_days.csv";
        $present_file_ptr = fopen($file_name, "w");
        fputcsv($present_file_ptr, ["Date", "Month", "Year"]);
        fputcsv($present_file_ptr, [$name . "(" . $roll_number . ")"]);
        
        $file_name = "absent_days.csv";
        $absent_file_ptr = fopen($file_name, "w");
        fputcsv($absent_file_ptr, ["Date", "Month", "Year"]);
        fputcsv($absent_file_ptr, [$name . "(" . $roll_number . ")"]);

        $total_present_days = 0;
        $total_off_days = 0;
        $total_absent_days = 0;

        if ($cur_month == 1 || $cur_month == 2 || $cur_month == 3 || $cur_month == 4 ||
        $cur_month == 5 || $cur_month == 6 || $cur_month == 7){
            $cur_year--;
            for ($month = 8, $present_days = 0, $off_days = 0, $absent_days = 0; $month < 13; $month++, $present_days = 0, $off_days = 0, $absent_days = 0){
                echo $months[$month] . ": ";
                $table_name = "attendance_$cur_year" . "_$month" . "_roll";
                // echo $table_name . "<br>";
                $sql = "SELECT * FROM $table_name WHERE roll_number = '$roll_number'";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($res);
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $cur_year + 1);
                for ($day = 1; $day <= $days_in_month; $day++){
                    if ($row["day_$day"] == 1){
                        echo $day . " ";
                        $present_days++;
                        fputcsv($present_file_ptr, [$day, $month, $cur_year]);
                    }
                    else if ($row["day_$day"] == 2){
                        $off_days++;
                    }
                    else{
                        fputcsv($absent_file_ptr, [$day, $month, $cur_year]);
                        $absent_days++;
                    }
                }

                $total_present_days += $present_days;
                $total_off_days += $off_days;
                $total_absent_days += $absent_days;
                echo "<br>";
            }

            $cur_year++;
            for ($month = 1, $present_days = 0, $off_days = 0, $absent_days = 0; $month < $cur_month; $month++, $present_days = 0, $off_days = 0, $absent_days = 0){
                echo $months[$month] . ": ";
                $table_name = "attendance_$cur_year" . "_$month" . "_roll";
                // echo $table_name . "<br>";
                try {
                    $sql = "SELECT * FROM $table_name WHERE roll_number = '$roll_number'";
                    $res = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($res);
                    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $cur_year);
                    for ($day = 1; $day <= $days_in_month; $day++){
                        if ($row["day_$day"] == 1){
                            echo $day . " ";
                            $present_days++;
                            fputcsv($present_file_ptr, [$day, $month, $cur_year]);
                        }
                        else if ($row["day_$day"] == 2){
                            $off_days++;
                        }
                        else{
                            fputcsv($absent_file_ptr, [$day, $month, $cur_year]);
                            $absent_days++;
                        }
                    }
    
                    $total_present_days += $present_days;
                    $total_off_days += $off_days;
                    $total_absent_days += $absent_days;
                    echo "<br>";
                } catch (mysqli_sql_exception) {
                    echo "Please wait for the server to update the database!<br>";
                }
            }
            
            try {
                // handle current month
                $cur_date = intval(date("d"));
                $table_name = "attendance_$cur_year" . "_$month" . "_roll";
                // echo $table_name . "<br>";
                echo $months[$cur_month] . ": ";
                $sql = "SELECT * FROM $table_name WHERE roll_number = '$roll_number'";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($res);
                $present_days = 0;
                $off_days = 0;
                $absent_days = 0;
                for ($day = 1; $day <= $cur_date; $day++){
                    if ($row["day_$day"] == 1){
                        echo $day . " ";
                        $present_days++;
                        fputcsv($present_file_ptr, [$day, $month, $cur_year]);
                    }
                    else if ($row["day_$day"] == 2){
                        $off_days++;
                    }
                    else{
                        fputcsv($absent_file_ptr, [$day, $month, $cur_year]);
                        $absent_days++;
                    }
                }
            } 
            catch (mysqli_sql_exception) {
                echo "Please wait for the server to update the database!<br>";
            }

            $total_present_days += $present_days;
            $total_off_days += $off_days;
            $total_absent_days += $absent_days;
            echo "<br>";
        }

        else{
            for ($month = 8, $off_days = 0, $present_days = 0, $absent_days = 0; $month < $cur_month; $month++, $off_days = 0, $present_days = 0, $absent_days = 0){
                echo $months[$month] . ": ";
                $table_name = "attendance_$cur_year" . "_$month" . "_roll";
                // echo $table_name . "<br>";
                $sql = "SELECT * FROM $table_name WHERE roll_number = '$roll_number'";
                $res = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($res);
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $cur_year);
                for ($day = 1; $day <= $days_in_month; $day++){
                    if ($row["day_$day"] == 1){
                        echo $day . " ";
                        $present_days++;
                        fputcsv($present_file_ptr, [$day, $month, $cur_year]);
                    }
                    else if ($row["day_$day"] == 2){
                        $off_days++;
                    }
                    else{
                        fputcsv($absent_file_ptr, [$day, $month, $cur_year]);
                        $absent_days++;
                    }
                }

                $total_off_days += $off_days;
                $total_present_days += $present_days;
                $total_absent_days += $absent_days;
                echo "<br>";
            }

            // handle current month
            $cur_date = intval(date("d"));
            $table_name = "attendance_$cur_year" . "_$month" . "_roll";
            // echo $table_name . "<br>";
            echo $months[$cur_month] . ": ";
            $sql = "SELECT * FROM $table_name WHERE roll_number = '$roll_number'";
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $off_days = 0;
            $present_days = 0;
            $absent_days = 0;
            for ($day = 1; $day <= $cur_date; $day++){
                if ($row["day_$day"] == 1){
                    echo $day . " ";
                    $present_days++;
                    fputcsv($present_file_ptr, [$day, $month, $cur_year]);
                }
                else if ($row["day_$day"] == 2){
                    $off_days++;
                }
                else{
                    fputcsv($absent_file_ptr, [$day, $month, $cur_year]);
                    $absent_days++;
                }
            }

            $total_off_days += $off_days;
            $total_present_days += $present_days;
            $total_absent_days += $absent_days;
            echo "<br>";
        }
    }

    fputcsv($present_file_ptr, []);
    fputcsv($present_file_ptr, []);
    fputcsv($present_file_ptr, []);
    fputcsv($absent_file_ptr, []);
    fputcsv($absent_file_ptr, []);
    fputcsv($absent_file_ptr, []);
    fputcsv($present_file_ptr, ["Total number of days present", $total_present_days]);
    fputcsv($absent_file_ptr, ["Total number of days absent", $total_absent_days]);
    fputcsv($present_file_ptr, ["Total number of days present in %", ($total_present_days * 100)/ ($total_absent_days + $total_present_days) . "%"]);
    fputcsv($absent_file_ptr, ["Total number of days absent in %", ($total_absent_days * 100) / ($total_absent_days + $total_present_days) . "%"]);
    fclose($present_file_ptr);
    fclose($absent_file_ptr);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="present_days.csv" download="<?php echo $name . '_present_days'; ?>">Download Present Days</a>
    <a href="absent_days.csv" download="<?php echo $name . '_absent_days'; ?>">Download Absent Days</a>
</body>
</html>