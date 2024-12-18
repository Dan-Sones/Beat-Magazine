<div class="carousel-item active">
    <h3 class="mb-4 text-center">Step 1: Basic Information</h3>
    <form id="step1Form">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username"
                   placeholder="Enter username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email"
                   placeholder="Enter email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password"
                   placeholder="Enter password" required>
        </div>

        <div class="card p-4 shadow-sm mb-2">
            <h5 class="text-center pb-2">Password Requirements</h5>
            <ul class="list-unstyled mb-4" id="password-status">
                <li class="d-flex justify-content-between align-items-center">
                    <span>Contain at least 3 numbers:</span>
                    <div id="confirmNumbersStatus">
                        <div class="spinner-border" role="status"></div>
                    </div>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span>Contain at least 1 capital letter:</span>
                    <div id="confirmCapitalStatus">
                        <div class="spinner-border" role="status"></div>
                    </div>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span>Contain at least 1 piece of punctuation:</span>
                    <div class="ps-5" id="confirmPunctuationStatus">
                        <div class="spinner-border" role="status"></div>
                    </div>
                </li>
                <li class="d-flex justify-content-between align-items-center">
                    <span>Be greater than 8 characters:</span>
                    <div id="confirmLengthStatus">
                        <div class="spinner-border" role="status"></div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="d-flex justify-content-center">
            <button class=" btn btn-primary next-btn me-2
                                    " type="button"
                    data-bs-target="#registrationCarousel" data-bs-slide="next">
                Next
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const step1Form = document.getElementById('step1Form');
        const nextButton = step1Form.querySelector('.next-btn');
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');

        const validateInput = (input, isValid, message) => {
            if (!isValid) {
                input.classList.add('is-invalid');
                input.setAttribute('title', message);
            } else {
                input.classList.remove('is-invalid');
                input.removeAttribute('title');
            }
        };

        const validateUsername = () => {
            const username = usernameInput.value.trim();
            const isValid = username.length >= 3;
            validateInput(usernameInput, isValid, 'Username must be at least 3 characters long.');
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
            const password = passwordInput.value.trim();
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

</script>