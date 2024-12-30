<?php include 'includes/header.php'; ?>

    <main class="register-wrapper d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10 col-md-8 col-lg-6 col-sm-6">
                    <h2 class="mb-4 text-center">Upgrade Account</h2>
                    <form id="loginForm" onsubmit="submitUpgradeForm(event)" role="form" aria-live="polite">
                        <p class="text-center">Are you sure you want to upgrade the account with the username
                            "<?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>" to a Journalist
                            Account?</p>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter password"
                                   required aria-label="Password">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success" id="submitLogin" type="submit" aria-label="Submit">Upgrade
                                Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="/js/upgrade.js"></script>
    </main>

<?php include 'includes/footer.php'; ?>