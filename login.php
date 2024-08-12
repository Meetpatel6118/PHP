S<?php
session_start();
include_once('./config/dbconnection.php');


// Check if the user is already logged in, redirect to home page
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);

    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        echo "<script>alert('here is the password ".$password." ');</script>";
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_time'] = time();S
        }
    } else {
        echo "<script>alert('Username not found. Please register.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Additional CSS for centering the form */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: skyblue;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #4CAF50; /* Darker green */
        }
        p {
            margin-top: 20px;
            text-align: center;
        }
        a {
            color: skyblue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Login</h2>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
</body>
</html>
