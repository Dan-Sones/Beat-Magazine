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
                            <div class="col-12">
                                <!--                        If the user is logged in-->
                                <div class="card shadow-sm">
                                    <form class="p-4 shadow-sm rounded" onsubmit="handleReviewSubmission(event)">
                                        <div class="mb-3">
                                            <label for="reviewRating" class="form-label">Rating</label>
                                            <select class="form-select" id="reviewRating">
                                                <option selected>Select a rating</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reviewText" class="form-label">Review</label>
                                            <textarea class="form-control" id="reviewText" rows="5"
                                                      placeholder="Write your review here"></textarea>
                                        </div>
                                        <div class="d-grid" id="submitReviewWrapper" data-toggle="tooltip">
                                            <button id="submitReview" type="submit"
                                                    class="btn btn-primary">Submit
                                                Review
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <script>

                                document.addEventListener('DOMContentLoaded', () => {
                                    const activeSession = <?= isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true ? 'true' : 'false' ?>;

                                    const submitReviewButton = document.getElementById('submitReview');
                                    const submitReviewWrapper = document.getElementById('submitReviewWrapper');

                                    if (!activeSession) {
                                        submitReviewButton.disabled = true;
                                        submitReviewWrapper.title = 'You must be logged in to submit a review';

                                    } else if (activeSession) {
                                        const leftReview = <?= isset($hasUserLeftReview) && $hasUserLeftReview ? 'true' : 'false' ?>;

                                        if (leftReview) {
                                            submitReviewButton.disabled = true;
                                            submitReviewWrapper.title = 'You have already left a review for this album';
                                        }

                                    }


                                });


                                // TODO: Check if the user has already submitted a review for this album before allowing them to submit another
                                // This should also be checked on the backend in the event the user manually removes the disabled attribute

                                const handleReviewSubmission = async (event) => {
                                    event.preventDefault();
                                    const rating = document.getElementById('reviewRating').value;
                                    const review = document.getElementById('reviewText').value;

                                    const albumId = <?= $album->getAlbumID() ?>;

                                    return await fetch(`/api/albums/${albumId}/reviews`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            rating: rating,
                                            review: review
                                        })
                                    }).then(response => {
                                        if (response.status === 201) {
                                            alert('Review submitted successfully');
                                            location.reload();
                                        } else {
                                            alert('An error occurred while submitting your review');
                                        }
                                    });
                                };


                            </script>


                            <?php if (isset($userReviews) && is_array($userReviews)): ?>
                                <?php foreach ($userReviews as $userReview): ?>
                                    <div class="col-12">
                                        <div class="card shadow-sm" id="userReview-<?= $userReview->getId() ?>">
                                            <div class="container p-3 ps-4">
                                                <div class="row">
                                                    <!--                                                Mobile layout-->
                                                    <div class="col-12 d-flex align-items-center d-md-none order-1 pb-3">
                                                        <img src="<?= $userReview->getUser()->getProfilePictureUri() ?>"
                                                             class="img-fluid rounded-circle"
                                                             style="width: 60px; height: 60px; object-fit: cover">
                                                        <div class="ms-2">
                                                            <a href="/albums"
                                                               class="text-center pt-1"><?= $userReview->getUser()->getUsername() ?></a>
                                                            <p class="mb-0"
                                                               style="font-size: 0.8rem;"><?= $userReview->getRating() ?>
                                                                /10</p>
                                                        </div>
                                                    </div>
                                                    <!--                                                desktop layout-->
                                                    <div class="col-12 col-md-3 d-none d-md-flex flex-column align-items-center order-md-1 d-flex justify-content-center">
                                                        <img src="<?= $userReview->getUser()->getProfilePictureUri() ?>"
                                                             class="img-fluid rounded-circle"
                                                             style="width: 120px; height: 120px; object-fit: cover">
                                                        <a href="/albums"
                                                           class="text-center pt-3"><?= $userReview->getUser()->getUsername() ?></a>
                                                    </div>
                                                    <div class="col-md-2 align-items-center justify-content-center d-none d-md-flex order-2 order-md-2">
                                                        <h3><?= $userReview->getRating() ?>/10</h3>
                                                    </div>
                                                    <div class="col-12 col-md-6 order-3 order-md-3 d-flex justify-content-center align-items-center mb-0">
                                                        <p class="mb-0"
                                                           id="userReviewText-<?= $userReview->getId() ?>"><?= $userReview->getReview() ?></p>
                                                        <form class="p-2 rounded w-100"
                                                              id="editUserReview-<?= $userReview->getId() ?>"
                                                              style="display: none"
                                                              onsubmit="handleReviewSubmission(event)">
                                                            <div class="mb-3">
                                                                <label for="reviewRating"
                                                                       class="form-label">Updated Rating</label>
                                                                <select class="form-select" id="reviewRating">
                                                                    <option selected>Select a rating</option>
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">6</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                    <option value="9">9</option>
                                                                    <option value="10">10</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="UpdatedReviewText"
                                                                       class="form-label">Updated Review</label>
                                                                <textarea class="form-control"
                                                                          id="updatedReviewText-<?= $userReview->getId() ?>"
                                                                          rows="5"><?= $userReview->getReview() ?></textarea>
                                                            </div>
                                                            <div class="d-grid"
                                                                 id="submitUpdatedReviewWrapper-<?= $userReview->getId() ?>"
                                                                 data-toggle="tooltip">
                                                                <button id="submitUpdateReview-<?= $userReview->getId() ?>"
                                                                        type="submit"
                                                                        class="btn btn-primary mb-1">Submit
                                                                    Review
                                                                </button>

                                                                <button type="button" class="btn btn-secondary"
                                                                        onclick="handleCancelEditReview(<?= $userReview->getId() ?>)">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <?php if (isset($userID) && (int)$userID === (int)$userReview->getUser()->getId()): ?>
                                                        <div class="col-1 d-flex justify-content-center align-items-center order-4 order-md-4">
                                                            <button class="btn btn-link text-muted mb-0"
                                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="bi bi-three-dots"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item text-danger"
                                                                       onclick="alert('jeff')">Delete
                                                                        Review</a></li>
                                                                <li><a class="dropdown-item"
                                                                       onclick="handleEditReview(<?= $userReview->getId() ?>)">Edit
                                                                        Review</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No reviews available for this album</p>
                            <?php endif; ?>

                            <script>
                                const handleEditReview = (reviewID) => {
                                    const reviewText = document.getElementById('userReviewText-' + reviewID);
                                    reviewText.style.display = 'none';

                                    const editForm = document.getElementById('editUserReview-' + reviewID);
                                    editForm.style.display = 'block';
                                }

                                const handleCancelEditReview = (reviewID) => {
                                    const reviewText = document.getElementById('userReviewText-' + reviewID);
                                    reviewText.style.display = 'block';

                                    const editForm = document.getElementById('editUserReview-' + reviewID);
                                    editForm.style.display = 'none';
                                }

                                const handleSubmitEditReview = async (event) => {
                                    event.preventDefault();
                                    const rating = document.getElementById('reviewRating').value;
                                    const review = document.getElementById('reviewText').value;

                                    const albumId = <?= $album->getAlbumID() ?>;

                                    return await fetch(`/api/albums/${albumId}/reviews`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            rating: rating,
                                            review: review
                                        })
                                    }).then(response => {
                                        if (response.status === 200) {
                                            alert('Review Edited successfully');
                                            location.reload();
                                        } else {
                                            alert('An error occurred while submitting your review');
                                        }
                                    });
                                }
                            </script>

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