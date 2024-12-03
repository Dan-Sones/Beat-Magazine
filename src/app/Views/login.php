<?php include 'includes/header.php'; ?>

    <main class="register-wrapper d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-10 col-md-8 col-lg-6 col-sm-6">
                    <h2 class="mb-4 text-center">Login</h2>
                    <form id="loginForm">
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
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </form>

                    <script>
                        // TODO: Passwording checking stuff
                        const form = document.getElementById('loginForm');

                        const submitForm = async (event) => {
                            event.preventDefault();
                            const data = new FormData(form);
                            return await fetch('/api/login', {
                                method: 'POST',
                                body: data
                            }).then(response => {
                                if (response.status === 200) {
                                    window.location.href = '/albums';
                                } else {
                                    alert('Invalid credentials');
                                }
                            )
                            }


                    </script>


                </div>
            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </main>

<?php include 'includes/footer.php'; ?>