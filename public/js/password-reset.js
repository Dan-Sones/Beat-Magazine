document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('submit').disabled = true;
});


const passwordInput = document.getElementById('newPassword');
const confirmPasswordInput = document.getElementById('confirmNewPassword');


const checkPassword = () => {
    const passwordValue = passwordInput.value;
    // Check to see if the password:
    // 1. Contains at least 3 numbers
    // 2. Contains at least 1 capital letter
    // 3. Contains at least 1 piece of punctuation
    // 4. Is greater than 8 characters
    const confirmNumbers = passwordValue.match(/[0-9]/g) && passwordValue.match(/[0-9]/g).length >= 3;
    const confirmCapital = passwordValue.match(/[A-Z]/g) && passwordValue.match(/[A-Z]/g).length >= 1;
    const confirmPunctuation = passwordValue.match(/[!@#$%^&*()_+]/g) && passwordValue.match(/[!@#$%^&*()_+]/g).length >= 1;
    const confirmLength = passwordValue.length >= 8;
    const confirmPasswordsMatch = passwordValue === confirmPasswordInput.value;

    document.getElementById('confirmNumbersStatus').innerHTML = confirmNumbers ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
    document.getElementById('confirmCapitalStatus').innerHTML = confirmCapital ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
    document.getElementById('confirmPunctuationStatus').innerHTML = confirmPunctuation ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
    document.getElementById('confirmLengthStatus').innerHTML = confirmLength ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
    document.getElementById('passwordsMatchStatus').innerHTML = confirmPasswordsMatch ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';

    // Disable form submission if the password does not meet the criteria
    document.getElementById('submit').disabled = !confirmNumbers || !confirmCapital || !confirmPunctuation || !confirmLength;
}

// When the user enters the textbox
passwordInput.addEventListener('input', checkPassword);
confirmPasswordInput.addEventListener('input', checkPassword);

passwordInput.addEventListener('blur', () => {
    passwordInput.classList.remove('is-invalid');
})

const submitResetPassword = async (event) => {
    event.preventDefault();

    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (newPassword !== confirmPassword) {
        passwordInput.classList.add('is-invalid');
        confirmPassword.classList.add('is-invalid');
        Swal.fire({
            title: 'Passwords do not match',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
            confirmButtonText: 'Got It'
        });
        return;
    }

    // We technically don't need to check this again, but it's good practice

    // Check to see if the password:
    // 1. Contains at least 3 numbers
    // 2. Contains at least 1 capital letter
    // 3. Contains at least 1 piece of punctuation
    // 4. Is greater than 8 characters
    if (!newPassword.match(/^(?=.*[A-Z])(?=.*[0-9]{3,})(?=.*[!@#$%^&*()_+])[a-zA-Z0-9!@#$%^&*()_+]{8,}$/)) {
        // set the error style
        passwordInput.classList.add('is-invalid');
        Swal.fire({
            title: 'Password does not meet requirements',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
            confirmButtonText: 'Got It'
        });
        return;
    }

    passwordInput.classList.remove('is-invalid');

    try {
        const response = await fetch('/api/password-reset', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                new_password: newPassword,
                token: new URLSearchParams(window.location.search).get('token')
            })
        });

        if (response.status === 200) {
            Swal.fire({
                title: 'Password reset successfully',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'success',
                confirmButtonText: 'Got It'
            }).then(() => {
                window.location.href = '/login';
            });
        } else {
            Swal.fire({
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                title: 'An error occurred while resetting your password',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        Swal.fire({
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            title: 'Network error occurred while resetting your password',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
}
