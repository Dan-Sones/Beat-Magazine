<?php include 'includes/loadHeader.php'; ?>
<?php if (isset($artist) && $artist): ?>
    <main class="artist-page-wrapper">
        <div class="container">
            <div class="artist-header text-center bg-light py-4 mb-4 rounded shadow">
                <h1><?= htmlspecialchars($artist->getName()) ?></h1>
                <div class="artist-details">
                    <span class="d-block"><?= htmlspecialchars($artist->getGenre()) ?></span>
                    <span class="d-block">Average Journalist Rating: <?= htmlspecialchars($artist->getAverageJournalistRating()) ?></span>
                </div>
                <p class="artist-bio mt-3"><?= htmlspecialchars($artist->getBio()) ?></p>
            </div>

            <div class="albums-container mt-4 mb-4">
                <h2 class="section-title text-center mb-4">Albums
                    by <?= htmlspecialchars($artist->getName()) ?></h2>
                <div class="row justify-content-center">
                    <?php if (isset($albums) && is_array($albums)): ?>
                        <?php foreach ($albums as $album): ?>
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
                                            <?php if (isset($journalistReviews[(string)$album->getAlbumID()])): ?>
                                                <p class="card-text small text-center m-auto">
                                                    <?= htmlspecialchars($journalistReviews[(string)$album->getAlbumID()]->getAbstract()) ?>
                                                    <br>
                                                    -
                                                    <em class="journalist-name"
                                                        onclick="navigateToJournalist(event, '<?= addslashes($journalistReviews[(string)$album->getAlbumID()]->getJournalist()->getUsername()) ?>')"><?= htmlspecialchars($journalistReviews[(string)$album->getAlbumID()]->getJournalist()->getFullName()) ?></em>
                                                </p>
                                            <?php else: ?>
                                                <p class="card-text small text-muted m-auto">No review available</p>
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

    <script>
        const navigateToAlbum = (artist, title) => {
            const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
            const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
            window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
        }

        const navigateToJournalist = (event, journalistUsername) => {
            event.stopPropagation()
            const encodedJournalist = encodeURIComponent(journalistUsername).replace(/%20/g, '+');
            window.location.href = `/user/${encodedJournalist}`;
        }
    </script>
<?php include 'includes/footer.php'; ?>