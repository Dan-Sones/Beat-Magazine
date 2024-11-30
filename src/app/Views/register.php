<?php include 'includes/header.php'; ?>

    <main class="register-wrapper d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-xs-10">
                    <div id="registrationCarousel" class="carousel slide" data-bs-interval="false">
                        <div class="carousel-inner">
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
                                    <div class="d-flex justify-content-center">
                                        <button class=" btn btn-primary next-btn me-2
                                    " type="button"
                                                data-bs-target="#registrationCarousel" data-bs-slide="next">
                                            Next
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="carousel-item">
                                <h3 class="mb-4 text-center">Step 2: Personal Details</h3>
                                <form id="step2Form">
                                    <div class="mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName"
                                               placeholder="Enter first name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName"
                                               placeholder="Enter last name" required>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-secondary prev-btn me-2" type="button"
                                                data-bs-target="#registrationCarousel" data-bs-slide="prev">
                                            Back
                                        </button>
                                        <button class="btn btn-primary next-btn" type="button"
                                                data-bs-target="#registrationCarousel" data-bs-slide="next">
                                            Next
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="carousel-item">
                                <h3 class="mb-4 text-center">Step 3: Confirm Details</h3>
                                <form id="step3Form">
                                    <p class="text-center">Please review your details and click submit.</p>

                                    <div class="confirm-details">
                                        <div class="container-fluid">

                                            <div class="row justify-content-center">
                                                <div class="col-4">
                                                    <p><strong>Username:</strong></p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="confirmUsername"></p></div>
                                                <div id="usernameStatus"
                                                     class="col-4 d-flex justify-content-center align-items-center">
                                                    <div class="spinner-border" role="status">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-4">
                                                    <p><strong>Email Address:</strong></p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="confirmEmail"></p></div>
                                                <div id="emailStatus"
                                                     class="col-4 d-flex justify-content-center align-items-center">
                                                    <div class="spinner-border" role="status">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-4">
                                                    <p><strong>First Name:</strong></p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="confirmFirstName"></p></div>
                                                <div class="col-4">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p><strong>Last Name:</strong></p>
                                                </div>
                                                <div class="col-4">
                                                    <p id="confirmLastName"></p></div>
                                                <div class="col-4">

                                                </div>
                                            </div>


                                        </div>


                                        <script>
                                            // Each time the next button is clicked, update the confirm details (We have multiple next buttons)
                                            document.querySelectorAll('.next-btn[data-bs-slide="next"]').forEach(function (button) {
                                                button.addEventListener('click', function () {
                                                    document.getElementById('confirmUsername').textContent = document.getElementById('username').value;
                                                    document.getElementById('confirmEmail').textContent = document.getElementById('email').value;
                                                    document.getElementById('confirmFirstName').textContent = document.getElementById('firstName').value;
                                                    document.getElementById('confirmLastName').textContent = document.getElementById('lastName').value;
                                                });
                                            });
                                        </script>

                                        <script>


                                            // TODO: Check to see username, password, email meet requirements

                                            const isUsernameTaken = async (username) => {
                                                return await fetch('/api/register/isUsernameTaken?' + new URLSearchParams({
                                                    "username": username
                                                }), {
                                                    method: 'GET',
                                                }).then(response => {
                                                    if (!response.ok) {
                                                        // Do stuff
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
                                                        // Do stuff
                                                    }
                                                    return response.json();
                                                }).then(data => {
                                                    return data.taken;
                                                });
                                            };

                                            const handleTaken = async (taken, targetElementID) => {
                                                    console.log('handleTaken', taken, targetElementID);
                                                    if (taken === true) {
                                                        const tooltipContents = `This ${targetElementID === 'emailStatus' ? 'email' : 'username'} is already taken`;
                                                        document.getElementById(targetElementID).innerHTML = `<i data-bs-toggle="tooltip" class="bi bi-slash-circle icon-error"></i>`
                                                        document.getElementById(targetElementID).setAttribute("title", tooltipContents);
                                                        document.querySelector('button[type="submit"]').disabled = true;
                                                    } else {
                                                        document.getElementById(targetElementID).innerHTML = '<i class="bi bi-check-circle-fill icon-success"></i>';
                                                        document.querySelector('button[type="submit"]').disabled = false;
                                                    }
                                                }
                                            ;

                                            const handleEmailTaken = async (taken) => {
                                                handleTaken(taken, 'emailStatus');
                                            };

                                            const handleUsernameTaken = async (taken) => {
                                                handleTaken(taken, 'usernameStatus');
                                            };


                                            const setSpinner = (targetElementID) => {
                                                document.getElementById(targetElementID).innerHTML = '<div class="spinner-border" role="status"></div>';
                                            };

                                            document.addEventListener('DOMContentLoaded', function () {

                                                //Disable submit button by default
                                                document.querySelector('button[type="submit"]').disabled = true;

                                                const carousel = document.getElementById('registrationCarousel');
                                                const totalSlides = carousel.querySelectorAll('.carousel-item').length;

                                                carousel.addEventListener('slid.bs.carousel', function (event) {
                                                    const activeIndex = [...carousel.querySelectorAll('.carousel-item')].indexOf(
                                                        carousel.querySelector('.carousel-item.active')
                                                    );


                                                    if (activeIndex === totalSlides - 1) {

                                                        document.querySelector('button[type="submit"]').disabled = true;

                                                        setSpinner('emailStatus');
                                                        setSpinner('usernameStatus');

                                                        Promise.all([
                                                            isEmailTaken(document.getElementById('email').value),
                                                            isUsernameTaken(document.getElementById('username').value)
                                                        ]).then(([emailTaken, usernameTaken]) => {
                                                            handleEmailTaken(emailTaken);
                                                            handleUsernameTaken(usernameTaken);
                                                        });
                                                    }


                                                });
                                            });


                                        </script>

                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-secondary prev-btn me-2" type="button"
                                                data-bs-target="#registrationCarousel" data-bs-slide="prev">
                                            Back
                                        </button>
                                        <button class="btn btn-success" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </main>

<?php include 'includes/footer.php'; ?>