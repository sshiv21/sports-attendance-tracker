<?php
    session_start();
    $_SESSION["can_enter"] = 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIT Kanpur Sports Attendance Tracker</title>
    <link rel="stylesheet" href="set.css">
    <style>
        .container {
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 10px 20px ;
            width: 25rem;
            border-radius: 10px;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        form div {
            margin: 0.5rem;
            text-align: left;
        }

        .container .login-section form div label, .container .login-section form div input {
            font-size: 1.25rem;
        }

        form button:hover {
            cursor: pointer;
        }

        section a {
            text-decoration: none;
        }

        section a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <!-- <h1 id='heading'>IIT Kanpur Sports Attendance Tracker</h1> -->
    </header>
    <div class="container">
        <section class="login-section">
            <h2>Login</h2>
            <form id="login-form" action="approve-login.php" method="POST">
                <!-- <label for="game-type">Game:</label>
                <select name="game-type" id="game-type">
                </select> -->
                <div>
                    <label for="CCID">CCID:</label>
                    <input type="text" id="CCID" name="CCID" required>
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="mailto:help.website.28@gmail.com?subject=No%20account%20found">Send a mail</a></p>
        </section>
    </div>
    <footer>
        <p>&copy; 2024 Indian Institute of Technology, Kanpur</p>
    </footer>
    <script>
//     window.onload = function() {
//     let arr = ["Athletics", "Aquatics", "Badminton", "Basketball", "Cricket", "Football", "Hockey", "Lawn Tennis", "Squash", "Table Tennis", "Volleyball", "Chess", "Weightlifting"];
//     arr.sort();
//     for (let i = 0; i < arr.length; i++) {
//         let element = document.createElement("option");
//         element.value = arr[i];
//         element.id = arr[i];
//         element.innerText = arr[i];
//         document.getElementById("game-type").appendChild(element);
//     }
// }

    </script>
</body>
</html>
