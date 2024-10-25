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

    // for ($roll_number = 1; $roll_number < 100; $roll_number++){
    //     $table_name = "attendance_2023_12_day";
    //     $sql = "ALTER TABLE $table_name
    //         CHANGE roll_Number_$roll_number roll_number_$roll_number INT;
    //     ";
    //     echo $sql . "<br>";
    //     mysqli_query($conn, $sql);
    // }
    // for ($roll = 1; $roll <= 100; $roll++) {
    //     for ($day = 1; $day <= 30; $day++) {
    //         $rand = random_int(0, 2);
    //         $attendance = ($rand == 0 || $rand == 1) ? 1 : 0;
    //         $sql = "UPDATE attendance_2024_04_roll SET day_$day = $attendance WHERE roll_number = '$roll'";
    //         $sql = "UPDATE attendance_2024_04_day SET roll_number_$roll = $attendance WHERE day = '$day'";
    //         // mysqli_query($conn, $sql);
    //     }
    // }


    // for ($day = 1; $day < 17; $day++){
    //     for ($roll = 1; $roll <= 100; $roll++){
    //         $col = "day_" . $day;
    //         $rand = random_int(0, 1200);
    //         if ($rand % 3 != 0){
    //             $sql = "INSERT INTO attendance_2024_04 ($col) VALUES('$roll');";
    //             echo $sql . "<br>";
    //             mysqli_query($conn, $sql);
    //         }    
    //     }
    // }
    // $sql = "select * from games where game = 'Weightlifting'";
    // $res = mysqli_query($conn, $sql);

    // while ($row = mysqli_fetch_assoc($res)){
    //     echo "Player Roll Number: ". $row['roll_number'] . "<br>";
    //     $sql_fetch = "select * from all_users where roll_number = " . $row['roll_number'];
    //     $sql_exe = mysqli_query($conn, $sql_fetch);
    //     $r = mysqli_fetch_assoc($sql_exe);
    //     echo "Player Gender: ". $r['gender'] . "<br>";
    // }
    // $sql = "SHOW TABLES";
    // $res = mysqli_query($conn, $sql);
    // if (mysqli_num_rows($res) > 0) {
    //     // Loop through each row
    //     while ($row = mysqli_fetch_assoc($res)) {
    //         // Echo the name of each table
    //         echo $row['Tables_in_' . $db_name] . "<br>";
    //     }
    // } else {
    //     echo "No tables found in the database";
    // }

    // $arr = ["Athletics", "Aquatics", "Badminton", "Basketball", "Cricket", "Football", "Hockey", "Lawn Tennis", "Squash", "Table Tennis", "Volleyball", "Chess", "Weightlifting"];
    // for ($i = 1; $i <= 50; $i++){
    //     $ind = rand(0, count($arr) - 1);
    //     $roll_number = "$i";

    //     $sql = "INSERT INTO games (roll_number, game) VALUES ('$i', '{$arr[$ind]}')";
    // }

?>