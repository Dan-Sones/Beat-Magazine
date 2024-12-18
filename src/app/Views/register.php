<?php include 'includes/header.php'; ?>

    <main class="register-wrapper d-flex justify-content-center align-items-center" role="main">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 col-sm-6">
                    <div id="registrationCarousel" class="carousel slide" data-bs-interval="false"
                         aria-label="Registration Steps">
                        <div class="carousel-inner">
                            <?php include PRIVATE_PATH . '/src/app/components/registration/step1.php'; ?>
                            <?php include PRIVATE_PATH . '/src/app/components/registration/step2.php'; ?>
                            <?php include PRIVATE_PATH . '/src/app/components/registration/step3.php'; ?>
                            <?php include PRIVATE_PATH . '/src/app/components/registration/step4.php'; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#registrationCarousel"
                                data-bs-slide="prev" aria-label="Previous">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#registrationCarousel"
                                data-bs-slide="next" aria-label="Next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="/js/register.js"></script>

<?php include 'includes/footer.php'; ?>