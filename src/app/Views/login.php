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
                            <a class="disabled" id="passwordResetLink" onclick="handleRequestPasswordReset()">Forgot
                                Password?</a>
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
                </div>
            </div>

        </div>

        <script src="/js/login.js"></script>

    </main>

<?php include 'includes/footer.php'; ?>