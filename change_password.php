<?php
session_start();

include_once('./config/dbconnection.php');

function auto_logout($field)
{
    $t = time();
    $t0 = $_SESSION[$field];
    $diff = $t - $t0;
    if ($diff > 1500 || !isset($t0)) {
        return true;
    } else {
        $_SESSION[$field] = time();
    }
}

// Place this at the top of each page where user activity is expected
if (auto_logout("user_time")) {
    session_unset();
    session_destroy();
    header("Location: login.php"); // Redirect to login page
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $username = mysqli_real_escape_string($con, $_POST["username"]);
    $current_password = mysqli_real_escape_string($con, $_POST["current_password"]);
    $new_password = mysqli_real_escape_string($con, $_POST["new_password"]);
    $confirm_new_password = mysqli_real_escape_string($con, $_POST["confirm_new_password"]);

    // Check if new password and confirm new password match
    if ($new_password !== $confirm_new_password) {
        echo "<script>alert('New password and confirm new password do not match.');</script>";
    } else {
        // Check if username and current password are correct
        $query = "SELECT * FROM user WHERE username='$username'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($current_password, $row['password'])) {
                // Update user's password
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT); // Hashing the new password
                $update_query = "UPDATE user SET password='$hashed_new_password' WHERE username='$username'";
                if (mysqli_query($con, $update_query)) {
                    echo "<script>alert('Password changed successfully.');</script>";
                    header('Location: login.php'); // Redirect to login page
                    exit();
                } else {
                    echo "<script>alert('Failed to change password. Please try again later.');</script>";
                }
            } else {
                echo "<script>alert('Incorrect current password.');</script>";
            }
        } else {
            echo "<script>alert('Username not found.');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        /* CSS styles for the form */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-top: 0;
            text-align: center;
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
            background-color: #4CAF50;
            /* Darker green */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Change Password</h2>
        <form action="change_password.php" method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="current_password" placeholder="Current Password" required><br>
            <input type="password" name="new_password" placeholder="New Password" required><br>
            <input type="password" name="confirm_new_password" placeholder="Confirm New Password" required><br>
            <button type="submit" name="change_password">Change Password</button>
        </form>
    </div>


</body>

</html>