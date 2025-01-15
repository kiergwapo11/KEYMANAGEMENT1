<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: studentlogin.php");
    exit;
}

// Include the database connection file
require_once 'database.php';
$conn = $conn_key_records;

// Modified query to match with borrower_id instead of username
$sql = "SELECT a.key_name, a.floor, u.borrower_section, u.borrow_date 
        FROM users u 
        JOIN avail_keys a ON u.key_name = a.key_name 
        WHERE u.borrower_id = ? 
        AND u.return_date IS NULL 
        AND a.is_borrowed = 1";

try {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("s", $_SESSION['user']);
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
} catch (Exception $e) {
    die("Query error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="Images/CTU LOGO.png">
    <link rel="icon" type="image/x-icon" href="/pics/favicon.ico.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Return Keys</title>
    <link rel="stylesheet" href="1st_flr.css">
</head>
<body>

<?php if (isset($_SESSION['user'])): ?>
    <!-- Navigation Bar -->
    <div class="Home Page">
        <div class="navbar">
            <ul>
                <li><a href="#">FIRST FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="#">SECOND FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="#">THIRD FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="homepage.php">HOME</a></li>
            </ul>
        </div>
    </div>

    <h1 class="title">Your Borrowed Keys</h1>

    <!-- Key Display Section -->
    <section class="slider-container">
        <div class="slider-images">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="key-container">
                        <div class="slider-img" onclick="selectKey(this)">
                            <img src="Images/keys.png" alt="Key">
                            <div class="details">
                                <h1><?php echo htmlspecialchars($row["key_name"]); ?></h1>
                                <p>Floor: <?php echo htmlspecialchars($row["floor"]); ?></p>
                                <p class="borrow-date">Borrowed on: <?php echo htmlspecialchars($row["borrow_date"]); ?></p>
                                <p class="return-prompt">Click to Return</p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='no-keys-message'>
                        <p>You haven't borrowed any keys yet</p>
                        <a href='available_keys.php'>Click here to borrow keys</a>
                      </div>";
            }
            ?>
        </div>
    </section>

<?php else: ?>
    <div class="login-message">
        Please <a href="studentlogin.php">login</a> to return keys.
    </div>
<?php endif; ?>

<!-- Add modal HTML before the script tag -->
<div class="modal-overlay" id="confirmModal">
    <div class="modal-content">
        <h2>Confirm Return</h2>
        <p id="modalMessage"></p>
        <div class="modal-buttons">
            <button class="confirm-btn" onclick="confirmReturn()">Confirm</button>
            <button class="cancel-btn" onclick="closeModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
let selectedKeyElement = null;

function selectKey(element) {
    const keyName = element.querySelector('.details h1').innerText;
    selectedKeyElement = element;
    
    // Show modal
    document.getElementById('modalMessage').textContent = 'Are you sure you want to return ' + keyName + '?';
    document.getElementById('confirmModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('confirmModal').style.display = 'none';
    selectedKeyElement = null;
}

function confirmReturn() {
    if (!selectedKeyElement) return;
    
    const keyName = selectedKeyElement.querySelector('.details h1').innerText;
    
    fetch('process_return.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            selectedKey: keyName
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to return key'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
    
    closeModal();
}
</script>

</body>
</html>
