<?php
    session_start();
    if ($_SESSION["can_enter"] == 0){
        header("Location: login.php");
    }
?>

<?php
    if (isset($_POST["submit"])){
        // echo "Submitted<br>";

        if (isset($_POST["roll_number"])){
            // echo "Roll number<br>";
            header("Location: show-attendance-show-roll-numbers.php");
        }
        
        if (isset($_POST["day"])){
            // echo "Day<br>";
            header("Location: show-attendance-show-days.php");
        }
    }
?>

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
    <div class="container">
        <form action="show-attendance.php" method="post">
            <label for="roll_number">Roll Number wise</label>
            <input type="radio" name="roll_number" id="roll_number">
            <label for="day">Day wise</label>
            <input type="radio" name="day" id="day">
            <button type="submit" name="submit">Show Details</button>
        </form>
    </div>
    <script>
        let radio_buttons = document.getElementsByTagName("input");
        for (let button of radio_buttons){
            button.addEventListener("click", () => {
                // alert();
                for (let b of radio_buttons){
                    if (b != button){
                        b.checked = false;
                    }
                    else{
                        b.checked = true;
                    }
                }
            })
        }
    </script>
</body>
</html>