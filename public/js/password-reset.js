// on page load disable the submit button
document.getElementById('submit').disabled = true;

const checkPassword = () => {
    const password = document.getElementById('new_password').value;

    // Check to see if the password:
    // 1. Contains at least 3 numbers
    // 2. Contains at least 1 capital letter
    // 3. Contains at least 1 piece of punctuation
    // 4. Is greater than 8 characters
    const confirmNumbers = password.match(/[0-9]/g) && password.match(/[0-9]/g).length >= 3;
    const confirmCapital = password.match(/[A-Z]/g) && password.match(/[A-Z]/g).length >= 1;
    const confirmPunctuation = password.match(/[!@#$%^&*()_+]/g) && password.match(/[!@#$%^&*()_+]/g).length >= 1;
    const confirmLength = password.length >= 8;

    document.getElementById('confirmNumbersStatus').innerHTML = confirmNumbers ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
    document.getElementById('confirmCapitalStatus').innerHTML = confirmCapital ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
    document.getElementById('confirmPunctuationStatus').innerHTML = confirmPunctuation ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';
    document.getElementById('confirmLengthStatus').innerHTML = confirmLength ? '<i class="bi bi-check-circle-fill text-success"></i>' : '<i class="bi bi-x-circle-fill text-danger"></i>';

    // Disable form submission if the password does not meet the criteria
    document.getElementById('submit').disabled = !confirmNumbers || !confirmCapital || !confirmPunctuation || !confirmLength;
}

// When the user enters the textbox
document.getElementById('new_password').addEventListener('input', () => {
    document.getElementById('confirmNumbersStatus').innerHTML = '';
    document.getElementById('confirmCapitalStatus').innerHTML = '';
    document.getElementById('confirmPunctuationStatus').innerHTML = '';
    document.getElementById('confirmLengthStatus').innerHTML = '';

    document.getElementById('confirmNumbersStatus').innerHTML = '<div class="spinner-border" role="status"></div>';
    document.getElementById('confirmCapitalStatus').innerHTML = '<div class="spinner-border" role="status"></div>';
    document.getElementById('confirmPunctuationStatus').innerHTML = '<div class="spinner-border" role="status"></div>';
    document.getElementById('confirmLengthStatus').innerHTML = '<div class="spinner-border" role="status"></div>';
})

document.getElementById('new_password').addEventListener('blur', checkPassword);

document.getElementById('new_password').addEventListener('blur', () => {
    document.getElementById('new_password').classList.remove('is-invalid');
})

const submitResetPassword = async (event) => {
    event.preventDefault();

    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (newPassword !== confirmPassword) {
        document.getElementById('new_password').classList.add('is-invalid');
        document.getElementById('confirm_password').classList.add('is-invalid');
        Swal.fire({
            title: 'Passwords do not match',
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
        document.getElementById('new_password').classList.add('is-invalid');
        Swal.fire({
            title: 'Password does not meet requirements',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
        return;
    }

    document.getElementById('new_password').classList.remove('is-invalid');

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
                icon: 'success',
                confirmButtonText: 'Got It'
            }).then(() => {
                window.location.href = '/login';
            });
        } else {
            Swal.fire({
                title: 'An error occurred while resetting your password',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Network error occurred while resetting your password',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
}

document.getElementById('resetPasswordForm').addEventListener('submit', submitResetPassword);