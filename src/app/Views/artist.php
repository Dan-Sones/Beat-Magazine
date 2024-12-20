<?php include 'includes/loadHeader.php'; ?>

    <main class="artist-wrapper">
        <div class="container-fluid">
            <?php if (isset($artist) && $artist): ?>
                <div class="row justify-content-center align-items-center mt-5">
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="card shadow" id="artist-info-card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <h1 class="card-title"><?= $artist->getName() ?></h1>
                                    <div class="col-6 justify-content-center align-items-center">
                                        <p class="card-text"><strong><?= $artist->getGenre() ?></strong></p>
                                    </div>
                                    <div class="col-6 justify-content-center align-items-center">
                                        <p class="card-text"><strong>Average Journalist
                                                Rating:</strong> <?= $artist->getAverageJournalistRating() ?></p>

                                    </div>
                                </div>
                                <p class="card-text"><?= $artist->getBio() ?></p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row px-5 gy-5 pb-4" id="albums-container">
                    <?php if (isset($albums) && is_array($albums)): ?>
                        <?php foreach ($albums as $album): ?>
                            <div class=" col-12 col-md-6">
                                <div class="card shadow album-card" style="width: 100%;">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>"
                                                 class="img-fluid rounded-start" alt="<?= $album->getAlbumName() ?>">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <div class="">
                                                    <h4 class="card-title album-title"><?= $album->getAlbumName() ?></h4>
                                                    <p class="mb-0"><?= $album->getArtistName() ?>
                                                        <br/> <em> <?= $album->getLabel() ?> </em></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (isset($journalistReviews[(string)$album->getAlbumID()])): ?>
                                        <div class="card-footer">
                                            <p class="card-text album-review-abstract"><?= $journalistReviews[(string)$album->getAlbumID()]->getAbstract() ?>
                                                - <?= $journalistReviews[(string)$album->getAlbumID()]->getJournalist()->getFullName() ?>
                                            </p>
                                        </div>
                                    <?php else: ?>
                                        <div class="card-footer">
                                            <p class="card-text album-review-abstract">No review available</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">No albums available.</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="text-center">Artist Not Found</p>
            <?php endif; ?>
            <script>
                const container = document.querySelector('.albums-container .container-fluid');

                container.addEventListener('click', (event) => {
                    const card = event.target.closest('.album-card');
                    if (card) {
                        const artist = card.querySelector('.album-artist').textContent;
                        const title = card.querySelector('.album-title').textContent;
                        const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
                        const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
                        window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
                    }
                });
            </script>
        </div>

    </main>

<?php include 'includes/footer.php'; ?>