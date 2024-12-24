<?php if (isset($album)): ?>

    <div class="container mt-3 pt-2">
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
                    <h2><?= $journalistReview->getRating() ?>/10</h2>
                </div>

                <div class="col-md-6">
                    <p class="review-abstract mb-0">
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

                <script>

                    const handleEditJournalistReview = () => {
                        const reviewRating = <?= json_encode($journalistReview->getRating()) ?>;
                        const reviewAbstract = <?= json_encode($journalistReview->getAbstract()) ?>;
                        const reviewText = <?= json_encode($journalistReview->getReview()) ?>;

                        document.getElementById('journalistReviewRating').value = reviewRating;
                        document.getElementById('journalistAbstractText').value = reviewAbstract;
                        document.getElementById('journalistReviewText').value = reviewText;
                        document.getElementById('preview').innerHTML = reviewText;

                        document.getElementById('journalistReviewForm').onsubmit = editJournalistReview;


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

        const URLForJournalist = (username) => {
            const encodedUsername = encodeURIComponent(username).replace(/%20/g, '+');
            window.location.href = `/user/${encodedUsername}`;

        }

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
<?php endif; ?>