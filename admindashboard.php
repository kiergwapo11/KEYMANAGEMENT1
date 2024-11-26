<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_email'])) {
    header("Location: adminlogin.php");
    exit();
}

// Check if the logout button was clicked
if (isset($_POST['logout'])) {
    // Destroy the session to log out the admin
    session_unset();
    session_destroy();
    header("Location: adminlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="/pics/CTU LOGO.png">
    <script src="https://kit.fontawesome.com/4804625ee9.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="admindashboard.css">
    <title>ADMIN - CTU KEY MANAGEMENT SYSTEM</title>
</head> 
<body>

    <div class="homepage">
        <div class="navigator">
            <h2>DASHBOARD</h2>
            <ul>
                <li> <a href="" onclick="showSection('admin')"> <i class="fa-solid fa-house"></i> ADMIN </a></li>
                <li> <a href="registers.php" onclick="showSection('registers')"> <i class="fa-solid fa-pen-to-square"></i> REGISTERED </a></li>
                <li> <a href="records.php" onclick="showSection('records')"> <i class="fa-solid fa-key"></i> RECORDS </a></li>
                
                <!-- Update the logout button with a form to trigger logout -->
                <li class="logout">
                    <a href="#" onclick="document.getElementById('logoutForm').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i> Log out
                    </a>
                    <!-- Hidden form to handle logout on link click -->
                    <form id="logoutForm" method="post" style="display: none;">
                        <input type="hidden" name="logout" value="1">
                    </form>
                </li>
            </ul>
        </div>

        <div class="searchbar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search...">
        </div>

        <div class="greetings">
            <h2> Welcome back, Admin!</h2>
            <p>Welcome to the admin dashboard!</p>
            <img src="Images/work.png" class="image"> 
        </div>
        
    </div>
</body>
</html>
