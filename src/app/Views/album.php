<?php include 'includes/header.php'; ?>

<?php if (isset($album) && $album): ?>
    <div class="modal fade" id="reviewEditor" tabindex="-1" aria-labelledby="reviewEditorModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <form onsubmit="submitJournalistReview(event)">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Review Editor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-6 justify-content-center align-items-center d-flex ps-0 ">
                                    <div class="mb-3 w-100">
                                        <label for="journalistReviewRating" class="form-label">Rating</label>
                                        <select class="form-select" id="journalistReviewRating" required>
                                            <option>Select a rating</option>
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

                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="journalistAbstractText" class="form-label">Abstract</label>
                                        <textarea class="form-control" id="journalistAbstractText" rows="5"
                                                  placeholder="Write your abstract here" required></textarea>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-6" id="editor">
                                        <div class="mb-3">
                                            <label for="journalistReviewText" class="form-label">Review Text</label>
                                            <textarea class="form-control" id="journalistReviewText" rows="15"
                                                      placeholder="Write your review here using HTML5 and see a live preview to the right"
                                                      required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6" id="preview">

                                    </div>
                                </div>


                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', () => {
                                    const reviewText = document.getElementById('journalistReviewText');
                                    const preview = document.getElementById('preview');

                                    reviewText.addEventListener('input', () => {
                                        preview.innerHTML = reviewText.value;
                                    });
                                });

                                const editJournalistReview = async () => {
                                    event.preventDefault();

                                    const rating = document.getElementById('journalistReviewRating').value;
                                    const abstract = document.getElementById('journalistAbstractText').value;
                                    const review = document.getElementById('journalistReviewText').value;

                                    const albumId = <?= $album->getAlbumID() ?>;

                                    await fetch(`/api/albums/${albumId}/journalist-reviews`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            rating: rating,
                                            abstract: abstract,
                                            review: review
                                        })
                                    }).then(response => {
                                        if (response.status === 200) {
                                            alert('Review edited successfully');
                                            location.reload();
                                        } else {
                                            alert('An error occurred while editing your review');
                                        }
                                    });

                                    // reset the default onSubmit
                                    document.querySelector('form').onsubmit = submitJournalistReview;

                                }

                                const submitJournalistReview = async () => {
                                    event.preventDefault();

                                    const rating = document.getElementById('journalistReviewRating').value;
                                    const abstract = document.getElementById('journalistAbstractText').value;
                                    const review = document.getElementById('journalistReviewText').value;
                                    const albumId = <?= $album->getAlbumID() ?>;

                                    return await fetch(`/api/albums/${albumId}/journalist-reviews`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            rating: rating,
                                            abstract: abstract,
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
                                }

                            </script>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="submitReview" type="submit"
                                class="btn btn-primary">Publish Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                    <div class="album-container shadow-sm bg-body-secondary">


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
                                <!--                                <div class="row d-flex align-items-center">-->
                                <!--                                    <div class="col-6 d-flex align-content-center-center">-->
                                <!--                                        <p><strong>Average User-->
                                <!--                                                Rating:</strong> -->
                                <?php //= $album->getAverageUserRating() ?><!--</p>-->
                                <!--                                    </div>-->
                                <!--                                    <div class="col-6 d-flex align-content-center">-->
                                <!--                                        <p><strong>Journalist Rating:</strong> --><?php //= $album->getJournalistRating() ?>
                                <!--                                        </p>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                            </div>
                        </div>

                    </div>

                    <div class="container mt-3 pt-2">
                        <div class="card p-4 shadow-sm review-card">
                            <?php if (isset($journalistReview) && $journalistReview): ?>

                            <div class="row align-items-center">
                                <div class="col-md-3 d-flex flex-column align-items-center">
                                    <img alt="profilePicture for <?= $journalistReview->getJournalist()->getFullName() ?>"
                                         src="<?= $journalistReview->getJournalist()->getProfilePictureUri() ?>"
                                         class="img-fluid rounded-circle p-2"
                                         style="width: 130px; height: 130px; object-fit: cover">
                                    <h5 class="mt-2"><?= $journalistReview->getJournalist()->getFullName() ?></h5>
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
                            <?php if (isset($userID) && (int)$userID === (int)$journalistReview->getJournalist()->getId()): ?>
                                <div class="col-1 d-flex justify-content-center align-items-center order-4 order-md-4">
                                    <button class="btn btn-link text-muted mb-0"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item text-danger"
                                               onclick="handleDeleteJournalistReview()">Delete
                                                Review</a></li>
                                        <li><a class="dropdown-item"
                                               onclick="handleEditJournalistReview()">Edit
                                                Review</a>
                                        </li>
                                    </ul>
                                </div>

                                <script>

                                    const handleEditJournalistReview = () => {
                                        const reviewRating = <?= json_encode($journalistReview->getRating()) ?>;
                                        const reviewAbstract = <?= json_encode($journalistReview->getAbstract()) ?>;
                                        const reviewText = <?= json_encode($journalistReview->getReview()) ?>;

                                        document.getElementById('journalistReviewRating').value = reviewRating;
                                        document.getElementById('journalistAbstractText').value = reviewAbstract;
                                        document.getElementById('journalistReviewText').value = reviewText;
                                        document.getElementById('preview').innerHTML = reviewText;

                                        // set the onSubmit
                                        document.querySelector('form').onsubmit = editJournalistReview;


                                        // Open the modal
                                        const reviewEditorModal = new bootstrap.Modal(document.getElementById('reviewEditor'));
                                        reviewEditorModal.show();
                                    }

                                    const handleDeleteJournalistReview = async () => {

                                        const albumId = <?= $album->getAlbumID() ?>;

                                        await fetch(`/api/albums/${albumId}/journalist-reviews`, {
                                            method: 'DELETE'
                                        }).then(response => {
                                            if (response.status === 200) {
                                                alert('Review successfully deleted.');
                                                location.reload();
                                            } else {
                                                alert('An error occurred whilst deleting your review');
                                            }
                                        });


                                    }

                                </script>
                            <?php endif; ?>

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
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'journalist'): ?>
                                <p class="text-center d-flex justify-content-center align-items-center mb-0">
                                    Hi <?= $_SESSION['username'] ?> ready to publish your review
                                    of <?= $album->getAlbumName() ?>? </p>
                                <button class="btn btn-primary mt-2" data-bs-toggle="modal"
                                        data-bs-target="#reviewEditor">Open review editor
                                </button>
                            <?php else: ?>
                                <p class="text-center d-flex justify-content-center align-items-center mb-0">No review
                                    has
                                    been published for this album. Check back soon to see our take
                                    on <?= $album->getAlbumName() ?>, or leave your own review below! 🙃</p>

                            <?php endif; ?>
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
                                element.style.height = element.scrollHeight + 'px';

                                element.addEventListener('transitionend', () => {
                                    element.style.height = 'auto';
                                }, {once: true});
                            } else if (action === 'collapse') {
                                element.style.height = element.scrollHeight + 'px';

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

                                    if (rating === 'Select a rating') {
                                        alert('Please select a valid rating.');
                                        return;
                                    }

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
                                    <?php include PRIVATE_PATH . '/src/app/components/review_card.php'; ?>
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

                                const handleSubmitEditReview = async (event, reviewId) => {
                                    event.preventDefault();
                                    const rating = document.getElementById(`updateReviewRating-${reviewId}`).value;
                                    const review = document.getElementById(`updatedReviewText-${reviewId}`).value;

                                    console.log(rating, review);

                                    const albumId = <?= $album->getAlbumID() ?>;

                                    return await fetch(`/api/albums/${albumId}/reviews/${reviewId}`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            rating: rating,
                                            review: review,
                                        })
                                    }).then(response => {
                                        if (response.status === 200) {
                                            alert('Review Edited successfully');
                                            location.reload();
                                        } else {
                                            alert('An error occurred whilst updating your review');
                                        }
                                    });
                                };

                                const handleDeleteReview = async (reviewId) => {
                                    const albumId = <?= $album->getAlbumID() ?>;

                                    return await fetch(`/api/albums/${albumId}/reviews/${reviewId}`, {
                                        method: 'DELETE'
                                    }).then(response => {
                                        if (response.status === 200) {
                                            alert('Review successfully deleted.');
                                            location.reload();
                                        } else {
                                            alert('An error occurred whilst deleting your review');
                                        }
                                    });

                                };
                            </script>

                        </div>
                    </div>

                    <script>

                        const handleShowTracklist = () => {
                            localStorage.setItem("activeTab", "tracklist");
                            document.getElementById("tracklist").style.display = "block";
                            document.getElementById("user-reviews-container").style.display = "none";

                            document.getElementById("tracklistButton").classList.remove("btn-secondary");
                            document.getElementById("tracklistButton").classList.add("btn-primary");

                            document.getElementById("reviewButton").classList.remove("btn-primary");
                            document.getElementById("reviewButton").classList.add("btn-secondary");
                        }

                        const handleShowReviews = () => {
                            localStorage.setItem("activeTab", "reviews");
                            document.getElementById("tracklist").style.display = "none";
                            document.getElementById("user-reviews-container").style.display = "block";

                            document.getElementById("tracklistButton").classList.remove("btn-primary");
                            document.getElementById("tracklistButton").classList.add("btn-secondary");

                            document.getElementById("reviewButton").classList.remove("btn-secondary");
                            document.getElementById("reviewButton").classList.add("btn-primary");
                        }

                        document.addEventListener("DOMContentLoaded", function () {
                            localStorage.getItem("activeTab") === "reviews" ? handleShowReviews() : handleShowTracklist();
                        });

                        document.getElementById("tracklistButton").addEventListener("click", handleShowTracklist);

                        document.getElementById("reviewButton").addEventListener("click", handleShowReviews);
                    </script>


                </div>
            </div>
        </div>

    </main>

<?php else: ?>
    <p>404: Album not Found</p>
<?php endif; ?>


<?php include 'includes/footer.php'; ?>