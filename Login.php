<?php
// Configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'user_registration';

// Create connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password are correct
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($password_hash);
        $stmt->fetch();

        if (password_verify($password, $password_hash)) {
            // Login successful, redirect to dashboard
            session_start();
            $_SESSION["username"] = $username;
            header("Location: Index.php");
            exit;
        } else {
            echo "Invalid password";
        }
    } else {
        echo "Invalid username";
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        
        .sub-container {
            display: flex;
            justify-content: space-between;
        }
        
        .sub-container img {
            width: 50px;
            height: 50px;
        }
        
        .container h2 {
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 10px;
        }
        
        label {
            display: block;
            font-weight: bold;
        }
        
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        .checkbox {
            display: flex;
            align-items: center;
        }
        
        .checkbox input {
            margin-right: 5px;
        }
        
        .btn {
            width: 100%;
            background: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }
        </style>
</head>
<body>
    <div class="container">
        <div class="sub-container">
            <h2>Login</h2>
            <img src="tti logo.png" alt="Logo">
        </div>
        <form" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <span class="error"><?php echo $usernameErr; ?></span>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <div class="form-group checkbox">
                <input type="checkbox" id="remember-me" name="remember-me">
                <label for="remember-me">Remember Me</label>
            </div>
            <button class="btn" type="submit">Login</button>
            <p>Don't have an account? <a href="form.php">Signup</a></p>
        </form>
    </div>
</body>
</html>
