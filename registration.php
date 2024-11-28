<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="icon" type="image/x-icon" href="Images/CTU Logo.png">
    <link rel="stylesheet" href="registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="header-container">
    <img src="Images/CTU Logo.png" alt="CTU Logo" class="logo"> <!-- Logo -->
    <img src="Images/COE.png" alt="COE" class="logo">
    </div>
</header>

<div class="register-container">
    <?php
    session_start();
    require_once "database.php";

    if (isset($_POST["submit"])) {
        $fullname = $_POST["username"];
        $idnum = $_POST["idnum"];
        $section = $_POST["section"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $errors = array();

        if (strlen($idnum) < 7) {
            array_push($errors, "ID number must be 7 digits long");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Email is not valid");
        }

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, idnum, section, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn_login_register);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssss", $fullname, $idnum, $section, $email, $hashed_password);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['user'] = $email; // Set session for the logged-in user
                    echo "<script>
                        alert('You are registered successfully.');
                        window.location.href='studentlogin.php';
                    </script>";
                } else {
                    echo "Something went wrong: " . mysqli_stmt_error($stmt);
                }
            } else {
                echo "Something went wrong: " . mysqli_error($conn_login_register);
            }
        }
    }
    ?>
    <div class="register">
        <h1>Registration Form</h1>
        <form action="registration.php" method="post">
            <input type="text" placeholder="Name" name="username" required>
            <input type="text" placeholder="ID No." name="idnum" required>
            <select id="section" name="section" required>
                <option value="section">Select Section</option>
                <option value="BSCpE 1">BSCpE 1</option>
                <option value="BSCpE 2-Day">BSCpE 2-Day</option>
                <option value="BSCpE 2A-Night">BSCpE 2A-Night</option>
                <option value="BSCpE 2B-Night">BSCpE 2B-Night</option>
                <option value="BSCpE 3-Day">BSCpE 3-Day</option>
                <option value="BSCpE 3-Night">BSCpE 3-Night</option>
                <option value="BSCpE 4-Day">BSCpE 4-Day</option>
                <option value="BSCpE 4-Night">BSCpE 4-Night</option>
                <option value="BSME 1">BSME 1</option>
                <option value="BSME 2-Day">BSME 2-Day</option>
                <option value="BSME 2-Night">BSME 2-Night</option>
                <option value="BSME 3">BSME 3</option>
                <option value="BSME 4">BSME 4</option>
                <option value="BSIE 1">BSIE 1</option>
                <option value="BSIE 2A-Day">BSIE 2A-Day</option>
                <option value="BSIE 2B-Day">BSIE 2B-Day</option>
                <option value="BSIE 2A-Night">BSIE 2A-Night</option>
                <option value="BSIE 2B-Nght">BSIE 2B-Nght</option>
                <option value="BSIE 3A-Day">BSIE 3A-Day</option>
                <option value="BSIE 3B-Day">BSIE 3B-Day</option>
                <option value="BSIE 3A-Night">BSIE 3A-Night</option>
                <option value="BSIE 3B-Night">BSIE 3B-Night</option>
                <option value="BSIE 4-Day">BSIE 4-Day</option>
                <option value="BSIE 4-Night">BSIE 4-Night</option>
                <option value="BSCE 1">BSCE 1</option>
                <option value="BSCE 2-Day">BSCE 2-Day</option>
                <option value="BSCE 2A-Night">BSCE 2A-Night</option>
                <option value="BSCE 2B-Night">BSCE 2B-Night</option>
                <option value="BSCE 3-Day">BSCE 3-Day</option>
                <option value="BSCE 3A-Night">BSCE 3A-Night</option>
                <option value="BSCE 3B-Night">BSCE 3B-Night</option>
                <option value="BSCE 4">BSCE 4</option>
                <option value="BSEE 1">BSEE 1</option>
                <option value="BSEE 2-Day">BSEE 2-Day</option>
                <option value="BSEE 2-Night">BSEE 2-Night</option>
                <option value="BSEE 3-Day">BSEE 3-Day</option>
                <option value="BSEE 3-Night">BSEE 3-Night</option>
                <option value="BSEE 4">BSEE 4</option>
            </select>
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Password" name="password" required>
            <button type="submit" name="submit">Register</button>
        </form>
        <div><p>Already Registered? <a href="studentlogin.php">Log In</a></p></div>
    </div>
</div>

</body>
</html>
