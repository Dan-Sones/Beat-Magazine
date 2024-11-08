<?php include 'includes/header.php'; ?>

    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="album-container shadow-sm bg-body-secondary">

                        <?php if (isset($album) && $album): ?>

                            <div class="row album-content">
                                <div class="col-12 col-lg-4 order-1 order-lg-1 align-content-center">
                                    <img src="<?= htmlspecialchars($album->albumArt) ?>" class="img-fluid shadow-sm"
                                         alt="Responsive Image">
                                </div>

                                <div class="album-info col-12 col-lg-8 ps-4 order-2 order-lg-2">
                                    <div class="row title-artist-section">
                                        <div class="row">
                                            <h2><?= $album->albumName ?> </h2>
                                        </div>
                                        <div class="row">
                                            <h5><?= $album->artistName ?></h5>
                                        </div>
                                    </div>
                                    <div class="row info d-flex align-items-center">
                                        <p><strong>Release Date:</strong> 2021</p>
                                        <p><strong>Genre</strong>: Pop</p>
                                        <p><strong>Label:</strong> Atlantic Records</p>
                                    </div>
                                    <div class="row d-flex align-items-center">
                                        <div class="col-6 d-flex align-content-center-center">
                                            <p><strong>User Score:</strong> 5/5</p>
                                        </div>
                                        <div class="col-6 d-flex align-content-center">
                                            <p><strong>Journalist Score:</strong> 100/100</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="container mt-3">
                                <!-- Buttons -->
                                <div class="text-center mb-3">
                                    <button id="tracklistButton" class="btn btn-primary">Tracklist</button>
                                    <button id="reviewButton" class="btn btn-secondary">Reviews</button>
                                </div>
                                <!-- Content to Toggle -->
                                <ul id="tracklist" class="mt-3" style="display: none;">
                                    <li>Track 1</li>
                                    <li>Track 2</li>
                                    <li>Track 3</li>
                                </ul>

                                <p id="review" class="mt-3" style="display: none;">
                                    This is a review displayed when the second button is clicked.
                                </p>
                            </div>

                            <script>

                                const handleShowTracklist = () => {
                                    document.getElementById("tracklist").style.display = "block";
                                    document.getElementById("review").style.display = "none";

                                    document.getElementById("tracklistButton").classList.remove("btn-secondary");
                                    document.getElementById("tracklistButton").classList.add("btn-primary");

                                    document.getElementById("reviewButton").classList.remove("btn-primary");
                                    document.getElementById("reviewButton").classList.add("btn-secondary");
                                }

                                const handleShowReviews = () => {
                                    document.getElementById("tracklist").style.display = "none";
                                    document.getElementById("review").style.display = "block";

                                    document.getElementById("tracklistButton").classList.remove("btn-primary");
                                    document.getElementById("tracklistButton").classList.add("btn-secondary");

                                    document.getElementById("reviewButton").classList.remove("btn-secondary");
                                    document.getElementById("reviewButton").classList.add("btn-primary");
                                }

                                // On Load we want to see the tracklist!
                                document.addEventListener("DOMContentLoaded", function () {
                                    handleShowTracklist();
                                });

                                document.getElementById("tracklistButton").addEventListener("click", handleShowTracklist);

                                document.getElementById("reviewButton").addEventListener("click", handleShowReviews);
                            </script>

                        <?php else: ?>
                            <p>No albums available.</p>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>

    </main>


<?php include 'includes/footer.php'; ?>