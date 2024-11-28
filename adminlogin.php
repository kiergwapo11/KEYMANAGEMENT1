<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/x-icon" href="Images/CTU LOGO.png">
    <link rel="stylesheet" href="studentlogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="left">
    <?php
session_start();
require_once "database.php"; 

if (isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $errors = array();

    // Check if both username and password are provided
    if (empty($username) || empty($password)) {
        $errors[] = "Please fill in both fields.";
    }

    if (count($errors) === 0) {
        // Query the database to find the admin user
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $conn_login_register->prepare($sql);
        $stmt->bind_param("s", $username); // Assuming email is used as the username
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables upon successful login
                $_SESSION['admin_id'] = $user['id']; // Save user info in session
                $_SESSION['admin_email'] = $user['email'];
                
                // Redirect to the admin dashboard or homepage
                header("Location: admindashboard.php"); // Redirect to admin dashboard
                exit();
            } else {
                echo "<script>alert('Incorrect password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('No user found with that email.');</script>";
        }
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

   <div class="wrapper">
       
        <form action="adminlogin.php" method="post">
            <h1>ADMIN LOG IN</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Email" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="login" class="btn"> Login </button>
            <div class="register-link">
                <p>Don't have an account? <a href="adminregistration.php">Register</a></p>
            </div>
        </form>
    </div>
    </div>

    <div class="right">
        <div class="image-container"></div>
    </div>

    <button class="bottom-right-button" onclick="location.href='studentlogin.php'">Login as Student</button>

</body>
</html>
