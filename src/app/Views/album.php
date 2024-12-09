<?php include 'includes/header.php'; ?>

    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
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
                        <div class="card p-4 shadow-sm review-card">
                            <?php if (isset($journalistReview) && $journalistReview): ?>

                            <div class="row align-items-center">
                                <div class="col-md-3 d-flex flex-column align-items-center">
                                    <img src="<?= $journalistReview->getJournalist()->getProfilePicture() ?>"
                                         class="img-fluid rounded-circle p-2"
                                         style="width: 130px; height: 130px; object-fit: cover">
                                    <h5 class="mt-2"><?= $journalistReview->getJournalist()->getName() ?></h5>
                                    <p class="text-muted text-center">
                                        <?= $journalistReview->getJournalist()->getBio() ?>
                                    </p>
                                </div>

                                <div class="col-md-3 text-center p-3">
                                    <h2>Rating:</h2>
                                    <h2><?= $journalistReview->getRating() ?>/10</h2>
                                </div>

                                <div class="col-md-6">
                                    <p class="review-abstract mb-0">
                                        <?= $journalistReview->getAbstract() ?>
                                        <button class="btn btn-link read-more-btn p-0" type="button">Read More
                                        </button>
                                    </p>
                                </div>
                            </div>

                            <div class="row align-items-center review-full-container"
                                 style="overflow: hidden; height: 0;">
                                <div class="col-md-12">
                                    <hr/>
                                    <div class="review-full container d-flex justify-content-center"
                                    ">
                                    <div class="col-xl-8 col-lg-11 col-md-12 col-sm-12">
                                        <?= $journalistReview->getReview() ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <?php else: ?>
                            <p>There is currently not a review present for this album</p>
                        <?php endif; ?>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const reviewCard = document.querySelector('.review-card');
                        const readMoreBtn = reviewCard.querySelector('.read-more-btn');
                        const fullReviewContainer = reviewCard.querySelector('.review-full-container');

                        const animateHeight = (element, action) => {
                            if (action === 'expand') {
                                const fullHeight = element.scrollHeight + 'px';
                                element.style.height = fullHeight;

                                element.addEventListener('transitionend', () => {
                                    element.style.height = 'auto';
                                }, {once: true});
                            } else if (action === 'collapse') {
                                const currentHeight = element.scrollHeight + 'px';
                                element.style.height = currentHeight;

                                element.offsetHeight;
                                element.style.height = '0';
                            }
                        };

                        readMoreBtn.addEventListener('click', () => {
                            if (fullReviewContainer.style.height === '0px' || fullReviewContainer.style.height === '') {
                                animateHeight(fullReviewContainer, 'expand');
                                readMoreBtn.textContent = 'Read Less';
                            } else {
                                animateHeight(fullReviewContainer, 'collapse');
                                readMoreBtn.textContent = 'Read More';
                            }
                        });
                    });
                </script>


                <div class="container mt-3 mb-5">
                    <div class="text-center mb-3">
                        <button id="tracklistButton" class="btn btn-primary">Tracklist</button>
                        <button id="reviewButton" class="btn btn-secondary">Reviews</button>
                    </div>
                    <div id="tracklist" class="mt-3" style="display: none;">
                        <ul class="list-group">
                            <?php if (sizeof($album->getSongs()) < 1): ?>
                                <p>No tracks found.</p>
                            <?php else: ?>

                            <?php foreach ($album->getSongs() as $song): ?>
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


                    <div class="container" id="user-reviews-container" style="display: none">
                        <div class="row gy-3">
                            <?php for ($i = 0; $i < 10; $i++) { ?>
                                <div class="col-12">
                                    <div class="card shadow-sm">
                                        <div class="container p-3 ps-4">
                                            <div class="row">
                                                <!--                                                Mobile layout-->
                                                <div class="col-12 d-flex align-items-center d-md-none order-1 pb-3">
                                                    <img src="https://preview.redd.it/fan-theory-is-philip-j-fry-the-messiah-v0-uzlu3cobnpea1.jpg?width=3200&format=pjpg&auto=webp&s=19cd72a211cf9fe16378153333e914643a828ed2"
                                                         class="img-fluid rounded-circle"
                                                         style="width: 60px; height: 60px; object-fit: cover">
                                                    <div class="ms-2">
                                                        <a href="/albums" class="text-center pt-1">Phillip J Fry</a>
                                                        <p class="mb-0" style="font-size: 0.8rem;">7/10</p>
                                                    </div>
                                                </div>
                                                <!--                                                desktop layout-->
                                                <div class="col-12 col-md-2 d-none d-md-flex flex-column align-items-center order-md-1">
                                                    <img src="https://preview.redd.it/fan-theory-is-philip-j-fry-the-messiah-v0-uzlu3cobnpea1.jpg?width=3200&format=pjpg&auto=webp&s=19cd72a211cf9fe16378153333e914643a828ed2"
                                                         class="img-fluid rounded-circle"
                                                         style="width: 120px; height: 120px; object-fit: cover">
                                                    <a href="/albums" class="text-center pt-3">Phillip J Fry</a>
                                                </div>
                                                <div class="col-md-1 align-items-center justify-content-center d-none d-md-flex order-2 order-md-2">
                                                    <h3>7/10</h3>
                                                </div>
                                                <div class="col-12 col-md-9 order-3 order-md-3 d-flex justify-content-center align-items-center mb-0">
                                                    <p class="mb-0">100% Electronica is not just an album; it’s a
                                                        fully-realized
                                                        experience. George Clanton has created a work that feels
                                                        timeless and forward-thinking, perfectly capturing the emotional
                                                        resonance of nostalgia without becoming trapped in it. Whether
                                                        you’re a vaporwave enthusiast or new to the genre, this album is
                                                        a must-listen for anyone who craves music that stirs the soul
                                                        while making your head bob..</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <script>

                        const handleShowTracklist = () => {
                            document.getElementById("tracklist").style.display = "block";
                            document.getElementById("user-reviews-container").style.display = "none";

                            document.getElementById("tracklistButton").classList.remove("btn-secondary");
                            document.getElementById("tracklistButton").classList.add("btn-primary");

                            document.getElementById("reviewButton").classList.remove("btn-primary");
                            document.getElementById("reviewButton").classList.add("btn-secondary");
                        }

                        const handleShowReviews = () => {
                            document.getElementById("tracklist").style.display = "none";
                            document.getElementById("user-reviews-container").style.display = "block";

                            document.getElementById("tracklistButton").classList.remove("btn-primary");
                            document.getElementById("tracklistButton").classList.add("btn-secondary");

                            document.getElementById("reviewButton").classList.remove("btn-secondary");
                            document.getElementById("reviewButton").classList.add("btn-primary");
                        }

                        document.addEventListener("DOMContentLoaded", function () {
                            handleShowTracklist();
                        });

                        document.getElementById("tracklistButton").addEventListener("click", handleShowTracklist);

                        document.getElementById("reviewButton").addEventListener("click", handleShowReviews);
                    </script>

                    <?php else: ?>
                        <p>404: Album not Found</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </main>


<?php include 'includes/footer.php'; ?>