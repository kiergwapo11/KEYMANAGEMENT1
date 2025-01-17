<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="/pics/favicon.ico.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Borrowed Keys</title>
    <link rel="stylesheet" href="1st_flr.css">
</head> 
<body>

    <div class="Home Page">
        <div class="navbar">
            <ul>
                <li><a href="1st_flr.html">FIRST FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="3rd_flr.html">SECOND FLOOR <i class="fa fa-key"></i></a></li>
                <li><a href="4th_flr.html">THIRD FLOOR <i class="fa fa-key"></i></a></li>
            </ul>
        </div>
    </div>

    <h1 class="title">Choose what key you would like to return.</h1>

    <section class="slider-container">
        <div class="slider-images">
            <?php
            // Include the database connection file
            include 'db_connection.php'; // Adjust the path if necessary

            // Fetch only borrowed keys from the `to_borrow_keys` database
            $sql = "SELECT * FROM keys WHERE status = 'borrowed'";
            $result = $conn_to_borrow_keys->query($sql);

            if ($result->num_rows > 0) {
                // Output each borrowed key
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="slider-img" onclick="returnKey(' . $row['id'] . ')">';
                    echo '<img src="Images/keys.jpg" alt="' . htmlspecialchars($row['key_name']) . '">';
                    echo '<div class="details">';
                    echo '<h1>' . htmlspecialchars($row['key_name']) . '</h1>';
                    echo '</div></div>';
                }
            } else {
                echo "<p>No borrowed keys at the moment.</p>";
            }

            $conn_to_borrow_keys->close();
            ?>
        </div>
    </section>

    <button id="return-btn" onclick="resetSelection()">Return</button>

    <script>
        // Function to handle key selection for return
        function returnKey(keyId) {
            if (confirm("Are you sure you want to return this key?")) {
                window.location.href = "return_key.php?id=" + keyId;
            }
        }

        // Function to reset selected key visually
        function resetSelection() {
            let keys = document.querySelectorAll('.slider-img');
            keys.forEach(function(key) {
                key.classList.remove('selected');
            });
        }
    </script>

</body>
</html>
