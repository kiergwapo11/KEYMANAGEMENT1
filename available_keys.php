<?php
session_start(); // Add this at the top to access session

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if not logged in
    header("Location: studentlogin.php");
    exit;
}

// Include the database connection file
require_once 'database.php';

// Use the existing connection for key_records
$conn = $conn_key_records;

// Fetch all keys and their borrowed status from the database
$sql = "SELECT * FROM avail_keys";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="/pics/favicon.ico.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Available Keys</title>
    <link rel="stylesheet" href="1st_flr.css">
   
  
</head>
<body>

<?php if (isset($_SESSION['user'])): ?>
  <!-- Update your form structure -->
<form id="borrowForm" method="POST" action="borrow_key.php">
    <input type="hidden" id="selectedKey" name="selectedKey" value="">
    <input type="hidden" name="idnum" value="<?php echo htmlspecialchars($_SESSION['user']); ?>">
    
    <!-- Only the borrow button -->
    <button type="submit">Borrow Key</button>
</form>
    <!-- Navigation -->
    <div class="Home Page">
        <div class="navbar">
            <ul>
                <li><a href="available_keys.php">FIRST FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="3rd_flr.html">SECOND FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="4th_flr.html">THIRD FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="homepage.php">HOME</a></li>
            </ul>
        </div>
    </div>

    <h1 class="title">Choose what key you would like to borrow.</h1>

    <section class="slider-container">
        <div class="slider-images">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $isBorrowed = $row['is_borrowed'];
                    $keyName = htmlspecialchars($row["key_name"]);
                    $floor = htmlspecialchars($row["floor"]);
                    ?>
                    <div class="key-container <?php echo $isBorrowed ? 'disabled' : ''; ?>">
                        <div class="slider-img <?php echo $isBorrowed ? 'disabled' : ''; ?>" 
                             onclick="<?php echo !$isBorrowed ? 'borrowKey(\''.$keyName.'\')' : 'showBorrowedMessage(\''.$keyName.'\')'; ?>">
                            <img src="Images/keys.png" alt="Key">
                            <div class="details">
                                <h1><?php echo $keyName; ?></h1>
                                <p>Floor: <?php echo $floor; ?></p>
                                <?php if ($isBorrowed): ?>
                                    <p class="borrowed-status">Currently Borrowed</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>

<?php else: ?>
    <!-- Show message for non-logged-in users -->
    <div class="login-message">
        Please <a href="studentlogin.php" style="color: white; text-decoration: underline;">login</a> to borrow keys.
    </div>
<?php endif; ?>

<script>

function borrowKey(keyName) {
    if (confirm('Do you want to borrow ' + keyName + '?')) {
        fetch('borrow_key.php', {
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
                alert('Successfully borrowed ' + keyName);
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to borrow key'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
}
</script>

</body>
</html>