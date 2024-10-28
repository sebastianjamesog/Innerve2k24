<?php
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

$email = $status_message = "";
$pes_data = $bgmi_data = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Query for PES (users table)
    $stmt = $conn->prepare("SELECT college_name, student_name, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user is found in users table (PES)
    if ($result->num_rows > 0) {
        $pes_data = $result->fetch_assoc();
    }

    $stmt->close();

    // Query for BGMI (team_registration table)
    $stmt = $conn->prepare("SELECT team_name AS college_name, leader_name AS student_name, status FROM team_registration WHERE leader_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user is found in team_registration table (BGMI)
    if ($result->num_rows > 0) {
        $bgmi_data = $result->fetch_assoc();
    }

    $stmt->close();

    // Set status message if no registration found in both tables
    if (!$pes_data && !$bgmi_data) {
        $status_message = "No registration found for this email.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Registration Status</title>
    <style>
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .input-box {
            margin-bottom: 15px;
        }
        .input-box input {
            width: 100%;
            padding: 10px;
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
        .message {
            margin-top: 20px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 16px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Check Registration Status</h2>
        <form action="" method="POST">
            <div class="input-box">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="input-box">
                <button type="submit" class="btn">Check Status</button>
            </div>
        </form>

        <?php if (!empty($status_message)): ?>
            <div class="message"><?php echo $status_message; ?></div>
        <?php endif; ?>

        <!-- Show PES Registration Details -->
        <?php if ($pes_data): ?>
            <h3>PES Registration</h3>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>College Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($pes_data['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($pes_data['college_name']); ?></td>
                        <td><?php echo htmlspecialchars($pes_data['status']); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Show BGMI Registration Details -->
        <?php if ($bgmi_data): ?>
            <h3>BGMI Registration</h3>
            <table>
                <thead>
                    <tr>
                        <th>Team Leader Name</th>
                        <th>Team Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($bgmi_data['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($bgmi_data['college_name']); ?></td>
                        <td><?php echo htmlspecialchars($bgmi_data['status']); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
