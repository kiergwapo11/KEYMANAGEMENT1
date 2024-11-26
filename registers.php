<?php
// Remove the DOCTYPE and HTML structure since we're loading this content dynamically
$conn = mysqli_connect("localhost", "root", "", "login_register");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<div class="registers">
    <h1>REGISTERED USERS</h1>
    <table>
        <thead>
            <tr>
                <th>NAME</th>
                <th>ID NUMBER</th>
                <th>SECTION</th>
                <th>EMAIL</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT name, idnum, section, email FROM users";
            $result = $conn->query($sql);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['name']}</td>
                            <td>{$row['idnum']}</td>
                            <td>{$row['section']}</td>
                            <td>{$row['email']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No records found.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>