<?php
session_start();

// Database connection
$servername = "35.247.155.27";
$username = "Invoiz";
$password = "sebastian@james9061";
$dbname = "invoiz";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$admin_username = $admin_password = $error_message = "";

// Handle admin login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = trim($_POST['username']);
    $admin_password = trim($_POST['password']);

    // Fetch the admin details from the database
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the hashed password
        if (password_verify($admin_password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admindashboard.php"); // Redirect to admin dashboard
            exit();
        } else {
            $error_message = "Incorrect password.";
        }
    } else {
        $error_message = "Admin not found.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* Colors */
        body {
            background-color: rgba(244, 91, 105, 1); /* $redFire */
            font-family: 'Asap', sans-serif;
        }

        .login {
            overflow: hidden;
            background-color: white;
            padding: 40px 30px 30px 30px;
            border-radius: 10px;
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            transform: translate(-50%, -50%);
            transition: transform 300ms, box-shadow 300ms;
            box-shadow: 5px 10px 10px rgba(2, 128, 144, 0.2); /* $greenSeaweed */

            &::before, &::after {
                content: '';
                position: absolute;
                width: 600px;
                height: 600px;
                border-top-left-radius: 40%;
                border-top-right-radius: 45%;
                border-bottom-left-radius: 35%;
                border-bottom-right-radius: 40%;
                z-index: -1;
            }

            &::before {
                left: 40%;
                bottom: -130%;
                background-color: rgba(69, 105, 144, 0.15); /* $blueQueen */
                animation: wawes 6s infinite linear;
            }

            &::after {
                left: 35%;
                bottom: -125%;
                background-color: rgba(2, 128, 144, 0.2); /* $greenSeaweed */
                animation: wawes 7s infinite;
            }

            > input {
                font-family: 'Asap', sans-serif;
                display: block;
                border-radius: 5px;
                font-size: 16px;
                background: white;
                width: 100%;
                border: 0;
                padding: 10px 10px;
                margin: 15px -10px;
            }

            > button {
                font-family: 'Asap', sans-serif;
                cursor: pointer;
                color: #fff;
                font-size: 16px;
                text-transform: uppercase;
                width: 80px;
                border: 0;
                padding: 10px 0;
                margin-top: 10px;
                margin-left: -5px;
                border-radius: 5px;
                background-color: rgba(244, 91, 105, 1); /* $redFire */
                transition: background-color 300ms;

                &:hover {
                    background-color: darken(rgba(244, 91, 105, 1), 5%); /* Darker on hover */
                }
            }
        }

        @keyframes wawes {
            from { transform: rotate(0); }
            to { transform: rotate(360deg); }
        }

        a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.6);
            position: absolute;
            right: 10px;
            bottom: 10px;
            font-size: 12px;
        }

        .error {
            color: red; /* Error message styling */
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <form class="login" action="" method="POST">
        <h2>Admin Panel</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div> <!-- Error message display -->
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <a href="https://codepen.io/davinci/" target="_blank">Check my other pens</a>
</body>
</html>
