<?php
include_once('./config/dbconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $password = mysqli_real_escape_string($con, $_POST["password"]);
    $confirm_password = mysqli_real_escape_string($con, $_POST["confirm_password"]);
    $first_name = mysqli_real_escape_string($con, $_POST["first_name"]);
    $last_name = mysqli_real_escape_string($con, $_POST["last_name"]);

    // Validation
    if (empty($username) || empty($password) || empty($confirm_password) || empty($first_name) || empty($last_name)) {
        echo "<script>alert('All fields are required.');</script>";
    } elseif ($password !== $confirm_password) {
        echo "<script>alert('Password and Confirm Password do not match.');</script>";
    } else {
        // Check if username already exists
        $check_query = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($con, $check_query);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Username already exists. Please choose a different one.');</script>";
        } else {
            // Insert user data into the database
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashing the password
            $insert_query = "INSERT INTO user (username, password, first_name, last_name) VALUES ('$username', '$hashed_password', '$first_name', '$last_name')";
            if (mysqli_query($con, $insert_query)) {
                echo "<script>alert('Registration successful. You can now login.');</script>";
                header('Location: login.php'); // Redirect to login page
                exit();
            } else {
                echo "<script>alert('Registration failed. Please try again later.');</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
        <h2>User Registration</h2>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
            <input type="text" name="first_name" placeholder="First Name" required><br>
            <input type="text" name="last_name" placeholder="Last Name" required><br>
            <button type="submit" name="register">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
