<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_email'])) {
    header("Location: adminlogin.php");
    exit();
}

// Check if the logout button was clicked
if (isset($_POST['logout'])) {
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
                <li><a href="#" onclick="loadContent('admin')"><i class="fa-solid fa-house"></i> ADMIN</a></li>
                <li><a href="#" onclick="loadContent('registers')"><i class="fa-solid fa-pen-to-square"></i> REGISTERED</a></li>
                <li><a href="#" onclick="loadContent('records')"><i class="fa-solid fa-key"></i> RECORDS</a></li>
                <li class="logout">
                    <a href="#" onclick="document.getElementById('logoutForm').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i> Log out
                    </a>
                    <form id="logoutForm" method="post" style="display: none;">
                        <input type="hidden" name="logout" value="1">
                    </form>
                </li>
            </ul>
        </div>

        <div class="main">
            <div id="mainContent">
                <div class="greetings">
                    <h2>Welcome back, Admin!</h2><br>
                    <p>Here is an overview of your key management</p><br>
                    <p>tasks for today. You can manage users, track</p><br>
                    <p>borrowed items, and check recent activities</p><br>
                    <p>from this dashboard.</p>
                    <img src="Images/work.png" class="image">

                    <div class="statistics">
                        <h2>STATISTICS</h2>
                        <div class="stat-item">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <h3>Registered Users</h3>
                            <p>
                                <?php
                                // Database connection
                                $conn = mysqli_connect("localhost", "root", "", "login_register");
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Count registered users
                                $sql = "SELECT COUNT(*) as total FROM users";
                                $result = $conn->query($sql);
                                $data = $result->fetch_assoc();
                                echo $data['total'];

                                $conn->close();
                                ?>
                            </p>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-key"></i>
                            <h3>Items Borrowed</h3>
                            <p>45</p>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-hand-holding-hand"></i>
                            <h3>Returned Key</h3>
                            <p>3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function loadContent(page) {
        const mainContent = document.getElementById('mainContent');
        
        if (page === 'registers') {
            fetch('registers.php')
                .then(response => response.text())
                .then(html => {
                    mainContent.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    mainContent.innerHTML = 'Error loading content: ' + error;
                });
        } else if (page === 'admin') {
            mainContent.innerHTML = `
                <div class="greetings">
                    <h2>Welcome back, Admin!</h2><br>
                    <p>Here is an overview of your key management</p><br>
                    <p>tasks for today. You can manage users, track</p><br>
                    <p>borrowed items, and check recent activities</p><br>
                    <p>from this dashboard.</p>
                    <img src="Images/work.png" class="image">

                    <div class="statistics">
                        <h2>STATISTICS</h2>
                        <div class="stat-item">
                            <i class="fa-solid fa-pen-to-square"></i>
                            <h3>Registered Users</h3>
                            <p>
                                <?php
                                // Database connection
                                $conn = mysqli_connect("localhost", "root", "", "login_register");
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Count registered users
                                $sql = "SELECT COUNT(*) as total FROM users";
                                $result = $conn->query($sql);
                                $data = $result->fetch_assoc();
                                echo $data['total'];

                                $conn->close();
                                ?>
                            </p>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-key"></i>
                            <h3>Items Borrowed</h3>
                            <p>45</p>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-hand-holding-hand"></i>
                            <h3>Returned Key</h3>
                            <p>3</p>
                        </div>
                    </div>
                </div>
            `;
        } else if (page === 'records') {
            // Handle records content
            mainContent.innerHTML = '<h2>Records Content</h2>';
        }
    }
    </script>
</body>
</html>
