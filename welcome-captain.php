<?php
    session_start();
    if ($_SESSION["can_enter"] == 0 || $_SESSION["is_captain"] == 0){
        header("Location: login.php");
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Captain's Page - IIT Kanpur Sports Attendance Tracker</title>
    <link rel="stylesheet" href="set.css">
    <style>
        main a {
            text-decoration: none;
            transition: all 0.5s ease-in-out;
            font-size: 1.5rem;
        }

        main a:hover {
            text-decoration: underline;
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Captain's Page - IIT Kanpur Sports Attendance Tracker</h1>
    </header>
    <main>
        <p>Welcome, <?php echo $_SESSION["game"] . "'s Captain " . $_SESSION["name"] . "!"?></p>
        <h1>Here you can manage attendance for different sports sessions:</h1>
        <li><a href="edit-attendance.php">Edit Attendance</a></li>
        <li><a href="show-attendance.php">Show Attendance</a></li>
        <li><a href="pending-change-game-requests.php">Pending Change Game Requests</a></li>
        <li><a href="#" id="logout">Logout</a></li>
        <li><a href="show-recent-game-change-requests.php">Show Recent Game Change Requests</a></li>
        <script>
            document.getElementById("logout").addEventListener("click", () => {
                if (confirm("Do you want to logout?")){
                    window.location.href = "logout.php";  
                }
            })
            </script>
    </main>
    <footer>
        <p>&copy; 2024 Indian Institute of Technology, Kanpur</p>
    </footer>
</body>
</html>
