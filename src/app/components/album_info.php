<?php if (isset($album)): ?>
    <div class="album-container shadow-sm bg-body-secondary">

        <div class="row album-content">
            <div class="col-12 col-lg-4 order-1 order-lg-1 align-content-center">
                <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>"
                     class="img-fluid shadow-sm"
                     alt="Responsive Image">
            </div>

            <div class="album-info col-12 col-lg-8 ps-4 order-2 order-lg-2">
                <div class="row title-artist-section">
                    <div class="row">
                        <h2><?= $album->getAlbumName() ?>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'journalist'): ?>
                                <button class="btn btn-link text-muted mb-0"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item text-danger"
                                           onclick="handleDeleteAlbumIntention()">Delete
                                            Album</a></li>
                                </ul>
                            <?php endif; ?>
                        </h2>
                    </div>
                    <div class="row">
                        <h5 class="artist-name"
                            onclick="UrlForAlbum('<?= addslashes($album->getArtistName()) ?>')">
                            <?= $album->getArtistName() ?>
                        </h5>
                    </div>
                </div>
                <div class="row info d-flex align-items-center">
                    <p><strong>Release Date:</strong> <?= $album->getReleaseDate() ?></p>
                    <p><strong>Genre</strong>: <?= $album->getGenre() ?></p>
                    <p><strong>Label:</strong> <?= $album->getLabel() ?></p>
                </div>
                <!--                                <div class="row d-flex align-items-center">-->
                <!--                                    <div class="col-6 d-flex align-content-center-center">-->
                <!--                                        <p><strong>Average User-->
                <!--                                                Rating:</strong> -->
                <?php //= $album->getAverageUserRating() ?><!--</p>-->
                <!--                                    </div>-->
                <!--                                    <div class="col-6 d-flex align-content-center">-->
                <!--                                        <p><strong>Journalist Rating:</strong> --><?php //= $album->getJournalistRating() ?>
                <!--                                        </p>-->
                <!--                                    </div>-->
                <!--                                </div>-->
            </div>
        </div>

    </div>
    <script>
        const UrlForAlbum = (artist) => {
            const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
            window.location.href = `/artist/${encodedArtist}`;
        }

        const handleDeleteAlbumIntention = () => {
            const modal = new bootstrap.Modal(document.getElementById('deleteAlbumModal'));
            modal.show();
        }
        
    </script>
<?php endif; ?>