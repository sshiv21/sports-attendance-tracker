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
        echo "couldn't connect <br>";
    }

    // tabel creation according to roll_number
    try {
        $current_month = date("m");
        $current_month = intval($current_month);
        $current_year = date("Y");
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
        $table_name = "Attendance_" .$current_year . "_" . $current_month . "_roll";
        $columns = "roll_number VARCHAR(10) UNIQUE, ";
        for ($day = 1; $day <  $days_in_month; $day++){
            $columns .= "day_$day INT DEFAULT 0, ";
        }
        $columns .= "day_$days_in_month INT DEFAULT 0";
        $sql = "CREATE TABLE $table_name ($columns);";
        // echo $sql;
        $res = mysqli_query($conn, $sql);
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }
    
    // data inserting default values
    try {
        for ($roll = 1; $roll <= 100; $roll++){
            $current_month = date("m");
            $current_month = intval($current_month);
            $current_year = date("Y");
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
            $table_name = "Attendance_" .$current_year . "_" . $current_month . "_roll";
            $sql = "INSERT INTO $table_name (roll_number) VALUES ('$roll')";
            $res = mysqli_query($conn, $sql);
        }
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }

    // tabel creation according to day
    try {
        $current_month = date("m");
        $current_month = intval($current_month);
        $current_year = date("Y");
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
        $table_name = "Attendance_" .$current_year . "_" . $current_month . "_day";
        // echo $table_name;
        $columns = "day VARCHAR(10) UNIQUE, ";
        for ($roll = 1; $roll < 100; $roll++){
            $columns .= "roll_Number_$roll INT DEFAULT 0, ";
        }
        $columns .= "roll_number_100 INT DEFAULT 0";
        $sql = "CREATE TABLE $table_name ($columns);";
        // echo $sql;
        $res = mysqli_query($conn, $sql);
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }
    
    // data inserting default values
    try {
        $current_month = date("m");
        $current_month = intval($current_month);
        $current_year = date("Y");
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
        $table_name = "Attendance_" .$current_year . "_" . $current_month . "_day";
        
        for ($day = 1; $day <= $days_in_month; $day++){
            $sql = "INSERT INTO $table_name (day) VALUES ('$day')";
            $res = mysqli_query($conn, $sql);
        }
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }
?>
