<?php
session_start();

// Check if logout button is clicked
if (isset($_POST['logout'])) {
    // Destroy all session data
    session_destroy();
    // Redirect to login page
    header("Location: adminlogin.php");
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_email'])) {
    header("Location: adminlogin.php");
    exit();
}

require_once 'database.php';

// Function to get total registered users
function getTotalUsers($conn) {
    $sql = "SELECT COUNT(*) as total FROM users";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    return $data['total'];
}

// Function to get total borrowed items
function getTotalBorrowed($conn) {
    $sql = "SELECT COUNT(*) as total FROM users WHERE return_date IS NULL";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    return $data['total'];
}

// Function to get total returned keys
function getTotalReturned($conn) {
    $sql = "SELECT COUNT(*) as total FROM users WHERE return_date IS NOT NULL";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
    return $data['total'];
}

// Get statistics
$totalUsers = getTotalUsers($conn_login_register);
$totalBorrowed = getTotalBorrowed($conn_key_records);
$totalReturned = getTotalReturned($conn_key_records);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="Images/CTU LOGO.png">
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
                    <form method="POST" action="">
                        <button type="submit" name="logout" class="logout-btn">
                            <i class="fa-solid fa-right-from-bracket"></i> Log out
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        <div class="main">
            <div id="mainContent">
                <!-- Default content (admin dashboard) -->
            </div>
        </div>
    </div>

    <script>
    // Add this at the start of your script
    const totalUsers = <?php echo $totalUsers; ?>;

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
                            <p><?php echo $totalUsers; ?></p>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-key"></i>
                            <h3>Items Borrowed</h3>
                            <p><?php echo $totalBorrowed; ?></p>
                        </div>
                        <div class="stat-item">
                            <i class="fa-solid fa-hand-holding-hand"></i>
                            <h3>Returned Key</h3>
                            <p><?php echo $totalReturned; ?></p>
                        </div>
                    </div>
                </div>
            `;
        } else if (page === 'records') {
            fetch('records.php')
                .then(response => response.text())
                .then(html => {
                    mainContent.innerHTML = `
                        <div class="registers">
                            <h1>KEY RECORDS</h1>
                            <table>
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>ID NUMBER</th>
                                        <th>SECTION</th>
                                        <th>KEY NAME</th>
                                        <th>BORROWED AT</th>
                                        <th>RETURNED AT</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${html}
                                </tbody>
                            </table>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                    mainContent.innerHTML = 'Error loading records';
                });
        }
    }

    // Load admin content by default
    loadContent('admin');
    </script>
</body>
</html>
