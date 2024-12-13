<?php include 'includes/header.php'; ?>

    <main class="register-wrapper d-flex justify-content-center align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-ce
            nter">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card shadow p-4">
                        <h2 class="mb-4 text-center">Reset Password</h2>

                        <p class="fw-bold">Passwords Must:</p>
                        <ul class="list-unstyled mb-4A" id="password-status">
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Contain at least 3 numbers:</span>
                                <div id="confirmNumbersStatus">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Contain at least 1 capital letter:</span>
                                <div id="confirmCapitalStatus">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Contain at least 1 piece of punctuation:</span>
                                <div id="confirmPunctuationStatus">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Be greater than 8 characters:</span>
                                <div id="confirmLengthStatus">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </li>
                        </ul>

                        <form onsubmit="submitResetPassword(event)">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" id="new_password"
                                       placeholder="Enter new password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirm_password"
                                       id="confirm_password"
                                       placeholder="Confirm new password" required>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-success w-100" id="submit" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <script>


            // on page load disable the submit button
            document.getElementById('submit').disabled = true;

            const checkPassword = () => {
                const password = document.getElementById('new_password').value;
                console.log("running")

                // Check to see if the passsword:
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

                //Disable form submission if the password does not meet the criteria
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

            document.getElementById('new_password').addEventListener('blur', checkPassword)


            document.getElementById('new_password').addEventListener('blur', () => {
                document.getElementById('new_password').classList.remove('is-invalid')
            })


            const submitResetPassword = async (event) => {

                event.preventDefault();

                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;

                if (newPassword !== confirmPassword) {
                    document.getElementById('new_password').classList.add('is-invalid')
                    document.getElementById('confirm_password').classList.add('is-invalid')
                    alert('Passwords do not match');
                    return;
                }


                // We technically don't need to check this again, but it's good practice

                // Check to see if the passsword:
                // 1. Contains at least 3 numbers
                // 2. Contains at least 1 capital letter
                // 3. Contains at least 1 piece of punctuation
                // 4. Is greater than 8 characters
                if (!newPassword.match(/^(?=.*[A-Z])(?=.*[0-9]{3,})(?=.*[!@#$%^&*()_+])[a-zA-Z0-9!@#$%^&*()_+]{8,}$/)) {
                    // set the error style
                    document.getElementById('new_password').classList.add('is-invalid')
                    alert('Password does not meet the criteria');
                    return;
                }

                document.getElementById('new_password').classList.remove('is-invalid')


                await
                    fetch('/api/password-reset', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            new_password: newPassword,
                            token: new URLSearchParams(window.location.search).get('token')
                        })
                    }).then(response => {
                        if (response.status === 200) {
                            alert('Password reset successfully');
                            window.location.href = '/login';
                        } else {
                            alert('Unable to reset password');
                        }
                    });

            }


        </script>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </main>

<?php include 'includes/footer.php'; ?>