<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "invoiz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$admin_username = $admin_password = $success_message = $error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = trim($_POST['username']);
    $admin_password = trim($_POST['password']);
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT); // Hash the password

    // Basic validation
    if (empty($admin_username) || empty($admin_password)) {
        $error_message = "All fields are required.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $admin_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Username already exists.";
        } else {
            // Insert new admin into the database
            $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $admin_username, $hashed_password);

            if ($stmt->execute()) {
                $success_message = "Admin registered successfully.";
            } else {
                $error_message = "Error registering admin.";
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        .container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            text-align: center;
        }
        .input-box {
            margin-bottom: 15px;
        }
        .input-box input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        .btn {
            padding: 10px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Registration</h2>
        <?php if (!empty($success_message)): ?>
            <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="input-box">
                <input type="text" name="username" placeholder="Enter Username" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="input-box">
                <button type="submit" class="btn">Register Admin</button>
            </div>
        </form>
    </div>
</body>
</html>
