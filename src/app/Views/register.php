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
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-primary next-btn" type="button"
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
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-secondary prev-btn" type="button"
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
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-secondary prev-btn" type="button"
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