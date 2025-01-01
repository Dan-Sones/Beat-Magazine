const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password');
const loginForm = document.getElementById('loginForm');

const submitLoginForm = async (event) => {
    event.preventDefault();
    const data = {
        email: emailInput.value,
        password: passwordInput.value
    };
    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (response.status === 200) {
            loginForm.classList.add('d-none');
            document.getElementById('otpForm').classList.remove('d-none');
        } else {
            emailInput.classList.add('is-invalid');
            passwordInput.classList.add('is-invalid');
        }
    } catch (error) {
        console.error('Error during login:', error);
    }
};

const submitOTPForm = async (event) => {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const otp = formData.get('otp');
    const data = {otp};

    try {
        const response = await fetch('/api/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            const result = await response.json();
            if (result.valid) {
                window.location.href = '/albums';
            } else {
                Swal.fire({
                    title: 'Something went wrong',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary btn-lg',
                        loader: 'custom-loader'
                    },
                    confirmButtonText: 'Got It'
                });
                document.getElementById('submitOTP').disabled = true;
            }
        } else {
            Swal.fire({
                title: 'Invalid OTP',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        console.error('Error during OTP verification:', error);
    }
};

const handleRequestPasswordReset = async () => {
    const email = emailInput.value;
    const data = {email};

    Swal.fire({
        title: 'Sending password reset email',
        didOpen: async () => {
            Swal.showLoading();
            try {
                const response = await fetch('/api/password-reset-request', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (response.status === 200) {
                    Swal.fire({
                        title: 'Password reset email sent',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary btn-lg',
                            loader: 'custom-loader'
                        },
                        confirmButtonText: 'Got It'
                    });
                } else if (response.status === 404) {
                    Swal.fire({
                        title: 'We could not find an account with that email address.',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary btn-lg',
                            loader: 'custom-loader'
                        },
                        confirmButtonText: 'Got It'
                    });
                } else {
                    Swal.fire({
                        title: 'Failed to send password reset email, make sure you entered the correct email address.',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary btn-lg',
                            loader: 'custom-loader'
                        },
                        confirmButtonText: 'Got It'
                    });
                }
            } catch (error) {
                console.error('Error during password reset request:', error);
            }
        }
    });
};

emailInput.addEventListener('input', () => {
    document.getElementById('passwordResetLink').disabled = !isEmailValid();
});

const isEmailValid = () => {
    return /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(emailInput.value);
};