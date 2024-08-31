document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === 'user' && password === 'password') {
        alert('Login successful!');
        
        window.location.href = 'user.html';
    } else {
        alert('Invalid username or password!');
    }
});
