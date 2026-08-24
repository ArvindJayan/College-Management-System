function showError(input, message) {
    input.classList.add('is-invalid');
    let errorElement = input.parentElement.querySelector('.invalid-feedback');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.classList.add('invalid-feedback');
        input.parentElement.appendChild(errorElement);
    }
    errorElement.textContent = message;
}

function clearError(input) {
    input.classList.remove('is-invalid');
    const errorElement = input.parentElement.querySelector('.invalid-feedback');
    if (errorElement) {
        errorElement.remove();
    }
}

function isRequired(input, message) {
    if (input.value.trim() === '') {
        showError(input, message);
        return false;
    }
    clearError(input);
    return true;
}

function isValidEmail(input) {
    const email = input.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        showError(input, 'Please enter a valid email address.');
        return false;
    }
    clearError(input);
    return true;
}

function hasMinLength(input, min, message) {
    if (input.value.length < min) {
        showError(input, message);
        return false;
    }
    clearError(input);
    return true;
}

function hasMaxLength(input, max, message) {
    if (input.value.length > max) {
        showError(input, message);
        return false;
    }
    clearError(input);
    return true;
}