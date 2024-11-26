<?php
// Database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname_key_borrowing = "key_borrowing";

function connectToDatabase($dbname) {
    global $servername, $username, $password;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection to database $dbname failed: " . $conn->connect_error);
    }

    return $conn;
}

$conn_to_borrow_keys = connectToDatabase($dbname_key_borrowing);

// Fetch available keys from the database
$sql = "SELECT * FROM avail_keys";
$result = $conn_to_borrow_keys->query($sql);
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
                    echo '<div class="slider-img" onclick="selectKey(this, ' . $row["is_borrowed"] . ')">';
                    echo '<img src="Images/keys.png" alt="Key">';
                    echo '<div class="details">';
                    echo '<h1>' . htmlspecialchars($row["key_name"]) . '</h1>';
                    echo '<p>Floor: ' . htmlspecialchars($row["floor"]) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No keys found.</p>';
            }
            ?>
        </div>
    </section>

    <!-- Borrow Form -->
    <form id="borrowForm" method="POST" action="borrow_key.php">
        <input type="hidden" id="selectedKey" name="selectedKey" value="">
        <button type="submit">Borrow</button>
    </form>

    <!-- JavaScript to handle key selection and form validation -->
    <script>
        // Function to handle key selection
        function selectKey(element, isBorrowed) {
            if (isBorrowed) {
                alert('This key is already borrowed.');
                return;
            }
            
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
$conn_to_borrow_keys->close();
?>

</body>
</html>