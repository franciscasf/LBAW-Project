function validatePassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    let isValid = true;

    if (password.length < 6) {
        passwordError.textContent = 'Password must be at least 6 characters long.';
        isValid = false;
    } else {
        passwordError.textContent = '';
    }


    if (confirmPassword !== password) {
        confirmPasswordError.textContent = 'Passwords do not match.';
        isValid = false;
    } else {
        confirmPasswordError.textContent = '';
    }

    return isValid;
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!validatePassword()) {
                event.preventDefault(); 
            }
        });

        
        document.getElementById('password').addEventListener('input', validatePassword);
        document.getElementById('password_confirmation').addEventListener('input', validatePassword);
    }
});
