<?php include 'includes/header.php'; ?>

    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card shadow p-4">
                        <h2 class="mb-4 text-center">Reset Password</h2>

                        <p class="fw-bold">Passwords Must:</p>
                        <ul class="list-unstyled mb-4" id="password-status">
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
                                <div class="ps-5" id="confirmPunctuationStatus">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Be greater than 8 characters:</span>
                                <div id="confirmLengthStatus">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <span>Passwords Match:</span>
                                <div id="passwordsMatchStatus">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </li>
                        </ul>

                        <form onsubmit="submitResetPassword(event)">
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control" name="newPassword" id="newPassword"
                                       placeholder="Enter new password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="confirmNewPassword"
                                       id="confirmNewPassword"
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

        <script src="/js/password-reset.js"></script>

    </main>

<?php include 'includes/footer.php'; ?>