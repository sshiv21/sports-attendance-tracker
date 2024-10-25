<?php
    session_start();
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

    if (isset($_POST["submit"])){
        $CCID = $_POST["CCID"];
        $password = $_POST["password"];
        $email = $CCID . "@email.com";
        $sql = "select * from all_users where email = '$email'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $pass = $row["password"];

            if ($pass == $password){
                $_SESSION["roll_number"] = $row['roll_number'];
                $_SESSION["can_enter"] = 1;
                $_SESSION["name"] = $row["name"];
                // echo $_SESSION["can_enter"];
                echo '
                <script>
                    alert("Login success");
                    window.location.href = "welcome.php";
                </script>';
            }
            else{
                echo '
                <script>
                    alert("Incorrect Password/CCID");
                    window.location.href = "login.php";
                </script>';
            }
        } 
        else {
            echo '
            <script>
                alert("Incorrect Password/CCID/Game Type");
                window.location.href = "login.php";
            </script>';
        }
    }
?>