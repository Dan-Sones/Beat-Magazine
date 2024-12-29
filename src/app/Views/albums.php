<?php include 'includes/loadHeader.php'; ?>

    <main class="albums-container" role="main">
        <div class="container-fluid grid-container">
            <div class="row justify-content-center my-4 search-row">
                <div class="col-10 col-md-8 col-lg-6">
                    <form class="d-flex" role="search" aria-label="Search albums and artists">
                        <label for="search" class="visually-hidden">Search by album or artist name</label>
                        <input class="form-control me-2" type="search"
                               placeholder="Search by album or artist name"
                               aria-label="Search" id="search">
                    </form>
                </div>
            </div>

            <div class="row px-5 gy-5" id="albums-row" role="list">
                <?php if (isset($albums) && is_array($albums)): ?>
                    <?php foreach ($albums as $album): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" role="listitem"
                             onclick="navigateToAlbum(event, '<?= htmlspecialchars($album->getArtistName()) ?>', '<?= htmlspecialchars($album->getAlbumName()) ?>')">
                            <div class="card shadow album-card" style="width: 100%;" tabindex="0">
                                <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>" class="card-img-top"
                                     alt="<?= htmlspecialchars($album->getAlbumName()) ?>">
                                <div class="card-body">
                                    <h4 class="card-title album-title"><?= htmlspecialchars($album->getAlbumName()) ?></h4>
                                    <p class="card-text album-artist"
                                       onclick="navigateToArtist(event, '<?= htmlspecialchars($album->getArtistName()) ?>')"><?= htmlspecialchars($album->getArtistName()) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No albums available.</p>
                <?php endif; ?>
            </div>
            <?php if (isset($isJournalist) && $isJournalist) : ?>

                <div class="row p-5">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary" onclick="window.location.href = '/create-album'">Create an
                            album
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <script>
            const isJournalist = <?= json_encode($isJournalist ?? false) ?>;
        </script>
        <script src="/js/albums.js"></script>
    </main>

<?php include 'includes/footer.php'; ?>