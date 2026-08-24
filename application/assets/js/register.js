document.addEventListener('DOMContentLoaded', function() {
    console.log("Registration.js loaded")
    const form = document.getElementById('registrationForm');
    if (!form) return;

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const roleInput = document.getElementById('role_id');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    function validateName() {
        if (!isRequired(nameInput, 'Full name is required.')) return false;
        if (!hasMinLength(nameInput, 2, 'Full name must be at least 2 characters.')) return false;
        if (!hasMaxLength(nameInput, 100, 'Full name cannot exceed 100 characters.')) return false;

        const namePattern = /^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/;

        if (!namePattern.test(nameInput.value.trim())) {
            showError(nameInput, 'Full name can only contain letters, spaces, apostrophes and hyphens.');
            return false;
        }

        clearError(nameInput);
        return true;
    }

    function validateEmail() {
        if (!isRequired(emailInput, 'Email address is required.')) return false;
        return isValidEmail(emailInput);
    }

    function validateRole() {
        if (roleInput.value === '') {
            showError(roleInput, 'Please select a role.');
            return false;
        }
        clearError(roleInput);
        return true;
    }

    function validatePassword() {
        if (!isRequired(passwordInput, 'Password is required.')) return false;
        return hasMinLength(passwordInput, 6, 'Password must be at least 6 characters.');
    }

    function validateConfirmPassword() {
        if (!isRequired(confirmPasswordInput, 'Please confirm your password.')) return false;

        if (confirmPasswordInput.value !== passwordInput.value) {
            showError(confirmPasswordInput, 'Passwords do not match.');
            return false;
        }

        clearError(confirmPasswordInput);
        return true;
    }

    nameInput.addEventListener('blur', validateName);

    emailInput.addEventListener('blur', validateEmail);

    roleInput.addEventListener('change', validateRole);

    passwordInput.addEventListener('blur', function() {
        validatePassword();
        if (confirmPasswordInput.value !== '') {
            validateConfirmPassword();
        }
    });

    confirmPasswordInput.addEventListener('blur', validateConfirmPassword);

    nameInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            validateName();
        }
    });

    emailInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            validateEmail();
        }
    });

    passwordInput.addEventListener('input', function() {
        if (this.value !== '') {
            validatePassword();
        }
        if (confirmPasswordInput.value !== '') {
            validateConfirmPassword();
        }
    });

    confirmPasswordInput.addEventListener('input', function() {
        if (this.value !== '') {
            validateConfirmPassword();
        }
    });

    form.addEventListener('submit', function(event) {
        let isValid = true;

        if (!validateName()) isValid = false;
        if (!validateEmail()) isValid = false;
        if (!validateRole()) isValid = false;
        if (!validatePassword()) isValid = false;
        if (!validateConfirmPassword()) isValid = false;

        if (!isValid) {
            event.preventDefault();
            const firstInvalidField = form.querySelector('.is-invalid');
            if (firstInvalidField) {
                firstInvalidField.focus();
            }
        }
    });
});