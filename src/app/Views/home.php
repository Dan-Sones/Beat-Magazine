<?php include 'includes/header.php'; ?>
    <div class="d-flex justify-content-center align-items-center h-100">

        <?php if (isset($reviews) && is_array($reviews)): ?>
            <div class="container mt-5 latest-reviews">
                <div class="row">
                    <?php $index = 0; ?>
                    <?php foreach ($reviews

                    as $review): ?>
                    <?php $album = $review['album']; ?>
                    <?php $rev = $review['review']; ?>
                    <?php if ($index == 0): ?>

                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow">
                            <img src="<?= $album->getAlbumArt() ?>" class="card-img-top" alt="Review 1">
                            <div class="card-body p-4">
                                <h5 class="card-title"><?= $album->getAlbumName() ?> -
                                    <em><?= $album->getArtistName() ?></em></h5>
                                <p class="card-text big-card"><?= $rev->getAbstract() ?>

                                </p>
                                <a class="btn btn-link read-more-btn" type="link"
                                   onclick="UrlForAlbum('<?= addslashes($album->getArtistName()) ?>', '<?= addslashes($album->getAlbumName()) ?>')">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="row h-100">
                            <?php else: ?>
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 shadow">
                                        <img src="<?= $album->getAlbumArt() ?>" class="card-img-top"
                                             alt="Review 4">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= $album->getAlbumName() ?> -
                                                <em><?= $album->getArtistName() ?></em></h5>
                                            <p class="card-text small-card">100%
                                                <?= $rev->getAbstract() ?></p>
                                            <a class="btn btn-link read-more-btn" type="link"
                                               onclick="UrlForAlbum('<?= addslashes($album->getArtistName()) ?>', '<?= addslashes($album->getAlbumName()) ?>')">Read
                                                More</a>
                                        </div>
                                    </div>
                                </div>


                            <?php endif; ?>
                            <?php $index++; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const UrlForAlbum = (artist, title) => {
            const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
            const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
            window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
        }
    </script>

<?php include 'includes/footer.php'; ?>