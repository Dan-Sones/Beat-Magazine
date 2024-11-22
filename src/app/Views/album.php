<?php include 'includes/header.php'; ?>

    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="album-container shadow-sm bg-body-secondary">

                        <?php if (isset($album) && $album): ?>

                        <div class="row album-content">
                            <div class="col-12 col-lg-4 order-1 order-lg-1 align-content-center">
                                <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>"
                                     class="img-fluid shadow-sm"
                                     alt="Responsive Image">
                            </div>

                            <div class="album-info col-12 col-lg-8 ps-4 order-2 order-lg-2">
                                <div class="row title-artist-section">
                                    <div class="row">
                                        <h2><?= $album->getAlbumName() ?> </h2>
                                    </div>
                                    <div class="row">
                                        <h5><?= $album->getArtistName() ?></h5>
                                    </div>
                                </div>
                                <div class="row info d-flex align-items-center">
                                    <p><strong>Release Date:</strong> <?= $album->getReleaseDate() ?></p>
                                    <p><strong>Genre</strong>: <?= $album->getGenre() ?></p>
                                    <p><strong>Label:</strong> <?= $album->getLabel() ?></p>
                                </div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-6 d-flex align-content-center-center">
                                        <p><strong>Average User
                                                Rating:</strong> <?= $album->getAverageUserRating() ?></p>
                                    </div>
                                    <div class="col-6 d-flex align-content-center">
                                        <p><strong>Journalist Rating:</strong> <?= $album->getJournalistRating() ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="container mt-3 pt-2">
                        <div class="card p-4 shadow-sm">
                            <div class="row align-items-center">
                                <!-- Profile Picture and Journalist Info -->
                                <div class="col-md-3 d-flex flex-column align-items-center">
                                    <img src="images/journalist4.jpg" class="img-fluid rounded-circle p-2"
                                         style="width: 130px; height: 130px; object-fit: cover">
                                    <h5 class="mt-2">Amy Jordan</h5>
                                    <p class="text-muted text-center">
                                        Senior music journalist at <strong>BeatMagazine</strong> with
                                        over a decade of experience covering electronic and experimental
                                        music.
                                    </p>
                                </div>

                                <!-- Beat Magazine Score -->
                                <div class="col-md-3 text-center">
                                    <h2>Rating:</h2>
                                    <h2>8/10</h2>
                                </div>

                                <!-- Review Text -->
                                <div class="col-md-6">
                                    <p>
                                        Jai Paul’s Bait Ones stands as a cultural phenomenon—an album born from
                                        an unauthorized leak yet celebrated as a genre-defying masterpiece.
                                        Blending R&B, funk, electronica, and experimental pop, Paul’s music
                                        invites listeners into a world that’s both raw and meticulously crafted.
                                        Tracks like “BTSTU” and “Jasmine” showcase his signature fusion of
                                        vulnerability and swagger, offering poignant lyrics over lush,
                                        unpredictable arrangements. With shimmering Bollywood strings, glitchy
                                        beats, and fractured song structures, Bait Ones feels like a sonic
                                        diary—intimate, chaotic, and breathtakingly innovative.
                                    </p>
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
                        <div id="tracklist" class="mt-3" style="display: none;">
                            <ul class="list-group">


                                <?php if (sizeof($album->getSongs()) < 1): ?>
                                    <p>No tracks found.</p>
                                <?php else: ?>

                                <?php foreach ($album->getSongs() as $song): ?>
                                    <!-- Repeat for each track -->
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="track-info d-flex align-items-center">
                                            <button class="btn btn-sm play-button me-3">
                                                <i class="bi bi-play-circle"></i>
                                            </button>
                                            <div>
                                                <p class="mb-0"><?= $song->getName() ?></p></div>
                                        </div>
                                        <span class="text-muted"><?= $song->getLength() ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>


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