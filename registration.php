<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="registration.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="whole">
        <div class="wrapper">
            <form action="registration.php" method="post" autocomplete="off">
                <h1>Registration Form</h1>

                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="input-box">
                    <input type="text" placeholder="Name" name="username" value="<?php echo htmlspecialchars($fullname ?? ''); ?>" required autocomplete="off">
                    <i class="fas fa-user"></i>
                </div>

                <div class="input-box">
                    <input type="text" placeholder="ID No." name="idnum" value="<?php echo htmlspecialchars($idnum ?? ''); ?>" required autocomplete="off">
                    <i class="fas fa-id-card"></i>
                </div>

                <div class="input-box">
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
                    <i class="fas fa-users"></i>
                </div>

                <div class="input-box">
                    <input type="email" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required autocomplete="off">
                    <i class="fas fa-envelope"></i>
                </div>

                <div class="input-box">
                    <input type="password" placeholder="Password" name="password" required autocomplete="new-password">
                    <i class="fas fa-lock"></i>
                </div>

                <button type="submit" name="submit" class="btn">Register</button>

                <div class="register-link">
                    <p>Already Registered? <a href="studentlogin.php">Log In</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
