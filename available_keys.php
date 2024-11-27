<?php
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
    <style>
        /* Add styles for disabled keys */
        .slider-img.disabled {
            opacity: 0.5; /* Make the key appear faded */
            pointer-events: none; /* Prevent clicking */
            cursor: not-allowed;
        }

        .slider-img.selected {
            border: 2px solid #4CAF50; /* Highlight selected key */
        }
    </style>
</head>
<body>

<!-- Borrow Form -->
<form id="borrowForm" method="POST" action="borrow_key.php">
    <input type="hidden" id="selectedKey" name="selectedKey" value="">
    <!-- Add hidden inputs for user details -->
    <input type="text" name="username" placeholder="Enter your username" required>
    <input type="number" name="idnum" placeholder="Enter your ID number" required>
    <select name="section" required>
        <option value="">Select Section</option>
        <!-- Populate with your section options -->
        <option value="BSCpE 1">BSCpE 1</option>
        <option value="BSCpE 2-Day">BSCpE 2-Day</option>
        <option value="BSCpE 2A-Night">BSCpE 2A-Night</option>
        <!-- More sections here -->
    </select>
    <button type="submit">Borrow</button>
</form>

    <div class="Home Page">
        <div class="navbar">
            <ul>
                <li><a href="available_keys.php">FIRST FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="3rd_flr.html">SECOND FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="4th_flr.html">THIRD FLOOR <i class="fa fa-key"></i></a></li>
            </ul>
        </div>
    </div>

    <h1 class="title">Choose what key you would like to borrow.</h1>

    <section class="slider-container">
        <div class="slider-images">
            <?php
            // Dynamically display keys from the database
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $isBorrowed = $row['is_borrowed'];
                    $keyName = htmlspecialchars($row["key_name"]);
                    $floor = htmlspecialchars($row["floor"]);

                    // Add a 'disabled' class for borrowed keys
                    $disabledClass = $isBorrowed ? 'disabled' : '';
                    $clickHandler = $isBorrowed ? '' : 'onclick="selectKey(this)"';

                    echo '<div class="slider-img ' . $disabledClass . '" ' . $clickHandler . '>';
                    echo '<img src="Images/keys.png" alt="Key">';
                    echo '<div class="details">';
                    echo '<h1>' . $keyName . '</h1>';
                    echo '<p>Floor: ' . $floor . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No available keys at the moment.</p>';
            }
            ?>
        </div>
    </section>

    


    <!-- JavaScript to handle key selection and form validation -->
    <script>

        // Function to handle key selection
function selectKey(element) {
    let keys = document.querySelectorAll('.slider-img');
    keys.forEach(function(key) {
        key.classList.remove('selected');
    });
    element.classList.add('selected');

    // Update the hidden input with the selected key name
    const selectedKeyName = element.querySelector('.details h1').innerText;
    document.getElementById('selectedKey').value = selectedKeyName;
}

        // Function to handle key selection
        function selectKey(element) {
            let keys = document.querySelectorAll('.slider-img');
            keys.forEach(function(key) {
                key.classList.remove('selected');
            });
            element.classList.add('selected');

            // Update the hidden input with the selected key name
            const selectedKeyName = element.querySelector('.details h1').innerText;
            document.getElementById('selectedKey').value = selectedKeyName;
        }

        // Form validation before submission
        document.getElementById('borrowForm').addEventListener('submit', function (e) {
            if (!document.getElementById('selectedKey').value) {
                e.preventDefault();
                alert('Please select a key before borrowing.');
            }
        });
    </script>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>