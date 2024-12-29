document.addEventListener('DOMContentLoaded', function () {
    const step1Form = document.getElementById('step1Form');
    const nextButton = step1Form.querySelector('.next-btn');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const validateInput = (input, isValid, message) => {
        if (!isValid) {
            input.classList.add('is-invalid');
            input.setAttribute('data-bs-title', message);
            new bootstrap.Tooltip(input);

        } else {
            input.classList.remove('is-invalid');
            input.removeAttribute('data-bs-title');
            bootstrap.Tooltip.getInstance(input).dispose();

        }
    };

    const validateUsername = () => {
        const username = usernameInput.value;
        let isValid = true; // Start with valid by default

        if (username.length < 3) {
            isValid = false;
        }

        const usernamePattern = /^[a-zA-Z0-9_\.]+$/;
        if (!usernamePattern.test(username)) {
            isValid = false;
        }

        validateInput(
            usernameInput,
            isValid,
            'Username must be at least 3 characters long. Only letters, numbers, underscores, and periods are allowed.'
        );

        return isValid;
    };

    const validateEmail = () => {
        const email = emailInput.value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValid = emailPattern.test(email);
        validateInput(emailInput, isValid, 'Please enter a valid email address.');
        return isValid;
    };

    const validatePassword = () => {
        const isValid = checkPassword();
        validateInput(passwordInput, isValid, 'Password does not meet requirements.');
        return isValid;
    };


    const checkFormValidity = () => {
        const isFormValid = validateUsername() && validateEmail() && validatePassword()
        nextButton.disabled = !isFormValid;
    };

    const checkPassword = () => {
        const confirmNumbers = passwordInput.value.match(/[0-9]/g) && passwordInput.value.match(/[0-9]/g).length >= 3;
        const confirmCapital = passwordInput.value.match(/[A-Z]/g) && passwordInput.value.match(/[A-Z]/g).length >= 1;
        const confirmPunctuation = passwordInput.value.match(/[!@#$%^&*()_+]/g) && passwordInput.value.match(/[!@#$%^&*()_+]/g).length >= 1;
        const confirmLength = passwordInput.value.length >= 8;

        document.getElementById('confirmNumbersStatus').innerHTML = confirmNumbers ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
        document.getElementById('confirmCapitalStatus').innerHTML = confirmCapital ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
        document.getElementById('confirmPunctuationStatus').innerHTML = confirmPunctuation ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
        document.getElementById('confirmLengthStatus').innerHTML = confirmLength ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';

        return confirmNumbers && confirmCapital && confirmPunctuation && confirmLength;
    };

    passwordInput.addEventListener('input', checkPassword);
    passwordInput.addEventListener('blur', () => {
        passwordInput.classList.remove('is-invalid');
    });

    usernameInput.addEventListener('blur', validateUsername);
    emailInput.addEventListener('blur', validateEmail);
    passwordInput.addEventListener('blur', checkPassword);

    step1Form.addEventListener('input', checkFormValidity);

    nextButton.disabled = true;
});