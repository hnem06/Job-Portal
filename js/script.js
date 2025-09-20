document.addEventListener('DOMContentLoaded', function() {
    const signinForm = document.getElementById('signin-form');
    const signupForm = document.getElementById('signup-form');

    const showSignupLink = document.getElementById('show-signup');
    const showSigninLink = document.getElementById('show-signin');

    // Khi nhấn vào link "Sign Up"
    showSignupLink.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn link chuyển trang
        signinForm.style.display = 'none';
        signupForm.style.display = 'block';
    });

    // Khi nhấn vào link "Sign In"
    showSigninLink.addEventListener('click', function(event) {
        event.preventDefault(); // Ngăn link chuyển trang
        signupForm.style.display = 'none';
        signinForm.style.display = 'block';
    });
});