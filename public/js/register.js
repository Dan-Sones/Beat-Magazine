// Each time the next button is clicked, update the confirm details (We have multiple next buttons)
document.querySelectorAll('.next-btn[data-bs-slide="next"]').forEach(function (button) {
    button.addEventListener('click', function () {
        document.getElementById('confirmUsername').textContent = document.getElementById('username').value;
        document.getElementById('confirmEmail').textContent = document.getElementById('email').value;
        document.getElementById('confirmFirstName').textContent = document.getElementById('firstName').value;
        document.getElementById('confirmLastName').textContent = document.getElementById('lastName').value;
    });
});

const isUsernameTaken = async (username) => {
    try {
        const response = await fetch('/api/register/isUsernameTaken?' + new URLSearchParams({"username": username}), {
            method: 'GET',
        });
        if (!response.ok) {
            // Something went wrong so assume it's taken
            return true;
        }
        const data = await response.json();
        return data.taken;
    } catch (error) {
        console.error('Error checking username:', error);
        return true;
    }
};

const isEmailTaken = async (email) => {
    try {
        const response = await fetch('/api/register/isEmailTaken?' + new URLSearchParams({"email": email}), {
            method: 'GET',
        });
        if (!response.ok) {
            // Something went wrong so assume it's taken
            return true;
        }
        const data = await response.json();
        return data.taken;
    } catch (error) {
        console.error('Error checking email:', error);
        return true;
    }
};

const handleTaken = (taken, targetElementID) => {
    if (taken === true) {
        const tooltipContents = `This ${targetElementID === 'emailStatus' ? 'email' : 'username'} is already taken`;
        document.getElementById(targetElementID).innerHTML = `<i data-bs-toggle="tooltip" class="bi bi-slash-circle icon-error text-danger"></i>`;
        document.getElementById(targetElementID).setAttribute("data-bs-title", tooltipContents);
        new bootstrap.Tooltip(document.getElementById(targetElementID).querySelector('[data-bs-toggle="tooltip"]'));
    } else {
        document.getElementById(targetElementID).innerHTML = '<i class="bi bi-check-circle-fill icon-success text-success"></i>';
    }
};

const handleEmailTaken = (taken) => {
    handleTaken(taken, 'emailStatus');
};

const handleUsernameTaken = (taken) => {
    handleTaken(taken, 'usernameStatus');
};

const setSpinner = (targetElementID) => {
    document.getElementById(targetElementID).innerHTML = '<div class="spinner-border" role="status"></div>';
};

document.addEventListener('DOMContentLoaded', function () {
    // Disable submit button by default
    document.getElementById("submitRegistrationForm").disabled = true;

    const carousel = document.getElementById('registrationCarousel');
    const totalSlides = carousel.querySelectorAll('.carousel-item').length;

    carousel.addEventListener('slid.bs.carousel', function () {
        const activeIndex = [...carousel.querySelectorAll('.carousel-item')].indexOf(
            carousel.querySelector('.carousel-item.active')
        );

        if (activeIndex === totalSlides - 2) {
            document.getElementById('step3Next').disabled = true;

            setSpinner('emailStatus');
            setSpinner('usernameStatus');

            Promise.all([
                isEmailTaken(document.getElementById('email').value),
                isUsernameTaken(document.getElementById('username').value)
            ]).then(([emailTaken, usernameTaken]) => {
                if (emailTaken === false && usernameTaken === false) {
                    document.getElementById('step3Next').disabled = false;
                } else {
                    document.getElementById('step3Next').disabled = true;
                }
                handleEmailTaken(emailTaken);
                handleUsernameTaken(usernameTaken);
            });
        }
    });
});

const submitForm = async (event) => {
    event.preventDefault();
    const data = new FormData();
    data.set("username", document.getElementById("username").value);
    data.set("email", document.getElementById("email").value);
    data.set("firstName", document.getElementById("firstName").value);
    data.set("lastName", document.getElementById("lastName").value);
    data.set("password", document.getElementById("password").value);

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            body: data
        });

        if (response.ok) {
            Swal.fire({
                title: 'Registration successful',
                icon: 'success',
                confirmButtonText: 'Got It',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
            }).then(() => {
                window.location.href = '/login';
            });
        } else {
            Swal.fire({
                title: 'Registration failed',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        console.error('Error during registration:', error);
        Swal.fire({
            title: 'An error occurred during registration',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
};

const validateOTP = async (event) => {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const code = formData.get('2faCode').replace(/\s+/g, '');

    try {
        const response = await fetch('/api/register/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({otp: code})
        });

        const data = await response.json();
        if (data.valid) {
            Swal.fire({
                title: 'OTP Verified',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'success',
                confirmButtonText: 'Got It'
            });
            document.getElementById('submitRegistrationForm').disabled = false;
        } else {
            Swal.fire({
                title: 'Invalid OTP',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
                confirmButtonText: 'Got It'
            });
            document.getElementById('submitRegistrationForm').disabled = true;
        }
    } catch (error) {
        console.error('Error during OTP verification:', error);
        Swal.fire({
            title: 'An error occurred during OTP verification',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});

