<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: studentlogin.php");
    exit();
}

if (isset($_POST['logout'])) {
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
    <link rel="icon" type="image/x-icon" href="Images/CTU LOGO.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4804625ee9.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="wrapper">
        <header>
            <div class="logo">
                <img src="Images/CTU Logo.png" alt="CTU Logo">
                <div class="title">
                    <h1>Key Management System nothing</h1>
                    <p class="tagline">College of Engineering</p>
                </div>
                <img src="Images/COE.png" alt="COE">
            </div>
        </header>

        <main>
            <div class="welcome-banner">
                <div class="welcome-text">
                    <?php
                    require_once "database.php";
                    // Fetch the username using the session ID
                    $id_number = $_SESSION['user'];
                    $sql = "SELECT name FROM users WHERE idnum = ?";
                    $stmt = $conn_login_register->prepare($sql);
                    $stmt->bind_param("s", $id_number);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $username = $row['name'];
                        echo "<h2>Welcome, " . htmlspecialchars($username) . "!</h2>";
                    } else {
                        echo "<h2>Welcome!</h2>";
                    }

                    // Check for active borrows and due dates
                    $sql_check = "SELECT key_name, borrow_date FROM users 
                                 WHERE borrower_id = '$id_number' 
                                 AND return_date IS NULL";
                    $result_check = mysqli_query($conn_key_records, $sql_check);
                    
                    if ($result_check && mysqli_num_rows($result_check) > 0) {
                        echo "<div class='notifications'>";
                        while ($borrow = mysqli_fetch_assoc($result_check)) {
                            echo "<div class='notification-item'>";
                            echo "<i class='fas fa-exclamation-circle'></i>";
                            echo "<p>You have borrowed <strong>{$borrow['key_name']}</strong> on {$borrow['borrow_date']}</p>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    ?>
                    <p>Access and manage your key borrowing activities</p>
                </div>
              
            </div>

            <section class="navigation-buttons">
                <div class="button-container">
                    <a href="available_keys.php" class="nav-button">
                        <div class="button-content">
                            <div class="icon-wrapper">
                                <i class="fas fa-key"></i>
                            </div>
                            <h3>Borrow Key</h3>
                            <p>Request to borrow available keys</p>
                        </div>
                    </a>

                    <a href="return_shaina.php" class="nav-button">
                        <div class="button-content">
                            <div class="icon-wrapper">
                                <i class="fas fa-undo"></i>
                            </div>
                            <h3>Return Key</h3>
                            <p>Return your borrowed keys</p>
                        </div>
                    </a>

                    <a href="#" class="nav-button logout" onclick="document.getElementById('logoutForm').submit();">
                        <div class="button-content">
                            <div class="icon-wrapper">
                                <i class="fas fa-sign-out-alt"></i>
                            </div>
                            <h3>Log Out</h3>
                            <p>End your current session</p>
                        </div>
                    </a>
                </div>
            </section>
        </main>

        <footer>
            <p>© 2024 Cebu Technological University. All Rights Reserved.</p>
        </footer>

        <form id="logoutForm" method="post" style="display: none;">
            <input type="hidden" name="logout" value="1">
        </form>
    </div>

    <script>
    function updateTime() {
        const now = new Date();
        const options = { 
            hour: '2-digit', 
            minute: '2-digit', 
            hour12: true,
            timeZone: 'Asia/Manila'
        };
        document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', options);
    }

    // Update time every second
    setInterval(updateTime, 1000);
    // Initial call to display time immediately
    updateTime();
    
    



    
    </script>
</body>
</html>
