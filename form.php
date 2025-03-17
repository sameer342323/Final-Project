
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
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $success ="";

    // Check if username or email already exists
    $check_user = $conn->prepare("SELECT id FROM users WHERE username=? OR email=?");
    $check_user->bind_param("ss", $username, $email);
    $check_user->execute();
    $check_user->store_result();
    if ($check_user->num_rows > 0) {
        echo "$success";
    } else {
        // Insert user data
        $stmt = $conn->prepare("INSERT INTO users (username, password_hash, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $email, $first_name, $last_name);
    }

    $check_user->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
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
        .sub-container{
            display: flex;
            justify-content: space-between;
        }
        .sub-container img{
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
        input[type="text"], input[type="password"], input[type="email"] {
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
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sub-container">
            <h2>Signup</h2>
            <img src="tti logo.png" alt="">
        </div>
        <form method="POST" action="Login.php">
    <div class="form-group">
        <label>Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Email Address:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label>First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
    </div>
    <div class="form-group">
        <label>Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
    </div>
    <div class="form-group checkbox">
                <input type="checkbox" id="terms">
                <label for="terms">I have read the Grooveshark Terms of Service</label>
            </div>
            <?php if (isset($success)) { ?>
            <p style="color: rgb(253, 72, 72);"><?php echo "Username or Email already exists." ;?></p>
            <?php } ?>
    <button class="btn" type="submit">Signup</button>
</form>

    </div>
    <script>
        document.getElementById('terms').addEventListener('change', function() {
            document.querySelector('.btn').disabled = !this.checked;
        });
    </script>
</body>
</html>


