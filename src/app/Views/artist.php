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

                <div class="row px-5 gy-5 " id="albums-row">
                    <?php if (isset($albums) && is_array($albums)): ?>
                        <?php foreach ($albums as $album): ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                                <div class="card shadow album-card" style="width: 100%;">
                                    <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>" class="card-img-top"
                                         alt="<?= $album->getAlbumName() ?>">
                                    <div class="card-body">
                                        <h4 class="card-title album-title"><?= $album->getAlbumName() ?></h4>
                                        <p class="card-text album-artist"><?= $album->getArtistName() ?></p>
                                    </div>
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
        </div>
    </main>

<?php include 'includes/footer.php'; ?>