<?php
// Include the database connection file
require_once 'database.php';

// Use the existing connection for key_records
$conn = $conn_key_records;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected key name and other form data
    $selectedKey = $_POST["selectedKey"] ?? null;
    $username = $_POST["username"] ?? null;
    $borrower_id = $_POST["idnum"] ?? null;
    $section = $_POST["section"] ?? null;
    $borrow_date = date('Y-m-d H:i:s'); // Set the borrow date to current time

    if ($selectedKey && $username && $borrower_id && $section) {
        // Start by marking the key as borrowed in the avail_keys table
        $sql_update_key = "UPDATE avail_keys SET is_borrowed = 1 WHERE key_name = ?";

        // Use a prepared statement to prevent SQL injection
        $stmt_update_key = $conn->prepare($sql_update_key);
        $stmt_update_key->bind_param("s", $selectedKey);

        if ($stmt_update_key->execute()) {
            // Insert the borrowing record into the 'users' table
            $sql_insert_user = "INSERT INTO users (username, borrower_id, borrower_section, borrow_date) VALUES (?, ?, ?, ?)";

            // Prepare and bind the insert query
            $stmt_insert_user = $conn->prepare($sql_insert_user);
            $stmt_insert_user->bind_param("ssss", $username, $borrower_id, $section, $borrow_date);

            if ($stmt_insert_user->execute()) {
                // Success message
                echo "The key '$selectedKey' has been successfully borrowed by $username.";
            } else {
                // Handle insert error
                echo "Error inserting the borrowing record: " . $stmt_insert_user->error;
            }

            // Close the insert statement
            $stmt_insert_user->close();
        } else {
            // Handle error when updating the key status
            echo "Error updating key status: " . $stmt_update_key->error;
        }

        // Close the update statement
        $stmt_update_key->close();
    } else {
        echo "Please fill in all required fields and select a key.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>

<button class="back-button" onclick="window.location.href='homepage.php'">Back to Homepage</button>