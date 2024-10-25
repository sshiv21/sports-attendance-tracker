<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to IIT Kanpur Sports Attendance Tracker</title>
    <link rel="stylesheet" href="set.css">
    <style>
        nav li {
            list-style-type: none;
        }

        nav li a {
            text-decoration: none;
            transition: all 0.5s ease;
        }

        nav li a:hover {
            text-decoration: underline;
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to IIT Kanpur Sports Attendance Tracker</h1>
    </header>
    <main>
        <section class="welcome-section">
            <h2>Explore</h2>
            <nav>
                <li><a href="https://www.iitk.ac.in/" target="_blank">IIT Kanpur Website</a></li>
                <li><a href="login.php">Login</a></li>
            </nav>
            <div class="logo-container">
                <img src="iitk_logo.png" alt="IIT Kanpur Logo">
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Indian Institute of Technology, Kanpur</p>
    </footer>
</body>
</html>

<?php
    include("database.php");
    $file_name = "absent_days.csv";
    $absent_file_ptr = fopen($file_name, "w");
    $file_name = "present_days.csv";
    $present_file_ptr = fopen($file_name, "w");
    fclose($present_file_ptr);
    fclose($absent_file_ptr);        
?>