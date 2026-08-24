document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    if (!form) return;

    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    function validateEmail() {
        if (!isRequired(emailInput, 'Email address is required.')) return false;
        return isValidEmail(emailInput);
    }

    function validatePassword() {
        return isRequired(passwordInput, 'Password is required.');
    }

    emailInput.addEventListener('blur', validateEmail);

    passwordInput.addEventListener('blur', validatePassword);

    emailInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            validateEmail();
        }
    });

    passwordInput.addEventListener('input', function() {
        if (this.value !== '') {
            validatePassword();
        }
    });

    form.addEventListener('submit', function(event) {
        let isValid = true;

        if (!validateEmail()) {
            isValid = false;
        }

        if (!validatePassword()) {
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();

            const firstInvalidField = form.querySelector('.is-invalid');

            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        }
    });
});