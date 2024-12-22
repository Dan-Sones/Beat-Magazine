<div class="carousel-item">
    <h3 class="mb-4 text-center">Step 4: Setup 2FA</h3>
    <div class="d-flex justify-content-center">
        <?php if (isset($qrCodeUrl)) : ?>
            <div class="col-12 pb-3">
                <div class="row justify-content-center">
                    <img class="img-fluid" id="qrCode" src="<?php echo $qrCodeUrl ?>" alt="QR Code">
                    <button class="btn btn-primary w-50 mb-2" id="copyButton" style="display: none;"
                            onclick="copySecret()">
                        Copy Secret
                    </button>
                </div>
                <div class="row justify-content-center">
                    <p id="qrCodeText">Scan the QR code above with your authenticator app</p>
                    <p id="copyText" class="text-center" style="display: none;">Copy the Code and paste it into
                        your authenticator
                        app</p>
                </div>
                <form onsubmit="validateOTP(event)">
                    <div class="mb-3">
                        <label for="2faCode" class="form-label">Enter the code from your authenticator app</label>
                        <input type="text" class="form-control" id="2faCode" name="2faCode" placeholder="Enter code"
                               required>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary" type="submit">Confirm Code</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
    <div class="d-flex justify-content-center">
        <button class="btn btn-secondary prev-btn me-2" type="button" data-bs-target="#registrationCarousel"
                data-bs-slide="prev">Back
        </button>
        <button class="btn btn-success" type="submit" id="submitRegistrationForm" onclick="submitForm(event)">Submit
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (isMobileDevice()) {
            document.getElementById('qrCode').style.display = 'none';
            document.getElementById('qrCodeText').style.display = 'none';
            document.getElementById('copyButton').style.display = 'block';
            document.getElementById('copyText').style.display = 'block';
        }
    });

    const isMobileDevice = () => {
        return /Mobi|Android/i.test(navigator.userAgent);
    };

    const copySecret = () => {
        const qrCodeUrl = "<?php echo $google2faSecret ?>";
        navigator.clipboard.writeText(qrCodeUrl).then(() => {
            alert('QR Code URL copied to clipboard');
        }).catch(err => {
            console.error('Failed to copy QR Code URL: ', err);
        });
    };
</script>