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

<script src="/js/registration/step2.js"></script>