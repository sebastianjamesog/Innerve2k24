<?php
// Database connection settings
$servername = "35.247.155.27"; // Your database server
$username = "Invoiz"; // Your database username
$password = "sebastian@james9061"; // Your database password
$dbname = "invoiz"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to hold the values
$college_name = $student_name = $email = $phone = $transaction_id = "";
$success_message = "";
$error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $college_name = trim($_POST['college']);
    $student_name = trim($_POST['student']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $transaction_id = trim($_POST['transaction']);

    // Basic validation
    if (empty($college_name) || empty($student_name) || empty($email) || empty($phone) || empty($transaction_id)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (college_name, student_name, email, phone, transaction_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $college_name, $student_name, $email, $phone, $transaction_id);

        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "Registration successful.";
            // Redirect or clear form if needed
        } else {
            // Check for duplicate entry error (1062 is the error code for duplicate entry in MySQL)
            if ($conn->errno === 1062) {
                $error_message = "Email or Transaction ID is already registered.";
            } else {
                $error_message = "An error occurred: " . $stmt->error; // General error message
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
    <title>Registration</title>
    <link rel="stylesheet" href="style1.css">
    <style>
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
        <div class="title">Registration</div>

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
                <label for="college">College Name</label>
                <input type="text" id="college" name="college" class="input" required>
            </div>  
            <div class="inputfield">
                <label for="student">Student Name</label>
                <input type="text" id="student" name="student" class="input" required>
            </div>  
            <div class="inputfield">
                <label for="email">Email Id</label>
                <input type="email" id="email" name="email" class="input" required>
            </div>  
            <div class="inputfield">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="input" required>
            </div> 
            <div class="inputfield">
                <label>QR Code</label>
                <img src="pessqr.jpeg" alt="QR Code" class="qr-code">
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
        window.open('upi://pay?pa=shineshibu75@oksbi&pn=Shine%20Shibu&am=50.00&cu=INR&aid=uGICAgMCax_qhZw', '_blank'); // Replace with your desired link
         }
        // Optional: Add event listeners for close buttons
        document.querySelectorAll('.close').forEach(closeButton => {
            closeButton.addEventListener('click', function() {
                const alert = this.parentElement;
                alert.classList.add('hidden'); // Add hidden class to alert

                // Remove the alert after the animation duration
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 300); // Match the duration of the slideOut animation
            });
        });
    </script>
</body>
</html>
