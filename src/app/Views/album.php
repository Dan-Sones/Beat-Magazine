<?php include 'includes/header.php'; ?>

<?php if (isset($isJournalist) && $isJournalist): ?>
    <?php include PRIVATE_PATH . '/src/app/components/delete_album_modal.php'; ?>


    <?php if ($isJournalist && !isset($journalistReview)) : ?>
        <?php include PRIVATE_PATH . '/src/app/components/review_editor_modal.php'; ?>
    <?php endif; ?>

    <?php if (isset($journalistReview) && (isset($userID) && (int)$userID === (int)$journalistReview->getJournalist()->getId())) : ?>
        <?php include PRIVATE_PATH . '/src/app/components/review_editor_modal.php'; ?>
    <?php endif; ?>


<?php endif; ?>


<?php if (isset($album) && $album): ?>
    <main class="album-wrapper" role="main">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                    <?php include PRIVATE_PATH . '/src/app/components/album_info.php'; ?>

                    <?php include PRIVATE_PATH . '/src/app/components/journalist_review.php'; ?>
                    <div class="container mt-3 mb-5">
                        <div class="text-center mb-3">
                            <button id="tracklistButton" class="btn btn-primary" aria-pressed="false"
                                    aria-label="Show Tracklist">Tracklist
                            </button>
                            <button id="reviewButton" class="btn btn-secondary" aria-pressed="false"
                                    aria-label="Show Reviews">Reviews
                            </button>
                        </div>
                        <div id="tracklist" class="mt-3" style="display: none;">
                            <ul class="list-group">
                                <?php if (sizeof($album->getSongs()) < 1): ?>
                                    <p>No tracks found.</p>
                                <?php else: ?>
                                    <?php foreach ($album->getSongs() as $song): ?>
                                        <li class="list-group-item d-flex align-items-center justify-content-between">
                                            <div class="track-info d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0"><?= htmlspecialchars($song->getName(), ENT_QUOTES, 'UTF-8') ?></p>
                                                </div>
                                            </div>
                                            <span class="text-muted"><?= htmlspecialchars($song->getLength(), ENT_QUOTES, 'UTF-8') ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="container" id="user-reviews-container" style="display: none">
                            <?php include PRIVATE_PATH . '/src/app/components/create_user_review_card.php'; ?>
                            <?php if (isset($userReviews) && is_array($userReviews)): ?>
                                <?php foreach ($userReviews as $userReview): ?>
                                    <?php include PRIVATE_PATH . '/src/app/components/review_card.php'; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No reviews available for this album</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php else: ?>
    <div class="h-100 container d-flex flex-grow-1">
        <div class="col-12 d-flex align-items-center justify-content-center">
            <h1>404: Album not Found</h1>
        </div>
    </div>
<?php endif; ?>

    <script>
        const albumIdGlobal = <?= htmlspecialchars($album->getAlbumID(), ENT_QUOTES, 'UTF-8') ?>;
    </script>


    <script src="/js/album.js"></script>
    <script src="/js/reviewCard.js"></script>

<?php include 'includes/footer.php'; ?>