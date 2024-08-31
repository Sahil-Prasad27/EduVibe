document.getElementById('register-form').addEventListener('submit', function(event) {
    event.preventDefault();

    // You can add your registration logic here
    const username = document.getElementById('new-username').value;
    const password = document.getElementById('new-password').value;

    // Example: Save the new user credentials (this would normally involve a backend)
    console.log(`Registered with username: ${username} and password: ${password}`);
    alert('Registration successful! You can now login.');
    window.location.href = 'index.html';
});
