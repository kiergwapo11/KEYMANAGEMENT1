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

    // Initialize errors array
    $errors = array();

    if (isset($_POST["submit"])) {
        $fullname = $_POST["username"];
        $idnum = $_POST["idnum"];
        $section = $_POST["section"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Check if ID number already exists
        $checkId = "SELECT * FROM users WHERE idnum = ?";
        $stmt = mysqli_stmt_init($conn_login_register);
        if (mysqli_stmt_prepare($stmt, $checkId)) {
            mysqli_stmt_bind_param($stmt, "s", $idnum);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $errors[] = "This ID number is already registered.";
            }
        }

        // Other validations
        if (strlen($idnum) < 7) {
            $errors[] = "ID number must be 7 digits long.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email is not valid.";
        }

        if (count($errors) === 0) {
            // Continue with registration if no errors
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, idnum, section, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn_login_register);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "sssss", $fullname, $idnum, $section, $email, $hashed_password);
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['user'] = $email;
                    echo "<script>
                        alert('You have successfully registered!');
                        window.location.href='studentlogin.php';
                    </script>";
                    exit();
                } else {
                    $errors[] = "Something went wrong: " . mysqli_stmt_error($stmt);
                }
            } else {
                $errors[] = "Something went wrong: " . mysqli_error($conn_login_register);
            }
        }
    }
    ?>
    <div class="register">
    <h1>Registration Form</h1>
    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
        <form action="registration.php" method="post" autocomplete="off" >
            <input type="text" placeholder="Name" name="username" value="<?php echo htmlspecialchars($fullname ?? ''); ?>" required autocomplete="off">
            <input type="text" placeholder="ID No." name="idnum" value="<?php echo htmlspecialchars($idnum ?? ''); ?>" required autocomplete="off">
            <select id="section" name="section" required autocomplete="off">
                <option value="">Select Section</option>
                <option value="BSCpE 1" <?php if (($section ?? '') == 'BSCpE 1') echo 'selected'; ?>>BSCpE 1</option>
                <option value="BSCpE 2-Day" <?php if (($section ?? '') == 'BSCpE 2-Day') echo 'selected'; ?>>BSCpE 2-Day</option>
                <option value="BSCpE 2A-Night" <?php if (($section ?? '') == 'BSCpE 2A-Night') echo 'selected'; ?>>BSCpE 2A-Night</option>
                <option value="BSCpE 2B-Night" <?php if (($section ?? '') == 'BSCpE 2B-Night') echo 'selected'; ?>>BSCpE 2B-Night</option>
                <option value="BSCpE 3-Day" <?php if (($section ?? '') == 'BSCpE 3-Day') echo 'selected'; ?>>BSCpE 3-Day</option>
                <option value="BSCpE 3-Night" <?php if (($section ?? '') == 'BSCpE 3-Night') echo 'selected'; ?>>BSCpE 3-Night</option>
                <option value="BSCpE 4-Day" <?php if (($section ?? '') == 'BSCpE 4-Day') echo 'selected'; ?>>BSCpE 4-Day</option>
                <option value="BSCpE 4-Night" <?php if (($section ?? '') == 'BSCpE 4-Night') echo 'selected'; ?>>BSCpE 4-Night</option>
                <option value="BSME 1" <?php if (($section ?? '') == 'BSME 1') echo 'selected'; ?>>BSME 1</option>
                <option value="BSME 2-Day" <?php if (($section ?? '') == 'BSME 2-Day') echo 'selected'; ?>>BSME 2-Day</option>
                <option value="BSME 2-Night" <?php if (($section ?? '') == 'BSME 2-Night') echo 'selected'; ?>>BSME 2-Night</option>
                <option value="BSME 3" <?php if (($section ?? '') == 'BSME 3') echo 'selected'; ?>>BSME 3</option>
                <option value="BSME 4" <?php if (($section ?? '') == 'BSME 4') echo 'selected'; ?>>BSME 4</option>
                <option value="BSIE 1" <?php if (($section ?? '') == 'BSIE 1') echo 'selected'; ?>>BSIE 1</option>
                <option value="BSIE 2A-Day" <?php if (($section ?? '') == 'BSIE 2A-Day') echo 'selected'; ?>>BSIE 2A-Day</option>
                <option value="BSIE 2B-Day" <?php if (($section ?? '') == 'BSIE 2B-Day') echo 'selected'; ?>>BSIE 2B-Day</option>
                <option value="BSIE 2A-Night" <?php if (($section ?? '') == 'BSIE 2A-Night') echo 'selected'; ?>>BSIE 2A-Night</option>
                <option value="BSIE 2B-Nght" <?php if (($section ?? '') == 'BSIE 2B-Nght') echo 'selected'; ?>>BSIE 2B-Nght</option>
                <option value="BSIE 3A-Day" <?php if (($section ?? '') == 'BSIE 3A-Day') echo 'selected'; ?>>BSIE 3A-Day</option>
                <option value="BSIE 3B-Day" <?php if (($section ?? '') == 'BSIE 3B-Day') echo 'selected'; ?>>BSIE 3B-Day</option>
                <option value="BSIE 3A-Night" <?php if (($section ?? '') == 'BSIE 3A-Night') echo 'selected'; ?>>BSIE 3A-Night</option>
                <option value="BSIE 3B-Night" <?php if (($section ?? '') == 'BSIE 3B-Night') echo 'selected'; ?>>BSIE 3B-Night</option>
                <option value="BSIE 4-Day" <?php if (($section ?? '') == 'BSIE 4-Day') echo 'selected'; ?>>BSIE 4-Day</option>
                <option value="BSIE 4-Night" <?php if (($section ?? '') == 'BSIE 4-Night') echo 'selected'; ?>>BSIE 4-Night</option>
                <option value="BSCE 1" <?php if (($section ?? '') == 'BSCE 1') echo 'selected'; ?>>BSCE 1</option>
                <option value="BSCE 2-Day" <?php if (($section ?? '') == 'BSCE 2-Day') echo 'selected'; ?>>BSCE 2-Day</option>
                <option value="BSCE 2A-Night" <?php if (($section ?? '') == 'BSCE 2A-Night') echo 'selected'; ?>>BSCE 2A-Night</option>
                <option value="BSCE 2B-Night" <?php if (($section ?? '') == 'BSCE 2B-Night') echo 'selected'; ?>>BSCE 2B-Night</option>
                <option value="BSCE 3-Day" <?php if (($section ?? '') == 'BSCE 3-Day') echo 'selected'; ?>>BSCE 3-Day</option>
                <option value="BSCE 3A-Night" <?php if (($section ?? '') == 'BSCE 3A-Night') echo 'selected'; ?>>BSCE 3A-Night</option>
                <option value="BSCE 3B-Night" <?php if (($section ?? '') == 'BSCE 3B-Night') echo 'selected'; ?>>BSCE 3B-Night</option>
                <option value="BSCE 4" <?php if (($section ?? '') == 'BSCE 4') echo 'selected'; ?>>BSCE 4</option>
                <option value="BSEE 1" <?php if (($section ?? '') == 'BSEE 1') echo 'selected'; ?>>BSEE 1</option>
                <option value="BSEE 2-Day" <?php if (($section ?? '') == 'BSEE 2-Day') echo 'selected'; ?>>BSEE 2-Day</option>
                <option value="BSEE 2-Night" <?php if (($section ?? '') == 'BSEE 2-Night') echo 'selected'; ?>>BSEE 2-Night</option>
                <option value="BSEE 3-Day" <?php if (($section ?? '') == 'BSEE 3-Day') echo 'selected'; ?>>BSEE 3-Day</option>
                <option value="BSEE 3-Night" <?php if (($section ?? '') == 'BSEE 3-Night') echo 'selected'; ?>>BSEE 3-Night</option>
                <option value="BSEE 4" <?php if (($section ?? '') == 'BSEE 4') echo 'selected'; ?>>BSEE 4</option>
            </select>
            <input type="email" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required autocomplete="off">
            <input type="password" placeholder="Password" name="password" required autocomplete="new-password">
            <button type="submit" name="submit">Register</button>
        </form>
        <div><p>Already Registered? <a href="studentlogin.php">Log In</a></p></div>
    </div>
</div>

</body>
</html>
