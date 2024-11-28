<?php
session_start();
require_once 'database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$keyName = $data['selectedKey'] ?? '';

if (empty($keyName)) {
    echo json_encode(['success' => false, 'message' => 'No key selected']);
    exit;
}

$conn = $conn_key_records;

try {
    // Start transaction
    $conn->begin_transaction();

    // Update return_date in users table
    $stmt = $conn->prepare("UPDATE users SET return_date = NOW() 
                           WHERE borrower_id = ? 
                           AND key_name = ? 
                           AND return_date IS NULL");
    $stmt->bind_param("ss", $_SESSION['user'], $keyName);
    $stmt->execute();

    // Update is_borrowed in avail_keys table
    $stmt = $conn->prepare("UPDATE avail_keys SET is_borrowed = 0 
                           WHERE key_name = ?");
    $stmt->bind_param("s", $keyName);
    $stmt->execute();

    // Commit the transaction
    $conn->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Rollback in case of error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 