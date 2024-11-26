<?php
session_start();

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_email'])) {
    header("Location: adminlogin.php");
    exit();
}

// Check if the logout button was clicked
if (isset($_POST['logout'])) {
    // Destroy the session to log out the admin
    session_unset();
    session_destroy();
    header("Location: adminlogin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/x-icon" href="/pics/CTU LOGO.png">
    <script src="https://kit.fontawesome.com/4804625ee9.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="admindashboard.css">
    <title>ADMIN - CTU KEY MANAGEMENT SYSTEM</title>
</head> 
<body>

    <div class="homepage">
        <div class="navigator">
            <h2>DASHBOARD</h2>
            <ul>
                <li> <a href="#" onclick="loadContent('admin')"> <i class="fa-solid fa-house"></i> ADMIN </a></li>
                <li> <a href="#" onclick="loadContent('registers')"> <i class="fa-solid fa-pen-to-square"></i> REGISTERED </a></li>
                <li> <a href="#" onclick="loadContent('records')"> <i class="fa-solid fa-key"></i> RECORDS </a></li>
                
                <li class="logout">
                    <a href="#" onclick="document.getElementById('logoutForm').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i> Log out
                    </a>
                    <form id="logoutForm" method="post" style="display: none;">
                        <input type="hidden" name="logout" value="1">
                    </form>
                </li>
            </ul>
        </div>



            <div id="mainContent">
                <div class="greetings">
                    <h2> Welcome back, Admin!</h2>
                    <p>Welcome to the admin dashboard!</p>
                    <img src="Images/work.png" class="image"> 
                </div>
            </div>
        </div>
    </div>

    <script>
    function loadContent(page) {
        // First check if the element exists
        const mainContent = document.getElementById('mainContent');
        if (!mainContent) {
            console.error('Could not find mainContent element');
            return;
        }

        if (page === 'registers') {
            // Show loading state
            mainContent.innerHTML = 'Loading...';
            
            fetch('registers.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    // Make sure mainContent still exists before setting innerHTML
                    const contentDiv = document.getElementById('mainContent');
                    if (contentDiv) {
                        contentDiv.innerHTML = html;
                    } else {
                        console.error('mainContent element not found after fetch');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const contentDiv = document.getElementById('mainContent');
                    if (contentDiv) {
                        contentDiv.innerHTML = 'Error loading content: ' + error;
                    }
                });
        } else if (page === 'admin') {
            mainContent.innerHTML = `
                <div class="greetings">
                    <h2> Welcome back, Admin!</h2>
                    <p>Welcome to the admin dashboard!</p>
                    <img src="Images/work.png" class="image"> 
                </div>
            `;
        }
    }

    // Add this to verify the element exists when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        const mainContent = document.getElementById('mainContent');
        if (!mainContent) {
            console.error('mainContent element not found on page load');
        } else {
            console.log('mainContent element found successfully');
        }
    });
    </script>
</body>
</html>
