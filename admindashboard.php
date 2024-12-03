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

// Add this function to get admin name
function getAdminName($conn, $admin_id) {
    $stmt = $conn->prepare("SELECT fullname FROM admin WHERE id = ?");
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data['fullname'] ?? 'Admin'; // Returns 'Admin' if no name found
}

// Get admin name
$adminName = getAdminName($conn_login_register, $_SESSION['admin_id']);

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
    
    <!-- Add these script tags -->
    <script>
        // Make PHP variables available to JavaScript
        window.adminName = '<?php echo htmlspecialchars($adminName, ENT_QUOTES); ?>';
        window.totalUsers = <?php echo $totalUsers; ?>;
        window.totalBorrowed = <?php echo $totalBorrowed; ?>;
        window.totalReturned = <?php echo $totalReturned; ?>;
    </script>
    <script src="admindashboard.js"></script>
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
</body>
</html>
