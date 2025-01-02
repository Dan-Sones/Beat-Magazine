<?php if (isset($album)): ?>

    <div class="container mt-3 pt-2" id="journalist-review">
        <div class="card p-4 shadow-sm review-card">
            <?php if (isset($journalistReview) && $journalistReview): ?>

            <div class="row align-items-center">
                <div class="col-md-3 d-flex flex-column align-items-center">
                    <img alt="profilePicture for <?= $journalistReview->getJournalist()->getFullName() ?>"
                         src="<?= $journalistReview->getJournalist()->getProfilePictureUri() ?>"
                         class="img-fluid rounded-circle p-2 journalist-profile-picture">
                    <h5 class="mt-2 journalist-name"
                        onclick="URLForJournalist('<?= $journalistReview->getJournalist()->getUsername() ?>')"><?= $journalistReview->getJournalist()->getFullName() ?></h5>
                    <p class="text-muted text-center">
                        <?php if (empty($journalistReview->getJournalist()->getBio())): ?>
                            <?= $journalistReview->getJournalist()->getFullName() ?> has not set a bio yet.
                        <?php else: ?>
                            <?= $journalistReview->getJournalist()->getBio() ?>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="col-md-3 text-center p-3">
                    <h2>Rating:</h2>
                    <h2 id="journalistReviewRating"><?= $journalistReview->getRating() ?>/10</h2>
                </div>

                <div class="col-md-6">
                    <p id="journalistReviewAbstractText" class="review-abstract mb-0">
                        <?= $journalistReview->getAbstract() ?>
                        <a class="link-opacity-100 read-more-btn p-0" type="link">Read More
                        </a>
                    </p>
                </div>
            </div>
            <?php if (isset($userID) && (int)$userID === (int)$journalistReview->getJournalist()->getId()): ?>
                <div class="col-1 d-flex justify-content-center align-items-center order-4 order-md-4">
                    <button class="btn btn-link text-muted mb-0"
                            data-bs-toggle="dropdown" aria-expanded="false" aria-label="Journalist review options">
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


            <?php endif; ?>

            <div class="row align-items-center review-full-container"
                 style="overflow: hidden; height: 0;">
                <div class="col-md-12">
                    <hr/>
                    <div class="review-full container d-flex justify-content-center"
                    ">
                    <div id="journalistReviewText" class="col-xl-8 col-lg-11 col-md-12 col-sm-12">
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


    <script src="/js/journalistReview.js"></script>

<?php endif; ?>