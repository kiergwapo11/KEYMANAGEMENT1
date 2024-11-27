<?php
// Include the database connection file
require_once 'database.php';

// Use the existing connection for key_records
$conn = $conn_key_records;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $idnum = $_POST['idnum'];

    // Validate user input
    if (empty($username) || empty($idnum)) {
        die("Username and ID number are required.");
    }

    // Fetch all borrowed keys
    $sql = "SELECT * FROM avail_keys WHERE is_borrowed = 1";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Fetch keys borrowed by the logged-in user
    $stmt = $conn->prepare("SELECT * FROM avail_keys WHERE username = ? AND borrower_id = ?");
    $stmt->bind_param("si", $username, $idnum);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $userBorrowedKeys = [];

    // Collect keys borrowed by this user
    if ($userResult->num_rows > 0) {
        while ($row = $userResult->fetch_assoc()) {
            $userBorrowedKeys[] = $row['key_name'];
        }
    }
} else {
    $result = null;
    $userBorrowedKeys = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="/pics/favicon.ico.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Return Keys</title>
    <link rel="stylesheet" href="1st_flr.css">
    <style>
        .slider-img.disabled {
            opacity: 0.5; /* Make disabled keys appear faded */
            pointer-events: none; /* Prevent clicking */
            cursor: not-allowed;
        }
        .slider-img.selected {
            border: 2px solid #FF5733; /* Highlight for selected key */
        }
    </style>
</head>
<body>

<!-- Return Form -->
<form id="returnForm" method="POST">
    <input type="text" name="username" placeholder="Enter your username" required>
    <input type="number" name="idnum" placeholder="Enter your ID number" required>
    <button type="submit">View Borrowed Keys</button>
</form>

<?php if ($result && $result->num_rows > 0): ?>
    <h1 class="title">Borrowed Keys</h1>
    <form id="returnKeyForm" method="POST" action="process_return.php">
        <input type="hidden" id="selectedKey" name="selectedKey" value="">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>">
        <input type="hidden" name="idnum" value="<?php echo htmlspecialchars($idnum ?? ''); ?>">
        <section class="slider-container">
            <div class="slider-images">
                <?php
                while ($row = $result->fetch_assoc()) {
                    $keyName = htmlspecialchars($row["key_name"]);
                    $floor = htmlspecialchars($row["floor"]);

                    // Check if this key is borrowed by the current user
                    $isUserKey = in_array($keyName, $userBorrowedKeys);
                    $disabledClass = $isUserKey ? '' : 'disabled';
                    $clickHandler = $isUserKey ? 'onclick="selectKey(this)"' : '';

                    echo '<div class="slider-img ' . $disabledClass . '" ' . $clickHandler . '>';
                    echo '<img src="Images/keys.png" alt="Key">';
                    echo '<div class="details">';
                    echo '<h1>' . $keyName . '</h1>';
                    echo '<p>Floor: ' . $floor . '</p>';
                    echo $isUserKey ? '<p><strong>You Borrowed This</strong></p>' : '<p>Borrowed by another user</p>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>
        <button type="submit">Return Selected Key</button>
    </form>
<?php elseif ($result): ?>
    <p>No keys are currently borrowed.</p>
<?php endif; ?>

<script>
    // Function to handle key selection
    function selectKey(element) {
        let keys = document.querySelectorAll('.slider-img');
        keys.forEach(function (key) {
            key.classList.remove('selected');
        });
        element.classList.add('selected');

        // Update the hidden input with the selected key name
        const selectedKeyName = element.querySelector('.details h1').innerText;
        document.getElementById('selectedKey').value = selectedKeyName;
    }

    // Form validation before submission
    document.getElementById('returnKeyForm').addEventListener('submit', function (e) {
        if (!document.getElementById('selectedKey').value) {
            e.preventDefault();
            alert('Please select a key to return.');
        }
    });
</script>

<?php
// Close the database connection
$conn->close();
?>

</body>
</html>
