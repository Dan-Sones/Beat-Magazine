<?php include 'includes/header.php'; ?>

    <main class="albums-container">
        <div class="container-fluid">
            <div class="row px-5 gy-5">
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
                    <p>No albums available.</p>
                <?php endif; ?>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
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
            });
        </script>
    </main>

<?php include 'includes/footer.php'; ?>