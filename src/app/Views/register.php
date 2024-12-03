<?php include 'includes/header.php'; ?>

    <main class="register-wrapper d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-sm-6">
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
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password"
                                               placeholder="Enter password" required>
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


                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-secondary prev-btn me-2" type="button"
                                                    data-bs-target="#registrationCarousel" data-bs-slide="prev">
                                                Back
                                            </button>
                                            <button class="btn btn-primary next-btn" type="button" id="step3Next"
                                                    data-bs-target="#registrationCarousel" data-bs-slide="next">
                                                Next
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="carousel-item">
                                <h3 class="mb-4 text-center">Step 4: Setup 2FA</h3>
                                <div class="d-flex justify-content-center">
                                    <?php if (isset($qrCodeUrl)) : ?>
                                        <div class="col-12">
                                            <div class="row justify-content-center">
                                                <img src="<?php echo $qrCodeUrl ?>"
                                                     alt="QR Code">
                                            </div>
                                            <div class="row justify-content-center">
                                                <p>Scan the QR code above with your authenticator app</p>
                                            </div>
                                            <form onsubmit="validateAuthenticatorCode(event)">
                                                <div class="mb-3">
                                                    <label for="2faCode" class="form-label">Enter the code from your
                                                        authenticator
                                                        app</label>
                                                    <input type="text" class="form-control" id="2faCode" name="2faCode"
                                                           placeholder="Enter code" required>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-primary" type="submit">Confirm Code</button>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-secondary prev-btn me-2" type="button"
                                            data-bs-target="#registrationCarousel" data-bs-slide="prev">
                                        Back
                                    </button>
                                    <button class="btn btn-success" type="submit" id="submitRegistrationForm"
                                            onclick="submitForm(event)">Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>


            const validateAuthenticatorCode = async (event) => {
                event.preventDefault();

                const form = event.target;
                const formData = new FormData(form);


                const code = formData.get('2faCode');

                console.log('Validating code');
                console.log(code);
                return await fetch('/api/register/check2faCode?' + new URLSearchParams({
                    "code": code
                }), {
                    method: 'GET',
                }).then(response => {
                    if (!response.ok) {
                        // Do stuff
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
                    if (taken === true) {
                        const tooltipContents = `This ${targetElementID === 'emailStatus' ? 'email' : 'username'} is already taken`;
                        document.getElementById(targetElementID).innerHTML = `<i data-bs-toggle="tooltip" class="bi bi-slash-circle icon-error"></i>`
                        document.getElementById(targetElementID).setAttribute("title", tooltipContents);
                    } else {
                        document.getElementById(targetElementID).innerHTML = '<i class="bi bi-check-circle-fill icon-success"></i>';
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
                document.getElementById("submitRegistrationForm").disabled = true;

                const carousel = document.getElementById('registrationCarousel');
                const totalSlides = carousel.querySelectorAll('.carousel-item').length;

                carousel.addEventListener('slid.bs.carousel', function (event) {
                    const activeIndex = [...carousel.querySelectorAll('.carousel-item')].indexOf(
                        carousel.querySelector('.carousel-item.active')
                    );


                    if (activeIndex === totalSlides - 2) {

                        // document.querySelector('button[type="submit"]').disabled = true;
                        document.getElementById('step3Next').disabled = true;

                        setSpinner('emailStatus');
                        setSpinner('usernameStatus');

                        Promise.all([
                            isEmailTaken(document.getElementById('email').value),
                            isUsernameTaken(document.getElementById('username').value)
                        ]).then(([emailTaken, usernameTaken]) => {

                            if (emailTaken === false && usernameTaken === false) {
                                // document.querySelector('button[type="submit"]').disabled = false;
                                document.getElementById('step3Next').disabled = false;
                            } else {
                                document.getElementById('step3Next').disabled = true;
                                // document.querySelector('button[type="submit"]').disabled = true;
                            }
                            handleEmailTaken(emailTaken);
                            handleUsernameTaken(usernameTaken);
                        });
                    }


                });
            });

            const submitForm = async (event) => {
                // Prevent form from submitting normally
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
                    window.location.href = '/login';
                } else {
                    alert('Registration failed');
                }
            };

        </script>

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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </main>

<?php include 'includes/footer.php'; ?>