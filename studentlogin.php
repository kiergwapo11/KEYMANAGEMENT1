<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <link rel="icon" type="image/x-icon" href="Images/CTU LOGO.png">
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
        <form action="studentlogin.php" method="post" autocomplete="off">
            <h1>STUDENT LOG IN</h1>
            <div class="input-box">
                <input type="text" name="idnum" placeholder="ID Number" required autocomplete="off">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
            <div class="admin-link">
                <a href="adminlogin.php" class="btn">Login as Admin</a>
            </div>
            <div class="register-link">
                <p>Don't have an account? <a href="registration.php">Register</a></p>
            </div>
        </form>
    </div>
    </div>

    <div class="right">
        <div class="image-container"></div>
    </div>

    <script>
        // Check if there's an alert message from PHP
        <?php if (!empty($alertMessage)): ?>
            alert("<?php echo addslashes($alertMessage); ?>");
        <?php endif; ?>
    </script>

    <!-- Add modal HTML before the closing body tag -->
    <div class="modal-overlay" id="adminCodeModal">
        <div class="modal-content">
            <h2>Admin Verification</h2>
            <div class="admin-code-input">
                <input type="password" id="adminCode" placeholder="Enter Admin Code" maxlength="4">
                <p id="errorMessage" class="error-message"></p>
            </div>
            <div class="modal-buttons">
                <button class="confirm-btn" onclick="verifyAdminCode()">Verify</button>
                <button class="cancel-btn" onclick="closeAdminModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script>
    function showAdminModal(event) {
        event.preventDefault(); // Prevent immediate navigation
        document.getElementById('adminCodeModal').style.display = 'block';
        document.getElementById('adminCode').value = ''; // Clear previous input
        document.getElementById('errorMessage').textContent = ''; // Clear previous error
    }

    function closeAdminModal() {
        document.getElementById('adminCodeModal').style.display = 'none';
    }

    function verifyAdminCode() {
        const code = document.getElementById('adminCode').value;
        if (code === '0123') { // Your admin code
            window.location.href = 'adminlogin.php';
        } else {
            document.getElementById('errorMessage').textContent = 'Invalid admin code';
            document.getElementById('adminCode').value = ''; // Clear invalid input
        }
    }

    // Add event listener to the admin link
    document.querySelector('.admin-link a').addEventListener('click', showAdminModal);
    </script>
</body>
</html>