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
                                        <h1 class="text-center"><?= $user->getUsername() ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-2 row justify-content-center">
                                <!--                                <div class="col-4 text-center">-->
                                <!--                                    <h5>Total Likes</h5>-->
                                <!--                                </div>-->

                                <div class="col-12 text-center">
                                    <h5>User Since</h5>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <!--                                <div class="col-4 text-center">-->
                                <!--                                    <p></p>-->
                                <!--                                </div>-->

                                <div class="col-12 text-center">
                                    <p><?= $user->getCreatedAt() ?></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="reviews-container container d-flex justify-content-center pb-3 pt-3">
                        <div class="container">
                            <div class="row gx-5">
                                <div class="col-12">

                                    <h2 class="text-center mb-5 mt-2">Reviews</h2>
                                </div>

                                <div class="col-12">

                                    <?php if (isset($userReviews) && count($userReviews) > 0 && isset($albumDetailsMap)): ?>
                                        <?php $i = 0; ?>

                                        <?php foreach ($userReviews as $userReview): ?>
                                            <div class="row gx-5 d-flex align-items-center pb-5"
                                                 data-aos="fade-<?php echo $i % 2 == 0 ? 'right' : 'left'; ?>"
                                                 data-aos-duration="1000">
                                                <div class="col-md-6 col-12 order-0 order-md-<?php echo $i % 2 == 0 ? '1' : '0'; ?> justify-content-center pb-sm-3">
                                                    <div class="album-art pb-3">
                                                        <img src="<?= $albumDetailsMap[$userReview->getAlbumId()]->getAlbumArt() ?>"
                                                             class="img-fluid shadow album-art"
                                                             onclick="window.location.href = '/artist/<?= $albumDetailsMap[$userReview->getAlbumId()]->getArtistName() ?>/<?= $albumDetailsMap[$userReview->getAlbumId()]->getAlbumName() ?>'"
                                                             alt="Album Art for <?= $albumDetailsMap[$userReview->getAlbumId()]->getAlbumName() ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 order-1 order-md-<?php echo $i % 2 == 0 ? '0' : '1'; ?> justify-content-center">
                                                    <div class="review card">
                                                        <div class="card-header">
                                                            <h4><?= $albumDetailsMap[$userReview->getAlbumId()]->getAlbumName() ?></h4>
                                                            <h5><?= $albumDetailsMap[$userReview->getAlbumId()]->getArtistName() ?></h5>
                                                        </div>
                                                        <div class="card-body container d-flex flex-column flex-md-row align-items-center">
                                                            <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
                                                                <h2 class="rating-display"><?= $userReview->getRating() . "/10" ?>
                                                                </h2>
                                                            </div>
                                                            <div class="col-12 col-md-8">
                                                                <p class="review-text"><?= $userReview->getReview() ?></p>
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
    </main>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

<?php include 'includes/footer.php'; ?>