<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="login2.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Goblin+One&family=Outfit:wght@100..900&family=Spicy+Rice&display=swap" rel="stylesheet">
</head>

<body>

   
<div class="main">
    
    <input type="checkbox" id="chk" aria-hidden="true">
    <div class="logo">
        <img src="images/CTU Logo.png" class="logo">
    </div>
    
    <div class="admin">
    <form>
            <label for="chk" aria-hidden="true">Admin Login</label>
            <input type = "text" name="" placeholder="Username" required>
            <input type = "password" name="" placeholder="Password" required>

            <a href="registers.php">
            <button type="button">Login</button>
            </a>

        <div class="register">
            <p> Don't have account? <a href="#"> Register</a></p>
        </div>
    </form>
    </div>
    

            <div class="student">
            <?php
require_once "database.php";

if (isset($_POST['login'])) {
    $idnum = $_POST['idnum'];
    $errors = array();

    // Query to check if ID number exists in the database
    $sql = "SELECT * FROM users WHERE idnum = ?";
    $stmt = mysqli_stmt_init($conn_login_register);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $idnum);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) == 1) {
            // ID number exists, log in the user
            $_SESSION['idnum'] = $idnum;
            echo "<script>
                    alert('Login successful.');
                    window.location.href='borrow.php';
                  </script>";
        } else {
            // ID number does not exist, show error message
            array_push($errors, "ID number is incorrect.");
        }
    } else {
        array_push($errors, "Something went wrong: " . mysqli_error($conn_login_register));
    }

    // Display errors if there are any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn_login_register);
}
?>
         

                
            </div>
</div>


<div class="text">
    <h1 style="color: white; text-shadow:black 10px 5px 8px; font-size:100px;"> KEY <br>
        MANAGEMENT<br>
         SYSTEM</h1>
   </div>  

                 
</body>




</html>