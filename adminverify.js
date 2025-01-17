// JavaScript to verify the password
document.getElementById('passwordForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form submission

    // Predefined password
    const correctPassword = 'gwaposirj';
    
    // Get the entered password
    const enteredPassword = document.getElementById('passwordInput').value;

    // Message element
    const messageElement = document.getElementById('message');

    // Check if the entered password matches the predefined password
    if (enteredPassword === correctPassword) {
        messageElement.textContent = 'Password is correct!';
        messageElement.style.color = 'green';
    } else {
        messageElement.textContent = 'Incorrect password!';
        messageElement.style.color = 'red';
    }
});
