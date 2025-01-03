<?php include 'includes/loadHeader.php'; ?>
<?php if (isset($artist) && $artist): ?>
    <main class="artist-page-wrapper">
        <div class="container mt-3">
            <div class="artist-header text-center  py-4 mb-4 rounded shadow">
                <h1><?= htmlspecialchars($artist->getName()) ?></h1>
                <div class="artist-details container">
                    <div class="row justify-content-center">
                        <p class="artist-bio col-6 justify-content-center mt-3">
                            <em><?= htmlspecialchars($artist->getBio()) ?></em></p>
                    </div>
                    <span class="d-block"
                    >Genre: <span class="genre"
                                  onclick="navigateToGenre('<?= htmlspecialchars($artist->getGenre()) ?>')"><?= htmlspecialchars($artist->getGenre()) ?></span>
                    <div class="container justify-content-center mt-3">
                        <div class="row justify-content-center">
                            <span class="d-block col-4">Average Journalist Rating: <?= htmlspecialchars($artist->getAverageJournalistRating()) ?>/10</span>
                            <span class="d-block col-4">Average User Rating:  <?= htmlspecialchars($artist->getAverageUserRating()) ?>/10</span>
                        </div>

                    </div>
                </div>

            </div>

            <div class="albums-container mt-4 mb-4">
                <h2 class="section-title text-center mb-4">Albums
                    by <?= htmlspecialchars($artist->getName()) ?></h2>
                <div class="row justify-content-center">
                    <?php if (isset($albums) && is_array($albums)): ?>
                        <?php foreach ($albums as $album): ?>
                            <?php if (isset($journalistReviews) && isset($journalistReviews[(string)$album->getAlbumID()])) : ?>
                                <?php $currJournalistReview = $journalistReviews[(string)$album->getAlbumID()]; ?>
                            <?php else: ?>
                                <?php $currJournalistReview = null; ?>
                            <?php endif; ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card shadow h-100 album-card"
                                     onclick="navigateToAlbum('<?= addslashes($album->getArtistName()) ?>', '<?= addslashes($album->getAlbumName()) ?>')">
                                    <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>"
                                         class="card-img-top"
                                         alt="<?= htmlspecialchars($album->getAlbumName()) ?>"/>
                                    <div class="card-body d-flex flex-column justify-content-center text-center">
                                        <h4 class="card-title"><?= htmlspecialchars($album->getAlbumName()) ?></h4>
                                        <p class="card-text">
                                            <?= htmlspecialchars($album->getArtistName()) ?> |
                                            <em><?= htmlspecialchars($album->getLabel()) ?></em>
                                        </p>
                                        <div class="align-items-center d-flex text-center flex-grow-1">
                                            <?php if (isset($currJournalistReview)): ?>
                                                <p class="card-text small text-center m-auto">
                                                    <?= htmlspecialchars($currJournalistReview->getAbstract()) ?>
                                                    <br>
                                                    -
                                                    <em class="journalist-name"
                                                        onclick="navigateToJournalist(event, '<?= addslashes($currJournalistReview->getJournalist()->getUsername()) ?>')"><?= htmlspecialchars($currJournalistReview->getJournalist()->getFullName()) ?></em>
                                                </p>
                                            <?php else: ?>
                                                <p class="card-text small text-muted m-auto">We have not published a
                                                    review for this album yet!</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <p class="text-center">No albums available for this artist.</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php else: ?>
                <div class="h-100 container d-flex flex-grow-1">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <h1>404: Artist not Found</h1>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script src="/js/artist.js">
    </script>
<?php include 'includes/footer.php'; ?>