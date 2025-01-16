<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Verification</title>
    <link rel="stylesheet" href="adminverify.css">
</head>
<body>
    <div class="container">
        <div class="verification-box">
            <h2>Admin Password</h2>
            <form id="passwordForm">
                <div class="input-box">
                    <input type="password" id="passwordInput" required>
                    <label>Password</label>
                </div>
                <div class="button-container">
                    <button type="submit">Verify</button>
                </div>
                <p id="message"></p>
            </form>
        </div>
    </div>

    <button class="bottom-right-button" onclick="location.href='studentlogin.php'">Go Back</button>
    <script src="adminverify.js"></script>
</body>
</html>
