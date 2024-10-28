<?php
// Database connection and form submission in one PHP file

// Database connection settings
$servername = "35.247.155.27"; // Replace with your database server
$username = "Invoiz"; // Replace with your database username
$password = "sebastian@james9061"; // Replace with your database password
$dbname = "invoiz"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to hold the values
$team_name = $leader_name = $leader_phone = $leader_email = $player2_name = $player2_phone = $player3_name = $player4_name = $transaction_id = "";
$success_message = "";
$error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $team_name = trim($_POST['team_name']);
    $leader_name = trim($_POST['leader_name']);
    $leader_phone = trim($_POST['leader_phone']);
    $leader_email = trim($_POST['leader_email']);
    $player2_name = trim($_POST['player2_name']);
    $player2_phone = trim($_POST['player2_phone']);
    $player3_name = trim($_POST['player3_name']);
    $player4_name = trim($_POST['player4_name']);
    $transaction_id = trim($_POST['transaction']);

    // Basic validation
    if (empty($team_name) || empty($leader_name) || empty($leader_phone) || empty($leader_email) || empty($transaction_id)) {
        $error_message = "Team name, leader info, and transaction ID are required.";
    } elseif (!filter_var($leader_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO team_registration (team_name, leader_name, leader_phone, leader_email, player2_name, player2_phone, player3_name, player4_name, transaction_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $team_name, $leader_name, $leader_phone, $leader_email, $player2_name, $player2_phone, $player3_name, $player4_name, $transaction_id);

        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "Team registration successful.";
        } else {
            // Check for duplicate entry error (1062 is the error code for duplicate entry in MySQL)
            if ($conn->errno === 1062) {
                $error_message = "Team Leader's email or Transaction ID is already registered.";
            } else {
                $error_message = "An error occurred: " . $stmt->error;
            }
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Registration</title>
    <link rel="stylesheet" href="style2.css">
    <style>
         .body {
            background-image: url('webbgmi.png');
         }
        /* Base styles for alerts */
        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            font-family: 'Arial', sans-serif;
            position: relative;
            animation: slideIn 0.3s forwards; /* Slide in animation */
        }

        .success {
            background-color: #d4edda; /* Light green background */
            color: #155724; /* Dark green text */
            border: 1px solid #c3e6cb; /* Darker green border */
        }

        .error {
            background-color: #f8d7da; /* Light red background */
            color: #721c24; /* Dark red text */
            border: 1px solid #f5c6cb; /* Darker red border */
        }

        /* Close button */
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 16px;
            color: inherit;
        }

        /* Animations */
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-20px);
                opacity: 0;
            }
        }
        .important-red {
        color: red;
        }
        .hidden {
            animation: slideOut 0.3s forwards; /* Slide out animation */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="title">Team Registration</div>

        <!-- Success Alert -->
        <?php if (!empty($success_message)): ?>
            <div class="alert success">
                <span class="close" onclick="this.parentElement.classList.add('hidden'); setTimeout(() => { this.parentElement.style.display='none'; }, 300);">&times;</span>
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <!-- Error Alert -->
        <?php if (!empty($error_message)): ?>
            <div class="alert error">
                <span class="close" onclick="this.parentElement.classList.add('hidden'); setTimeout(() => { this.parentElement.style.display='none'; }, 300);">&times;</span>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form">
            <div class="inputfield">
                <label for="team_name">Team Name</label>
                <input type="text" id="team_name" name="team_name" class="input" required>
            </div>  
            <div class="inputfield">
                <label for="leader_name">Team Leader Name (Player 1)</label>
                <input type="text" id="leader_name" name="leader_name" class="input" required>
            </div>  
            <div class="inputfield">
                <label for="leader_phone">Team Leader Phone</label>
                <input type="tel" id="leader_phone" name="leader_phone" class="input" required>
            </div>
            <div class="inputfield">
                <label for="leader_email">Team Leader Email</label>
                <input type="email" id="leader_email" name="leader_email" class="input" required>
            </div>  
            <div class="inputfield">
                <label for="player2_name">Player 2 ID</label>
                <input type="text" id="player2_name" name="player2_name" class="input">
            </div>
            <div class="inputfield">
                <label for="player2_phone">Player 2 Phone</label>
                <input type="tel" id="player2_phone" name="player2_phone" class="input">
            </div>  
            <div class="inputfield">
                <label for="player3_name">Player 3 ID</label>
                <input type="text" id="player3_name" name="player3_name" class="input">
            </div>
            <div class="inputfield">
                <label for="player4_name">Player 4 ID</label>
                <input type="text" id="player4_name" name="player4_name" class="input">
            </div> 
            <div class="inputfield">
                <label>QR Code</label>
                <img src="gayoz.jpg" alt="QR Code" class="qr-code">
            </div> 
            <div class="inputfield" style="text-align: center;">
                <button onclick="openLink()" class="btn">Pay Now</button>
            </div>
            <p style="color: red;">If GPay doesn't work, please try using another UPI app.</p>
            <div class="inputfield">
                <label for="transaction">Transaction ID</label>
                <input type="text" id="transaction" name="transaction" class="input" required>
            </div>
            <div class="inputfield terms">
                <label class="check">
                    <input type="checkbox" required>
                    <span class="checkmark"></span>
                </label>
                <p>Agreed to terms and conditions</p>
            </div> 
            <div class="inputfield">
                <input type="submit" value="Register" class="btn">
            </div>
        </form>
    </div>

    <script>
        function openLink() {
            window.open('upi://pay?pa=gayosmaji8590@okhdfcbank&pn=Gayos%20M%20aji&am=200.00&cu=INR&aid=uGICAgMDej_biKA', '_blank'); // Replace with your desired link
        }

        // Optional: Add event listeners for close buttons
        document.querySelectorAll('.close').forEach(closeButton => {
            closeButton.addEventListener('click', function() {
                const alert = this
            // Remove the alert after the animation duration
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300); // Match the duration of the slideOut animation
        });
    });
</script>
