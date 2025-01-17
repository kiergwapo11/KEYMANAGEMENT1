<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Registration Form</title>
  <link rel="stylesheet" href="adminregistration.css">
  <link rel="icon" type="image/x-icon" href="Images/CTU LOGO.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <div class="whole">
    <?php
    session_start();
    require_once "database.php"; // Ensure this file has the $conn_login_register connection

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve and sanitize input
        $fullname = trim($_POST["fullname"]);
        $email = trim($_POST["email"]);
        $password = $_POST["new_password"];
        $errors = array();

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        // Validate password length
        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }

        // Check if email already exists
        $check_email = "SELECT * FROM admin WHERE email = ?";
        $stmt_check = $conn_login_register->prepare($check_email);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $errors[] = "Email already registered. Please use a different email.";
        }

        if (empty($errors)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new admin
            $sql = "INSERT INTO admin (fullname, email, password) VALUES (?, ?, ?)";
            $stmt = $conn_login_register->prepare($sql);
            
            if ($stmt) {
                $stmt->bind_param("sss", $fullname, $email, $hashed_password);
                
                if ($stmt->execute()) {
                    // Set success message
                    $_SESSION['success_message'] = "Registration successful! You can now login.";
                    echo "<script>
                        alert('Registration successful! You can now login.');
                        window.location.href = 'adminlogin.php';
                    </script>";
                    exit;
                } else {
                    $errors[] = "Registration failed: " . $stmt->error;
                }
            }
        }

        if (!empty($errors)) {
            $errorMessages = "<div class='error-messages'>";
            foreach ($errors as $error) {
                $errorMessages .= "<div class='alert alert-danger'>$error</div>";
            }
            $errorMessages .= "</div>";
        }
    }
    ?>
    
    <div class="wrapper">
      <form action="adminregistration.php" method="post" autocomplete="off">
        <h1>Register As Admin</h1>

        <!-- Display error messages inside the form -->
        <?php if (isset($errorMessages)) echo $errorMessages; ?>

        <!-- Add 'name' attributes to capture input values in PHP -->
        <div class="input-box">
          <input type="text" name="fullname" placeholder="Full Name" required autocomplete="off">
          <i class="fas fa-user"></i>
        </div>
        <div class="input-box">
          <input type="email" name="email" placeholder="Email Address" required autocomplete="off">
          <i class="fas fa-envelope"></i>
        </div>
        <div class="input-box">
          <input type="password" name="new_password" placeholder="Password" required autocomplete="off">
          <i class="fas fa-lock"></i>
        </div>

        <button type="submit" class="btn">Register</button>

        <div class="register-link">
          <p>Already have an account? <a href="adminlogin.php">Log in</a></p>
        </div>
      </form>
    </div>
  </div>
  <script src="adminregistration.js"></script>
</body>
</html>
