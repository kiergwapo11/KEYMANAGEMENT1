<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user'])) {
    header("Location: studentlogin.php");
    exit();
}

// Check if the logout button was clicked
if (isset($_POST['logout'])) {
    // Destroy the session to log out the user
    session_unset();
    session_destroy();
    header("Location: studentlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="Images/CTU Logo.png" alt="CTU Logo">
            <div class="title">
                <h1>Key Management System</h1>
                <p class="tagline">(College of Engineering)</p>
            </div>
            <img src="Images/COE.png" alt="COE">
        </div>
    </header>

    <main>
        <section class="navigation-buttons">
            <ul>
                <li><a href="available_keys.php">Borrow Key</a></li>
                <li><a href="return.php">Return Key</a></li>
                <!-- Log Out button triggers the logout form -->
                <li class="logout">
                    <a href="#" onclick="document.getElementById('logoutForm').submit();">
                        Log Out
                    </a>
                    <!-- Hidden form to handle logout on link click -->
                    <form id="logoutForm" method="post" style="display: none;">
                        <input type="hidden" name="logout" value="1">
                    </form>
                </li>
            </ul>
        </section>
    </main>

    <footer>
        <p>© 2024 Cebu Technological University. All Rights Reserved.</p>
    </footer>
</body>
</html>
