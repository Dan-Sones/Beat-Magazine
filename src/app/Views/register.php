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
                     
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="/js/register.js"></script>

<?php include 'includes/footer.php'; ?>