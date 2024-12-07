<?php include 'includes/header.php'; ?>

    <main class="register-wrapper d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10 col-md-8 col-lg-6 col-sm-6">
                    <h2 class="mb-4 text-center">Login</h2>
                    <form id="loginForm" onsubmit="submitLoginForm(event)">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="text" class="form-control" id="email"
                                   placeholder="Enter username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password"
                                   placeholder="Enter password" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success" id="submitLogin" type="submit">Submit</button>
                        </div>
                    </form>

                    <form id="otpForm" class="d-none" onsubmit="submitOTPForm(event)">
                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <input type="text" class="form-control" id="otp" name="otp"
                                   placeholder="Enter OTP" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success" id="submitOTP" type="submit">Submit</button>
                        </div>
                    </form>

                    <script>

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


                    </script>


                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </main>

<?php include 'includes/footer.php'; ?>