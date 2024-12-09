<?php include 'includes/loadHeader.php'; ?>

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                    <div class="profile-container shadow d-flex justify-content-center pb-3 pt-3">

                        <div class="content justify-content-center">
                            <div class="row">
                                <div class="col-12 justify-content-center d-flex">
                                    <!--TODO: Allow editing if logged in-->
                                    <img src="https://preview.redd.it/fan-theory-is-philip-j-fry-the-messiah-v0-uzlu3cobnpea1.jpg?width=3200&format=pjpg&auto=webp&s=19cd72a211cf9fe16378153333e914643a828ed2"
                                         class="img-fluid rounded-circle p-2"
                                         style="width: 250px; height: 250px; object-fit: cover"
                                         alt="Profile Picture"/>

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <div class="userInfo pt-2">
                                        <!--TODO:Allow editing if logged in-->
                                        <h1 class="text-center">Philip J. Fry</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 row justify-content-center">
                                <div class="col-4 text-center">
                                    <h5>Total Likes</h5>
                                </div>
                                <div class="col-4 text-center">
                                    <h5>Review Count</h5>
                                </div>
                                <div class="col-4 text-center">
                                    <h5>User Since</h5>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-4 text-center">
                                    <p>21</p>
                                </div>
                                <div class="col-4 text-center">
                                    <p>15</p>
                                </div>
                                <div class="col-4 text-center">
                                    <p>21/01/02</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="reviews-container container d-flex justify-content-center pb-3 pt-3">
                        <div class="container">
                            <div class="row gx-5">
                                <div class="col-12">

                                    <h2 class="text-center mb-5 mt-2">Reviews</h2>
                                </div>

                                <div class="col-12">
                                    <?php for ($i = 0; $i < 10; $i++) { ?>
                                        <div class="row gx-5 d-flex align-items-center pb-5"
                                             data-aos="fade-<?php echo $i % 2 == 0 ? 'right' : 'left'; ?>"
                                             data-aos-duration="3000">
                                            <div class="col-md-6 col-12 order-0 order-md-<?php echo $i % 2 == 0 ? '1' : '0'; ?> justify-content-center">
                                                <div class="album-art pb-sm-3">
                                                    <img src="/images/100%25-Electronica.jpg"
                                                         class="img-fluid shadow album-art" alt="Album Art"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 order-1 order-md-<?php echo $i % 2 == 0 ? '0' : '1'; ?> justify-content-center">
                                                <div class="review card">
                                                    <div class="card-header">
                                                        <h4>100% Electronica</h4>
                                                        <h5>George Clanton</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>100% Electronica is not just an album; it’s a fully-realized
                                                            experience. George Clanton has created a work that feels
                                                            timeless and forward-thinking, perfectly capturing the
                                                            emotional resonance of nostalgia without becoming trapped in
                                                            it. Whether you’re a vaporwave enthusiast or new to the
                                                            genre, this album is a must-listen for anyone who craves
                                                            music that stirs the soul while making your head bob.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                </div>


                            </div>
                        </div>
                    </div>


    </main>


<?php include 'includes/footer.php'; ?>