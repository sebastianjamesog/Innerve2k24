<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminlogin.php");
    exit();
}

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

// Handle approval and rejection of users
if (isset($_POST['approve'])) {
    $user_id = $_POST['user_id'];
    $event_type = $_POST['event_type'];

    if ($event_type == 'PES') {
        $stmt = $conn->prepare("UPDATE users SET status = 'Approved' WHERE id = ?");
    } else {
        $stmt = $conn->prepare("UPDATE team_registration SET status = 'Approved' WHERE id = ?");
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
} elseif (isset($_POST['reject'])) {
    $user_id = $_POST['user_id'];
    $event_type = $_POST['event_type'];

    if ($event_type == 'PES') {
        $stmt = $conn->prepare("UPDATE users SET status = 'Rejected' WHERE id = ?");
    } else {
        $stmt = $conn->prepare("UPDATE team_registration SET status = 'Rejected' WHERE id = ?");
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();
}

// Filtering logic by event
$event_filter = isset($_GET['event']) ? $_GET['event'] : 'PES';

// Fetch the appropriate data based on event type
if ($event_filter == 'PES') {
    $sql = "SELECT id, email, transaction_id, student_name, college_name, phone FROM users"; // Fetching mobile number for PES
} else {
    // Fetch the required fields for BGMI including transaction_id
    $sql = "SELECT id, team_name, leader_name, leader_phone, leader_email, player2_name, player3_name, player4_name, transaction_id FROM team_registration";
}

$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    echo "Error: " . $conn->error; // Output the error message from MySQL
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 50px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
        }
        .approve-btn {
            background-color: #2ecc71;
            color: white;
        }
        .reject-btn {
            background-color: #e74c3c;
            color: white;
        }
        .approve-btn:hover {
            background-color: #27ae60;
        }
        .reject-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <form method="GET" action="">
        <label for="event">Filter by Event:</label>
        <select name="event" id="event">
            <option value="PES" <?php if ($event_filter == 'PES') echo 'selected'; ?>>PES</option>
            <option value="BGMI" <?php if ($event_filter == 'BGMI') echo 'selected'; ?>>BGMI</option>
        </select>
        <button type="submit" class="btn">Filter</button>
    </form>

    <table>
        <thead>
            <tr>
                <?php if ($event_filter == 'PES'): ?>
                    <th>Email ID</th>
                    <th>Transaction ID</th>
                    <th>Student Name</th>
                    <th>College Name</th>
                    <th>Mobile Number</th> <!-- Added Mobile Number column -->
                <?php else: ?>
                    <th>Team Name</th>
                    <th>Leader Name</th>
                    <th>Leader Phone</th>
                    <th>Leader Email</th>
                    <th>Player 2</th>
                    <th>Player 3</th>
                    <th>Player 4</th>
                    <th>Transaction ID</th>
                <?php endif; ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <?php if ($event_filter == 'PES'): ?>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['transaction_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['college_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td> <!-- Displaying Mobile Number -->
                        <?php else: ?>
                            <td><?php echo htmlspecialchars($row['team_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['leader_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['leader_phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['leader_email']); ?></td>
                            <td><?php echo htmlspecialchars($row['player2_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['player3_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['player4_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['transaction_id']); ?></td>
                        <?php endif; ?>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="event_type" value="<?php echo $event_filter; ?>">
                                <button type="submit" name="approve" class="btn approve-btn">Approve</button>
                            </form>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="event_type" value="<?php echo $event_filter; ?>">
                                <button type="submit" name="reject" class="btn reject-btn">Reject</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="<?php echo ($event_filter == 'PES') ? '6' : '9'; ?>">No records found.</td> <!-- Adjusted colspan for new column -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <form action="adminlogout.php" method="POST">
        <button type="submit" class="btn">Logout</button>
    </form>

</body>
</html>

<?php
}

$conn->close();
?>
