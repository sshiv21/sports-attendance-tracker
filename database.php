<?php
$db_server = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "iitk";
$conn = null;

try {
    $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
} catch (mysqli_sql_exception $e) {
    echo "Couldn't connect: " . mysqli_error($conn);
}

// Function to check if a table is empty
function isTableEmpty($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM $table");
    $row = mysqli_fetch_assoc($result);
    return $row['count'] == 0;
}

// Function to check if a column exists in a table
function columnExists($conn, $table, $column) {
    $result = mysqli_query($conn, "SHOW COLUMNS FROM $table LIKE '$column'");
    return mysqli_num_rows($result) > 0;
}

// Create all_users table
try {
    $sql = "CREATE TABLE IF NOT EXISTS all_users (
            name VARCHAR(255),
            roll_number VARCHAR(20) UNIQUE,
            email VARCHAR(255),
            password VARCHAR(255),
            department VARCHAR(255),
            gender ENUM('Male', 'Female', 'Other'),
            phone_number VARCHAR(15)
        )";
    $res = mysqli_query($conn, $sql);

    if (isTableEmpty($conn, "all_users")) {
        for ($i = 1; $i < 1000; $i++) {
            $name = "User " . $i;
            $roll_number = 1000 + $i;
            $email = "user" . $i . "@example.com";
            $password = password_hash("password", PASSWORD_DEFAULT);
            $departments = ["MBA", "HSS", "CHM", "MTH", "PHY", "ES", "ECO", "AE", "BSBE", "CHE", "CE", "CSE", "EE", "MSE", "ME"];
            $department = $departments[random_int(0, sizeof($departments) - 1)];
            $gender = ["Male", "Female", "Other"][random_int(0, 2)];
            $phone_number = "+91-1234567890";
            $sql = "INSERT INTO all_users (name, roll_number, email, password, department, gender, phone_number) 
                    VALUES ('$name', '$roll_number', '$email', '$password', '$department', '$gender', '$phone_number')";
            $res = mysqli_query($conn, $sql);
        }
    }
} catch (mysqli_sql_exception $e) {
    echo "Error creating or inserting into all_users table: " . $e->getMessage();
}

// Create games table
try {
    $sql = "CREATE TABLE IF NOT EXISTS games (
            roll_number VARCHAR(20) UNIQUE,
            game VARCHAR(255)
        )";
    $res = mysqli_query($conn, $sql);

    if (isTableEmpty($conn, "games")) {
        $games = ["Athletics", "Aquatics", "Badminton", "Basketball", "Cricket", "Football", "Hockey", "Lawn Tennis", "Squash", "Table Tennis", "Volleyball", "Chess", "Weightlifting"];
        for ($i = 1; $i < 1000; $i++) {
            $roll_number = 1000 + $i;
            $game = $games[random_int(0, sizeof($games) - 1)];
            $sql = "INSERT INTO games (roll_number, game) VALUES ('$roll_number', '$game')";
            $res = mysqli_query($conn, $sql);
        }
    }
} catch (mysqli_sql_exception $e) {
    echo "Error creating or inserting into games table: " . $e->getMessage();
}

// Create captains table
try {
    $sql = "CREATE TABLE IF NOT EXISTS captains (
            roll_number VARCHAR(20) UNIQUE,
            game VARCHAR(255),
            gender ENUM('Male', 'Female', 'Other')
        )";
    $res = mysqli_query($conn, $sql);

    if (isTableEmpty($conn, "captains")) {
        $games = ["Athletics", "Aquatics", "Badminton", "Basketball", "Cricket", "Football", "Hockey", "Lawn Tennis", "Squash", "Table Tennis", "Volleyball", "Chess", "Weightlifting"];
        foreach ($games as $i => $game) {
            $roll_number_male = 1000 + $i;
            $gender_male = "Male";
            $sql = "INSERT INTO captains (roll_number, game, gender) VALUES ('$roll_number_male', '$game', '$gender_male')";
            $res = mysqli_query($conn, $sql);

            $sql = "UPDATE games SET roll_number = '$roll_number_male' WHERE game = '$game'";
            $res = mysqli_query($conn, $sql);

            $sql = "UPDATE all_users SET gender = '$gender_male' WHERE roll_number = '$roll_number_male'";
            $res = mysqli_query($conn, $sql);

            $roll_number_female = 1000 + $i + sizeof($games);
            $gender_female = "Female";
            $sql = "INSERT INTO captains (roll_number, game, gender) VALUES ('$roll_number_female', '$game', '$gender_female')";
            $res = mysqli_query($conn, $sql);

            $sql = "UPDATE games SET roll_number = '$roll_number_female' WHERE game = '$game'";
            $res = mysqli_query($conn, $sql);

            $sql = "UPDATE all_users SET gender = '$gender_female' WHERE roll_number = '$roll_number_female'";
            $res = mysqli_query($conn, $sql);
        }
    }
} catch (mysqli_sql_exception $e) {
    echo "Error creating or inserting into captains table: " . $e->getMessage();
}

// Create game_change_requests table
try {
    $sql = "CREATE TABLE IF NOT EXISTS game_change_requests (
            roll_number VARCHAR(20) UNIQUE,
            from_game VARCHAR(255),
            to_game VARCHAR(255),
            approve_from INT DEFAULT -1,
            approve_to INT DEFAULT -1
        )";
    $res = mysqli_query($conn, $sql);
} catch (mysqli_sql_exception $e) {
    echo "Error creating game_change_requests table: " . $e->getMessage();
}

// Create game_change_request_history table
try {
    $sql = "CREATE TABLE IF NOT EXISTS game_change_request_history (
            roll_number VARCHAR(20) UNIQUE,
            from_game VARCHAR(255),
            to_game VARCHAR(255),
            from_response BOOLEAN,
            to_response BOOLEAN,
            status BOOLEAN,
            request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
    $res = mysqli_query($conn, $sql);
} catch (mysqli_sql_exception $e) {
    echo "Error creating game_change_request_history table: " . $e->getMessage();
}

// Create attendance tables for current year and month
$cur_year = intval(date("Y"));
$cur_month = intval(date("m"));
$number_of_days = cal_days_in_month(CAL_GREGORIAN, $cur_month, $cur_year);

try {
    $table_name_day = "attendance_" . $cur_year . "_" . $cur_month . "_day";
    $sql = "CREATE TABLE IF NOT EXISTS $table_name_day (
            day INT
        )";
    $res = mysqli_query($conn, $sql);

    if (isTableEmpty($conn, $table_name_day)) {
        // Add roll number columns for attendance
        for ($roll_number = 1; $roll_number < 1000; $roll_number++) {
            $column_name = "roll_number_$roll_number";
            if (!columnExists($conn, $table_name_day, $column_name)) {
                $sql = "ALTER TABLE $table_name_day ADD $column_name BOOLEAN DEFAULT FALSE";
                $res = mysqli_query($conn, $sql);
            }
        }

        // Insert attendance records
        for ($day = 1; $day <= $number_of_days; $day++) {
            $sql = "INSERT INTO $table_name_day (day";
            for ($roll_number = 1; $roll_number < 1000; $roll_number++) {
                $column_name = "roll_number_$roll_number";
                $sql .= ", $column_name";
            }
            $sql .= ") VALUES ($day";

            for ($roll_number = 1; $roll_number < 1000; $roll_number++) {
                $t = random_int(0, 1);
                $sql .= ", $t";
            }
            $sql .= ")";
            $res = mysqli_query($conn, $sql);
        }
    }
} catch (mysqli_sql_exception $e) {
    echo "Error creating or inserting into attendance_day table: " . $e->getMessage();
}

try {
    $table_name_roll = "attendance_" . $cur_year . "_" . $cur_month . "_roll";
    $sql = "CREATE TABLE IF NOT EXISTS $table_name_roll (
            roll_number INT UNIQUE
        )";
    $res = mysqli_query($conn, $sql);

    if (isTableEmpty($conn, $table_name_roll)) {
        // Add day columns for attendance
        for ($i = 1; $i <= $number_of_days; $i++) {
            $day_column_name = "day_$i";
            if (!columnExists($conn, $table_name_roll, $day_column_name)) {
                $sql = "ALTER TABLE $table_name_roll ADD $day_column_name INT DEFAULT 0";
                $res = mysqli_query($conn, $sql);
            }
        }

        // Insert attendance records
        for ($roll_number = 1; $roll_number < 1000; $roll_number++) {
            $sql = "INSERT INTO $table_name_roll (roll_number";
            for ($day = 1; $day <= $number_of_days; $day++) {
                $day_column_name = "day_$day";
                $sql .= ", $day_column_name";
            }
            $sql .= ") VALUES ($roll_number";

            for ($day = 1; $day <= $number_of_days; $day++) {
                $t = random_int(0, 1);
                $sql .= ", $t";
            }
            $sql .= ")";
            // $res = mysqli_query($conn, $sql);
        }
    }
} catch (mysqli_sql_exception $e) {
    echo "Error creating or inserting into attendance_roll table: " . $e->getMessage();
}
?>




<?php
    // $db_server = "localhost";
    // $db_user = "root";
    // $db_password = "";
    // $db_name = "iitk";
    // $conn = null;

    // try {
    //     $conn = mysqli_connect($db_server, $db_user, $db_password, $db_name);
    // }
    // catch (mysqli_sql_exception) {
    //     echo "Couldn't connect: ", mysqli_error($conn);
    // }

    // // create all_users
    // try {
    //     $sql = "CREATE TABLE IF NOT EXISTS all_users (
    //             name VARCHAR(255),
    //             roll_number VARCHAR(20) UNIQUE,
    //             email VARCHAR(255),
    //             password VARCHAR(255),
    //             department VARCHAR(255),
    //             gender ENUM('Male', 'Female', 'Other'),
    //             phone_number VARCHAR(15),
    //         )";
    //         $res = mysqli_query($conn, $sql);

    //     // function to dump some random data into all_users table
    //     for ($i = 1; $i < 1000; $i++) {
    //         $name = "User ". $i;
    //         $roll_number = 1000 + $i;
    //         $email = "user". $i. "@example.com";
    //         $password = password_hash("password", PASSWORD_DEFAULT);
    //         $departments = ["MBA","HSS","CHM","MTH","PHY","ES","ECO","AE","BSBE","CHE","CE","CSE","EE","MSE","ME"];
    //         $department = $departments[random_int(0, sizeof($departments) - 1)];
    //         $gender = ["Male", "Female", "Other"][random_int(0, 2)];
    //         $phone_number = "+91-1234567890";
    //         $sql = "INSERT INTO all_users (name, roll_number, email, password, department, gender, phone_number) VALUES ('$name', '$roll_number', '$email', '$password', '$department', '$gender', '$phone_number')";
    //         $res = mysqli_query($conn, $sql);
    //     }
    // }
    // catch (mysqli_sql_exception $e) {
    // }
    
    
    // // create table games
    // try {
    //     $sql = "CREATE TABLE IF NOT EXISTS games (
    //         roll_number VARCHAR(20) UNIQUE,
    //         game VARCHAR(255),
    //     )";
    //     $res = mysqli_query($conn, $sql);
    // }
    // catch (mysqli_sql_exception $sql) {
    // }
    // // dump data into games table
    // $games = ["Athletics", "Aquatics", "Badminton", "Basketball", "Cricket", "Football", "Hockey", "Lawn Tennis", "Squash", "Table Tennis", "Volleyball", "Chess", "Weightlifting"];
    // for ($i = 1; $i < 1000; $i++) {
    //     $roll_number = 1000 + $i;
    //     $game = $games[random_int(0, sizeof($games) - 1)];
    //     $sql = "INSERT INTO games (roll_number, game) VALUES ('$roll_number', '$game')";
    //     $res = mysqli_query($conn, $sql);
    // }

    // // create captains table
    // try {
    //     $sql = "CREATE TABLE IF NOT EXISTS captains (
    //     roll_number VARCHAR(20) UNIQUE,
    //     game VARCHAR(255),
    //     gender ENUM('Male', 'Female', 'Other')";
    //     $res = mysqli_query($conn, $sql);
    //     // dump random values into the table
    //     $games = ["Athletics", "Aquatics", "Badminton", "Basketball", "Cricket", "Football", "Hockey", "Lawn Tennis", "Squash", "Table Tennis", "Volleyball", "Chess", "Weightlifting"];
    //     for ($i = 0; $i < sizeof($games) - 1; $i++) {
    //         $roll_number = 1000 + $i;
    //         $game = $games[$i];
    //         $gender = "Male";
    //         $sql = "INSERT INTO captains (roll_number, game, gender) VALUES ('$roll_number', '$game', '$gender')";
    //         $res = mysqli_query($conn, $sql);
    //         // update games and all_users table accoringly
    //         $sql = "UPDATE games SET roll_number = '$roll_number', gender = '$gender' WHERE game = '$game'";
    //         $res = mysqli_query($conn, $sql);
    //         $sql = "UPDATE all_users SET gender = '$gender' WHERE roll_number = '$roll_number'";
    //         $res = mysqli_query($conn, $sql);

    //         $roll_number = 1000 + $i + sizeof($games);
    //         $game = $games[$i];
    //         $gender = "Female";
    //         $sql = "INSERT INTO captains (roll_number, game, gender) VALUES ('$roll_number', '$game', '$gender')";
    //         $res = mysqli_query($conn, $sql);
    //         // update games and all_users table accoringly
    //         $sql = "UPDATE games SET roll_number = '$roll_number', gender = '$gender' WHERE game = '$game'";
    //         $res = mysqli_query($conn, $sql);
    //         $sql = "UPDATE all_users SET gender = '$gender' WHERE roll_number = '$roll_number'";
    //         $res = mysqli_query($conn, $sql);
    //     }
    // }
    // catch (mysqli_sql_exception $e) {
    // }

    // // create table game_change_requests
    // try {
    //     $sql = "CREATE TABLE IF NOT EXISTS game_change_requests (
    //         roll_number VARCHAR(20) UNIQUE,
    //         from_game VARCHAR(255),
    //         to_game VARCHAR(255),
    //         approve_from INT DEFAULT -1,
    //         approve_to INT DEFAULT -1
    //     )";
    //     $res = mysqli_query($conn, $sql);
    // }
    // catch (mysqli_sql_exception $e) {
    // }

    // // create table game_change_request_history
    // try {
    //     $sql = "CREATE TABLE IF NOT EXISTS game_change_request_history (
    //         roll_number VARCHAR(20) UNIQUE,
    //         from_game VARCHAR(255),
    //         to_game VARCHAR(255),
    //         from_response BOOLEAN,
    //         to_response BOOLEAN,
    //         status BOOLEAN,
    //         request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    //     )";
    //     $res = mysqli_query($conn, $sql);
    // }
    // catch (mysqli_sql_exception $e) {
    // }

    // // create table attendance for all days for each roll_number
    // $cur_year = intval(date("Y"));
    // $cur_month = intval(date("m"));
    // $number_of_days = cal_days_in_month(CAL_GREGORIAN, $cur_month, $cur_year);
    // try {
    //     $sql = "CREATE TABLE IF NOT EXISTS attendance_$cur_year_$cur_month" . "_day (
    //         day INT
    //     )";
    //     $res = mysqli_query($conn, $sql);
    //     for ($roll_number = 1; $roll_number < 1000; $roll_number++) {
    //         $sql = "ALTER TABLE attendance_$cur_year_$cur_month" . "_day ADD roll_number_$roll_number BOOLEAN DEFAULT FALSE";
    //         $res = mysqli_query($conn, $sql);
    //     }
    //     // dumpp data into attendance_$cur_year_$cur_month_day table
    //     for ($day = 1; $day <= $number_of_days; $day++) {
    //         $day_column_name = "day_$i";
    //         $sql = "INSERT INTO attendance_$cur_year_$cur_month" . "_day VALUES (";
    //         for ($roll_number = 1; $roll_number < 1000; $roll_number++) {
    //             $t = $random_int(0, 1);
    //             $sql .= "$t";
    //             if ($day != $number_of_days) {
    //                 $sql .= ", ";
    //             }
    //         }
    //         $res = mysqli_query($conn, $sql);
    //     }
    // }
    // catch (mysqli_sql_exception $e) {
    // }

    // try {
    //     $sql = "CREATE TABLE IF NOT EXISTS attendance_$cur_year_$cur_month" . " _roll (
    //         day INT UNIQUE,
    //     )";
    //     for ($i = 1; $i <= $number_of_days; $i++) {
    //         $day_column_name = "day_$i";
    //         $sql = "ALTER TABLE attendance_$cur_year_$cur_month" . "_roll ADD $day_column_name INT DEFAULT 0";
    //         $res = mysqli_query($conn, $sql);
    //     }
    //     // dump data into attendance_$cur_year_$cur_month_roll table
    //     for ($roll_number = 1; $roll_number < 1000; $roll_number++) {
    //         $sql = "INSERT INTO attendance_$cur_year_$cur_month" . "_roll VALUES (";
    //         for ($day = 1; $day <= $number_of_days; $day++) {
    //             $t = random_int(0, 1);
    //             $sql .= "$t";
    //             if ($day!= $number_of_days) {
    //                 $sql .= ", ";
    //             }
    //             $res = mysqli_query($conn, $sql);
    //         }
    //     }
    // }
    // catch (mysqli_sql_exception $e) {
    // }
?>
