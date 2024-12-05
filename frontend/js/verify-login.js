// AJAX to verify user login status and redirect if necessary
document.addEventListener('DOMContentLoaded', async () => {
    console.log('Script loaded');
    try {
        const response = await fetch('../../backend/session.php');
        console.log(response);
        const data = await response.json();

        if (data.loggedIn === true) {
           // document.getElementById('user-message').textContent = `Hello, ${data.username}! You are logged in.`;
           console.log('User is logged in');
           document.getElementById('uname').innerHTML = "Signed in as <span style='color: red'>" +  data.username + "</span>";
        } else {
            window.location.href = '../pages/login.html'; // Redirect if not logged in
        }
    } catch (error) {
        console.error('Error fetching session data:', error);
        
    }
});