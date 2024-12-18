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