<div class="carousel-item">
    <h3 class="mb-4 text-center">Step 4: Setup 2FA</h3>
    <div class="d-flex justify-content-center">
        <?php if (isset($qrCodeUrl)) : ?>
            <div class="col-12 pb-3">
                <div class="row justify-content-center">
                    <img class="img-fluid" src="<?php echo $qrCodeUrl ?>"
                         alt="QR Code">
                </div>
                <div class="row justify-content-center">
                    <p>Scan the QR code above with your authenticator app</p>
                </div>
                <form onsubmit="validateOTP(event)">
                    <div class="mb-3">
                        <label for="2faCode" class="form-label">Enter the code from your
                            authenticator
                            app</label>
                        <input type="text" class="form-control" id="2faCode" name="2faCode"
                               placeholder="Enter code" required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" type="submit">Confirm Code</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <div class="d-flex justify-content-center">
        <button class="btn btn-secondary prev-btn me-2" type="button"
                data-bs-target="#registrationCarousel" data-bs-slide="prev">
            Back
        </button>
        <button class="btn btn-success" type="submit" id="submitRegistrationForm"
                onclick="submitForm(event)">Submit
        </button>
    </div>
</div>