const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const loginForm = document.getElementById('loginForm');

const submitLoginForm = async (event) => {
    event.preventDefault();
    const data = {
        email: emailInput.value,
        password: passwordInput.value
    };
    return await fetch('/api/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => {
        if (response.status === 200) {
            // Hide Login form and show otp form
            loginForm.classList.add('d-none');
            document.getElementById('otpForm').classList.remove('d-none');

        } else {
            emailInput.classList.add('is-invalid');
            passwordInput.classList.add('is-invalid');
        }
    });
};


const submitOTPForm = async (event) => {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const otp = formData.get('otp');

    const data = {
        otp: otp
    };

    return await fetch('/api/verify-otp', {
        method: 'POST',
        body: JSON.stringify(data),
        contentType: 'application/json'
    }).then(response => {
        if (!response.ok) {
            Swal.fire({
                title: 'Invalid OTP',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
        return response.json();
    }).then(data => {
        if (data.valid) {
            window.location.href = '/albums';
        } else {
            Swal.fire({
                title: 'Something went wrong',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
            document.getElementById('submitOTP').disabled = true;
        }
    });
};

const handleRequestPasswordReset = async () => {
    const email = emailInput.value;
    const data = {
        email: email
    };

    Swal.fire({
        title: 'Sending password reset email',
        didOpen: () => {
            Swal.showLoading();

            fetch('/api/password-reset-request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            }).then(response => {
                if (response.status === 200) {
                    Swal.fire({
                        title: 'Password reset email sent',
                        icon: 'success',
                        confirmButtonText: 'Got It'
                    });
                } else {
                    Swal.fire({
                        title: 'Failed to send password reset email, make sure you entered the correct email address.',
                        icon: 'error',
                        confirmButtonText: 'Got It'
                    });
                }
            });
        }


    })


};

emailInput.addEventListener('input', () => {
    document.getElementById('passwordResetLink').disabled = !isEmailValid()
});


const isEmailValid = () => {
    return emailInput.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);
}