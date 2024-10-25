<?php
    session_start();
    if ($_SESSION["can_enter"] == 0){
        header("Location: login.php");
    }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Student</title>
    <link rel="stylesheet" href="set.css">
    
    <style>
        header {
            display: flex;
            justify-content: space-between;
        }

        main {
            display: flex;
            flex-direction: column;
        }

        form button {
            cursor: pointer;
        }
    </style>
    
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION["name"]?>!</h1>
        <h1>Game: <?php echo $_SESSION["game"]?></h1>
    </header>
    <main>
        <form action="fetch-roll-number-attendance.php" method="post">
            <label for="roll-number">Roll Number:</label>
            <input type="text" name="roll-number" id="roll-number" readonly>
            <script>document.getElementById("roll-number").value = '<?php echo $_SESSION["roll_number"];?>'</script>
            <button name="submit" type="submit">Show Attendance</button>
        </form>
        <div>
            <li><a href="request-change-game.php">Request for Changing Game</a></li>
            <li><a href="show-recent-game-change-requests.php">Show Recent Game change Requests</a></li>
            <li><a href="#" id="logout">Logout</a></li>
        </div>
        <script>
            document.getElementById("logout").addEventListener("click", () => {
                if (confirm("Do you want to logout?")){
                    window.location.href = "logout.php";  
                }
            })
        </script>
    </main>
    <main>
        <!-- <section>
            <h2>Announcements</h2>
            Add announcements here
        </section> -->
        <!-- <section>
            <h2>Your Schedule</h2>
            Add student's schedule here
        </section> -->
        <!-- <section>
            <h2>Upcoming Events</h2>
            Add upcoming events here
        </section>
    </main> -->
    <!-- <footer>
        <p>&copy; 2024 Your College Name</p>
    </footer> -->
</body>
</html>
