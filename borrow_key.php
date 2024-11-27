<?php
session_start();
require_once 'database.php';

// Basic error handling
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

try {
    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);
    $selectedKey = $data['selectedKey'];
    $borrower_id = $_SESSION['user'];

    // First, get the name and section from login_register database
    $userSql = "SELECT name, section FROM users WHERE idnum = ?";
    $userStmt = $conn_login_register->prepare($userSql);
    $userStmt->bind_param("s", $borrower_id);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    
    if ($userResult->num_rows > 0) {
        $userData = $userResult->fetch_assoc();
        $name = $userData['name'];
        $section = $userData['section'];

        // Use key_records database for key operations
        $sql = "UPDATE avail_keys SET is_borrowed = 1 WHERE key_name = ?";
        $stmt = $conn_key_records->prepare($sql);
        $stmt->bind_param("s", $selectedKey);
        
        if ($stmt->execute()) {
            // Insert into records in key_records database with name and section
            $recordSql = "INSERT INTO users (username, borrower_id, key_name, borrower_section, borrow_date) 
                         VALUES (?, ?, ?, ?, NOW())";
            $recordStmt = $conn_key_records->prepare($recordSql);
            $recordStmt->bind_param("ssss", $name, $borrower_id, $selectedKey, $section);
            
            if ($recordStmt->execute()) {
                echo json_encode([
                    'success' => true,
                    'message' => "Key borrowed successfully by $name from section $section"
                ]);
            } else {
                throw new Exception('Failed to record borrowing');
            }
        } else {
            throw new Exception('Failed to update key status');
        }
    } else {
        throw new Exception('User not found');
    }

} catch (Exception $e) {
    error_log("Error in borrow_key.php: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Close all connections
if (isset($userStmt)) $userStmt->close();
if (isset($stmt)) $stmt->close();
if (isset($recordStmt)) $recordStmt->close();
$conn_key_records->close();
$conn_login_register->close();
?>
