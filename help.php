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
        // $current_month = date("m");
        // $current_year = date("Y");
        // echo $days_in_month;
        
        
        $current_month = intval(date("m"));
        $current_year = 2024;
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
        // echo $days_in_month . "<br>";
        $table_name = "Attendance_" .$current_year . "_" . $current_month . "_roll";
        $columns = "roll_number VARCHAR(10) UNIQUE, ";
        for ($day = 1; $day <  $days_in_month; $day++){
            $columns .= "day_$day INT DEFAULT 0, ";
        }
        $columns .= "day_$days_in_month INT DEFAULT 0";
        $sql = "CREATE TABLE $table_name ($columns);";
        $res = mysqli_query($conn, $sql);

        for ($month = 1; $month <= 5; $month++){
            $current_month = $month;
            $current_year = 2024;
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
            // echo $days_in_month . "<br>";
            $table_name = "Attendance_" .$current_year . "_" . $current_month . "_roll";
            $columns = "roll_number VARCHAR(10) UNIQUE, ";
            for ($day = 1; $day <  $days_in_month; $day++){
                $columns .= "day_$day INT DEFAULT 0, ";
            }
            $columns .= "day_$days_in_month INT DEFAULT 0";
            $sql = "CREATE TABLE $table_name ($columns);";
            // $res = mysqli_query($conn, $sql);
        }

        // echo $sql;
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }
    
    // data inserting default values
    try {

        for ($roll = 1; $roll <= 100; $roll++){
            $current_month = intval(date("m"));
            $current_year = 2024;
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
            $table_name = "Attendance_" .$current_year . "_" . $current_month . "_roll";
            $sql = "INSERT INTO $table_name (roll_number) VALUES ('$roll')";
            $res = mysqli_query($conn, $sql);
        }

        for ($month = 1; $month <= 5; $month++){
            for ($roll = 1; $roll <= 100; $roll++){
                $current_month = $month;
                $current_year = 2024;
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
                $table_name = "Attendance_" .$current_year . "_" . $current_month . "_roll";
                $sql = "INSERT INTO $table_name (roll_number) VALUES ('$roll')";
                // $res = mysqli_query($conn, $sql);
            }
        }
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }

    // tabel creation according to day
    try {



        
        $current_month = intval(date("m"));
        $current_year = 2024;
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
        $table_name = "Attendance_" .$current_year . "_" . $current_month . "_day";
        // echo $table_name;
        $columns = "day VARCHAR(10) UNIQUE, ";
        for ($roll = 1; $roll < 100; $roll++){
            $columns .= "roll_number_$roll INT DEFAULT 0, ";
        }
        $columns .= "roll_number_100 INT DEFAULT 0";
        $sql = "CREATE TABLE $table_name ($columns);";
        // echo $sql;
        $res = mysqli_query($conn, $sql);


        for ($month = 1; $month < 5; $month++){
            $current_month = $month;
            $current_year = 2024;
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
            // $res = mysqli_query($conn, $sql);
        }
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }
    
    // data inserting default values
    try {


        $current_month = intval(date("m"));
            $current_year = 2024;
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
            $table_name = "Attendance_" .$current_year . "_" . $current_month . "_day";
            
            for ($day = 1; $day <= $days_in_month; $day++){
                $sql = "INSERT INTO $table_name (day) VALUES ('$day')";
                $res = mysqli_query($conn, $sql);
            }





        for ($month = 1; $month < 5; $month++){
            $current_month = $month;
            $current_year = 2024;
            $days_in_month = cal_days_in_month(CAL_GREGORIAN, $current_month, $current_year);
            $table_name = "Attendance_" .$current_year . "_" . $current_month . "_day";
            
            for ($day = 1; $day <= $days_in_month; $day++){
                $sql = "INSERT INTO $table_name (day) VALUES ('$day')";
                // $res = mysqli_query($conn, $sql);
            }
        }
    }
    catch (mysqli_sql_exception){
        echo mysqli_error($conn) . "<br>";
    }


    for ($roll = 1; $roll <= 100; $roll++) {
        $month = intval(date("m"));
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, 2024);
        for ($day = 1; $day <= $days_in_month; $day++) {
            $rand = random_int(0, 2);
            $attendance = ($rand == 0 || $rand == 1) ? 1 : 0;
            $sql1 = "UPDATE attendance_2024_" . $month . "_roll SET day_$day = $attendance WHERE roll_number = '$roll'";
            $sql2 = "UPDATE attendance_2024_". $month . "_day SET roll_number_$roll = $attendance WHERE day = '$day'";
            // echo ;
            mysqli_query($conn, $sql1);
            mysqli_query($conn, $sql2);
        }
    }





    for ($month = 8; $month < 13; $month++){
        $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, 2023);
        for ($roll = 1; $roll <= 100; $roll++) {
            for ($day = 1; $day <= $days_in_month; $day++) {
                $rand = random_int(0, 2);
                $attendance = ($rand == 0 || $rand == 1) ? 1 : 0;
                $sql1 = "UPDATE attendance_2023_" . $month . "_roll SET day_$day = $attendance WHERE roll_number = '$roll'";
                $sql2 = "UPDATE attendance_2023_". $month . "_day SET roll_number_$roll = $attendance WHERE day = '$day'";
                // echo ;
                // mysqli_query($conn, $sql1);
                // mysqli_query($conn, $sql2);
            }
        }
    }
?>