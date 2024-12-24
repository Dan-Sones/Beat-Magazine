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
            alert('Invalid code');
        }
        return response.json();
    }).then(data => {
        if (data.valid) {
            window.location.href = '/albums';
        } else {
            alert('Invalid code');
            document.getElementById('submitOTP').disabled = true;
        }
    });
};

const handleRequestPasswordReset = async () => {
    const email = emailInput.value;
    const data = {
        email: email
    };
    return await fetch('/api/password-reset-request', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => {
        if (response.status === 200) {
            alert('Password reset email sent');
        } else {
            alert('Unable to send password reset email');
        }
    });
};

emailInput.addEventListener('input', () => {
    document.getElementById('passwordResetLink').disabled = !isEmailValid()
});


const isEmailValid = () => {
    return emailInput.value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/);
}