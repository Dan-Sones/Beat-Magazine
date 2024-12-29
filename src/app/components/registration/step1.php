<div class="carousel-item active">
    <h3 class="mb-4 text-center">Step 1: Basic Information</h3>
    <form id="step1Form">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username"
                   placeholder="Enter username" data-bs-toggle="tooltip" data-bs-title="" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email"
                   placeholder="Enter email" data-bs-toggle="tooltip" data-bs-title="" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password"
                   placeholder="Enter password" data-bs-toggle="tooltip" data-bs-title="" required>
        </div>

        <div class="card p-4 shadow-sm mb-2">
            <h5 class="text-center pb-2">Password Requirements</h5>
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
            </ul>
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

<script src="/js/registration/step1.js">
</script>