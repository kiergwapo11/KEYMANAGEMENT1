<?php
// Same structure as 3rd_flr.php but change:
// - title to "4th Floor Keys"
// - SQL query to "WHERE floor = '4th Floor'"
// - h1 class="title" to "Fourth Floor Keys"
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: studentlogin.php");
    exit;
}

require_once 'database.php';
$conn = $conn_key_records;

// Get all keys for 3rd floor
$sql = "SELECT * FROM avail_keys WHERE floor = 'Fourth Floor'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="Images/CTU LOGO.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Fourth Floor Keys</title>
    <link rel="stylesheet" href="1st_flr.css">
</head>
<body>
    <div class="Home Page">
        <div class="navbar">
            <ul>
                <li><a href="available_keys.php">FIRST FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="3rd_flr.php">THIRD FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="4th_flr.php">FOURTH FLOOR <i class="fa fa-key"></i></a></li>
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
                    $isBorrowed = $row["is_borrowed"] == 1;
                    $containerClass = $isBorrowed ? 'key-container borrowed' : 'key-container';
                    ?>
                    <div class="<?php echo $containerClass; ?>">
                        <div class="slider-img" <?php if (!$isBorrowed) echo 'onclick="selectKey(this)"'; ?>>
                            <img src="Images/keys.png" alt="Key">
                            <div class="details">
                                <h1><?php echo htmlspecialchars($row["key_name"]); ?></h1>
                                <p>Floor: <?php echo htmlspecialchars($row["floor"]); ?></p>
                                <div class="status-indicator <?php echo $isBorrowed ? 'status-borrowed' : 'status-available'; ?>">
                                    <?php echo $isBorrowed ? 'Currently Borrowed' : 'Available'; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No keys available for the 3rd floor.</p>";
            }
            ?>
        </div>
    </section>

    <script>
    function selectKey(element) {
        const keyName = element.querySelector('.details h1').innerText;
        
        if (confirm('Are you sure you want to borrow ' + keyName + '?')) {
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
?> 