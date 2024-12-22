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
    return await fetch('/api/register/isUsernameTaken?' + new URLSearchParams({
        "username": username
    }), {
        method: 'GET',
    }).then(response => {
        if (!response.ok) {
            // Something went wrong so assume it's taken
            return true;
        }
        return response.json();
    }).then(data => {
        return data.taken;
    });
};

const isEmailTaken = async (email) => {
    return await fetch('/api/register/isEmailTaken?' + new URLSearchParams({
        "email": email
    }), {
        method: 'GET',
    }).then(response => {
        if (!response.ok) {
            // Something went wrong so assume it's taken
            return true;
        }
        return response.json();
    }).then(data => {
        return data.taken;
    });
};


const handleTaken = (taken, targetElementID) => {
        if (taken === true) {
            const tooltipContents = `This ${targetElementID === 'emailStatus' ? 'email' : 'username'} is already taken`;
            document.getElementById(targetElementID).innerHTML = `<i data-bs-toggle="tooltip" class="bi bi-slash-circle icon-error"></i>`
            document.getElementById(targetElementID).setAttribute("title", tooltipContents);
        } else {
            document.getElementById(targetElementID).innerHTML = '<i class="bi bi-check-circle-fill icon-success"></i>';
        }
    }
;

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

    //Disable submit button by default
    document.getElementById("submitRegistrationForm").disabled = true;

    const carousel = document.getElementById('registrationCarousel');
    const totalSlides = carousel.querySelectorAll('.carousel-item').length;

    carousel.addEventListener('slid.bs.carousel', function (event) {
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
    const response = await fetch('/api/register', {
        method: 'POST',
        content_type: 'form-data',
        body: data
    });
    if (response.ok) {
        // Redirect to login page
        alert('Registration successful');
        window.location.href = '/login';
    } else {
        alert('Registration failed');
    }
};

const validateOTP = async (event) => {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const code = formData.get('2faCode');

    return await fetch('/api/register/verify-otp?', {
        method: 'POST',
        content_type: 'application/json',
        body: JSON.stringify({otp: code})
    }).then(response => {
        if (!response.ok) {
        }
        return response.json();
    }).then(data => {
        if (data.valid) {
            document.getElementById('submitRegistrationForm').disabled = false;
        } else {
            alert('Invalid code');
            document.getElementById('submitRegistrationForm').disabled = true;
        }
    });
};