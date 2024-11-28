<?php
require_once "database.php";

// Fetch records
$sql = "SELECT username, borrower_id, borrower_section, key_name, borrow_date, return_date 
        FROM users 
        ORDER BY borrow_date DESC";

$result = mysqli_query($conn_key_records, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Determine status and row background
        $status = is_null($row['return_date']) ? 'Borrowed' : 'Returned';
        $rowClass = is_null($row['return_date']) ? 'borrowed-row' : 'returned-row';
        
        // Format dates with full month name and detailed time
        $borrow_date = date('F j, Y \a\t g:i A', strtotime($row['borrow_date']));
        $return_date = is_null($row['return_date']) ? '' : date('F j, Y \a\t g:i A', strtotime($row['return_date']));
        
        echo "<tr class='{$rowClass}'>";
        echo "<td>{$row['username']}</td>";
        echo "<td>{$row['borrower_id']}</td>";
        echo "<td>{$row['borrower_section']}</td>";
        echo "<td>{$row['key_name']}</td>";
        echo "<td>{$borrow_date}</td>";
        echo "<td>{$return_date}</td>";
        echo "<td>{$status}</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No records found.</td></tr>";
}

mysqli_close($conn_key_records);
?>