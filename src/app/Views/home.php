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
                            <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>" class="card-img-top"
                                 alt="Album art for <?= htmlspecialchars($album->getAlbumName()) ?>">
                            <div class="card-body p-4">
                                <h5 class="card-title"><?= htmlspecialchars($album->getAlbumName()) ?> -
                                    <em onclick="UrlForArtist('<?= addslashes($album->getArtistName()) ?>')"
                                        class="link-underline"><?= htmlspecialchars($album->getArtistName()) ?></em>
                                </h5>
                                <div class="card-text">

                                    <p class="big-card mb-1"><?= htmlspecialchars($rev->getAbstract()) ?></p>
                                    <a class="link-opacity-100 link-underline" type="link"
                                       onclick="UrlForAlbum('<?= addslashes($album->getArtistName()) ?>', '<?= addslashes($album->getAlbumName()) ?>')">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="row h-100">
                            <?php else: ?>
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 shadow">
                                        <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>" class="card-img-top"
                                             alt="Album art for <?= htmlspecialchars($album->getAlbumName()) ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><?= htmlspecialchars($album->getAlbumName()) ?> -
                                                <em class="link-underline"
                                                    onclick="UrlForArtist('<?= addslashes($album->getArtistName()) ?>')"><?= htmlspecialchars($album->getArtistName()) ?></em>
                                            </h5>
                                            <div class="card-text">
                                                <p class="small-card mb-1"><?= htmlspecialchars($rev->getAbstract()) ?></p>
                                                <a class="link-opacity-100 link-underline" type="link"
                                                   onclick="UrlForAlbum('<?= addslashes($album->getArtistName()) ?>', '<?= addslashes($album->getAlbumName()) ?>')">Read
                                                    More</a>
                                            </div>
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

    <script src="/js/home.js">
    </script>

<?php include 'includes/footer.php'; ?>