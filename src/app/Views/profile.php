<?php include 'includes/loadHeader.php'; ?>

    <main class="album-wrapper">
        <div class="container-fluid overflow-x-hidden">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                    <div class="profile-container shadow d-flex justify-content-center pb-3 pt-3">
                        <?php if (isset($user)) : ?>
                        <div class="content justify-content-center">
                            <div class="row">
                                <div class="col-12 justify-content-center d-flex">
                                    <?php if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] && isset($idForUser) && $_SESSION['user_id'] === $idForUser): ?>
                                        <form id="uploadForm"
                                              enctype="multipart/form-data" style="position: relative;">
                                            <input type="file" name="profile_picture" id="profilePictureInput"
                                                   style="display: none;">
                                            <div id="profilePicture" style="cursor: pointer; position: relative;">
                                                <img src="<?= $user->getProfilePictureUri() ?>" alt="Profile Picture" ∂
                                                     class="img-fluid rounded-circle"
                                                     style="width: 200px; height: 200px; object-fit: cover">
                                                <div id="uploadOverlay" class="rounded-circle">
                                                    <i class="bi bi-cloud-upload"></i></div>
                                            </div>
                                        </form>
                                    <?php else: ?>
                                        <img src="<?= $user->getProfilePictureUri() ?>"
                                             class="img-fluid rounded-circle p-2"
                                             style="width: 250px; height: 250px; object-fit: cover"
                                             alt="Profile Picture">
                                    <?php endif; ?>

                                </div>
                            </div>

                            <script>
                                // Show the file upload dialog when the profile picture is clicked - Because the file input is hidden
                                document.getElementById('profilePicture').addEventListener('click', function () {
                                    document.getElementById('profilePictureInput').click();
                                });

                                document.getElementById('profilePictureInput').addEventListener('change', function () {
                                    handleUpload();
                                });

                                const handleUpload = async () => {
                                    const fileInput = document.getElementById('profilePictureInput');
                                    const file = fileInput.files[0];
                                    const formData = new FormData();
                                    formData.append('profile_picture', file);

                                    const response = await fetch('/api/upload-profile-picture', {
                                        method: 'POST',
                                        body: formData
                                    });

                                    if (response.ok) {
                                        window.location.reload();
                                    } else {
                                        alert('Failed to upload profile picture. Make sure you are using a valid image file.');
                                    }
                                };
                            </script>


                            <div class="row">
                                <div class="col-12">
                                    <div class="userInfo pt-2">
                                        <!--TODO:Allow editing if logged in-->
                                        <?php if (isset($isJournalist) && $isJournalist): ?>
                                            <h1 class="text-center" data-bs-toggle="tooltip" data-bs-placement="right"
                                                title="This User is a Journalist for BeatMagazine.com"><?= $user->getUsername() ?>
                                                📝</h1>
                                        <?php else: ?>
                                            <h1 class="text-center"><?= $user->getUsername() ?> </h1>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 row justify-content-center">
                                <div class="col-12 text-center">
                                    <h5>User Since</h5>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-12 text-center">
                                    <p><?= $user->getCreatedAt() ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <?php if (isset($isJournalist) && $isJournalist): ?>

                        <div id="journalist-reviews" class="pt-3 container d-flex justify-content-center">
                            <?php if (!empty($journalistReviews) && !empty($albumDetailsMap)): ?>
                                <div class="row justify-content-center">
                                    <h2 class="text-center pt-3 pb-3">Official BeatMagazine Reviews</h2>
                                    <?php foreach ($journalistReviews as $journalistReview): ?>
                                        <?php $album = $albumDetailsMap[$journalistReview->getAlbumId()]; ?>
                                        <div class="col-md-4 col-sm-6 mb-4 d-flex flex-column justify-content-center text-center">
                                            <div class="card shadow h-100 official-review-card">
                                                <img src="<?= $album->getAlbumArt() ?>"
                                                     class="card-img-top" alt="Album Art">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $album->getAlbumName() ?></h5>
                                                    <p class="card-text">
                                                        <em class="artist-name"
                                                            onclick="UrlForArtist('<?= addslashes($album->getArtistName()) ?>')"> <?= $album->getArtistName() ?></em>
                                                        |
                                                        <?= $album->getLabel() ?>
                                                    </p>

                                                    <hr/>
                                                    <div class="container mb-3">
                                                        <div class="row justify-content-center">
                                                            <div class="col-auto">
                                                                <div class="rating-container rounded d-flex justify-content-center align-items-center p-2 border">
                                                                    <h4 class="rating-display  mb-0"><?= $journalistReview->getRating() . "/10" ?></h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p class="card-text"><?= $journalistReview->getAbstract() ?> <a
                                                                class="link-opacity-100 read-review-link" type="link"
                                                                onclick="UrlForAlbum('<?= addslashes($album->getArtistName()) ?>', '<?= addslashes($album->getAlbumName()) ?>')">Read
                                                            More</a></p>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>

                                </div>


                            <?php else: ?>
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <p class="text-center"><?= $user->getUsername() ?> has not left any reviews on
                                            behalf of BeatMagazine!</p>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>

                    <?php endif; ?>


                    <div id="reviews-container" class="container d-flex justify-content-center pb-3 pt-3">
                        <div class="container">
                            <div class="row gx-5">
                                <div class="col-12">

                                    <h2 class="text-center mb-5 mt-2">Community Reviews</h2>
                                </div>

                                <div class="col-12">

                                    <?php if (isset($userReviews) && count($userReviews) > 0 && isset($albumDetailsMap)): ?>
                                        <?php $i = 0; ?>

                                        <?php foreach ($userReviews as $userReview): ?>
                                            <?php $album = $albumDetailsMap[$userReview->getAlbumId()]; ?>
                                            <div class="row gx-5 d-flex align-items-center pb-5 album-review"
                                                 data-aos="fade-<?php echo $i % 2 == 0 ? 'right' : 'left'; ?>"
                                                 data-aos-duration="1000" id="album-review">
                                                <div class="col-md-6 col-12 order-0 order-md-<?php echo $i % 2 == 0 ? '1' : '0'; ?> justify-content-center pb-sm-3">
                                                    <div class="album-art pb-3">
                                                        <img src="<?= $album->getAlbumArt() ?>"
                                                             class="img-fluid shadow album-art"
                                                             id="album-art"
                                                             alt="Album Art for <?= $album->getAlbumName() ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 order-1 order-md-<?php echo $i % 2 == 0 ? '0' : '1'; ?> justify-content-center">
                                                    <div class="review card mb-4 shadow">
                                                        <div class="card-header">
                                                            <h4 id="album-title"
                                                                class="mb-0"><?= $album->getAlbumName() ?></h4>
                                                            <h5 id="album-artist"
                                                                class="fw-light"><?= $album->getArtistName() ?></h5>
                                                        </div>
                                                        <div class="card-body d-flex flex-column flex-md-row align-items-center">
                                                            <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
                                                                <div class="container mb-2">
                                                                    <div class="row justify-content-center">
                                                                        <div class="col-auto">
                                                                            <div class="rating-container rounded d-flex justify-content-center align-items-center p-2 border">
                                                                                <h4 class="rating-display  mb-0"><?= $userReview->getRating() . "/10" ?></h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="ps-3 col-12 col-md-8">
                                                                <p class="review-text mb-0"><?= $userReview->getReview() ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>

                                    <?php else: ?>
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <p class="text-center"><?= $user->getUsername() ?> has not left any
                                                    reviews!</p>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                </div>


                                <?php else: ?>
                                    <div class="row justify-content-center">
                                        <div class="col-12">
                                            <h1 class="text-center">User not found</h1>
                                        </div>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')

            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


            const container = document.getElementById('reviews-container');

            container.addEventListener('click', (event) => {
                const card = event.target.closest('.album-review');
                if (card) {
                    const artist = card.querySelector('#album-artist').textContent;
                    const title = card.querySelector('#album-title').textContent;
                    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
                    const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
                    window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
                } else {
                }
            });

            const UrlForAlbum = (artist, title) => {
                const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
                const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
                window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
            }

            const UrlForArtist = (artist) => {
                const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
                window.location.href = `/artist/${encodedArtist}`;
            }

        </script>
    </main>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

<?php include 'includes/footer.php'; ?>