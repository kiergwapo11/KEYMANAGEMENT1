<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="studentlogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="left">
    <?php
session_start();
require_once "database.php";

$alertMessage = "";

if (isset($_POST['login'])) {
    $idnum = $_POST['idnum'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE idnum = ?";
    $stmt = mysqli_stmt_init($conn_login_register);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $idnum);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            
            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['idnum'];
                header("Location: homepage.php");
                exit;
            } else {
                $alertMessage = "Incorrect password.";
            }
        } else {
            $alertMessage = "No user found with that ID number.";
        }
    } else {
        $alertMessage = "Something went wrong: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn_login_register);
}

?>
   <div class="wrapper">
        <!-- The alert will be handled by JavaScript -->
        <form action="studentlogin.php" method="post">
            <h1>STUDENT LOG IN</h1>
            <div class="input-box">
                <input type="text" name="idnum" placeholder="ID Number" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="registration.php">Register</a></p>
            </div>
        </form>
    </div>
    </div>

    <div class="right">
        <div class="image-container"></div>
    </div>

    <button class="bottom-right-button" onclick="location.href='adminlogin.php'">Login as Admin</button>

    <script>
        // Check if there's an alert message from PHP
        <?php if (!empty($alertMessage)): ?>
            alert("<?php echo addslashes($alertMessage); ?>");
        <?php endif; ?>
    </script>
</body>
</html>