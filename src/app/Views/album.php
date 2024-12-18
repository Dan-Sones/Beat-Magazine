<?php include 'includes/header.php'; ?>
<?php include PRIVATE_PATH . '/src/app/components/review_editor_modal.php'; ?>

<?php if (isset($album) && $album): ?>
    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">

                    <?php include PRIVATE_PATH . '/src/app/components/album_info.php'; ?>


                    <?php include PRIVATE_PATH . '/src/app/components/journalist_review.php'; ?>

                    <div class="container mt-3 mb-5">
                        <div class="text-center mb-3">
                            <button id="tracklistButton" class="btn btn-primary">Tracklist</button>
                            <button id="reviewButton" class="btn btn-secondary">Reviews</button>
                        </div>
                        <div id="tracklist" class="mt-3" style="display: none;">
                            <ul class="list-group">
                                <?php if (sizeof($album->getSongs()) < 1): ?>
                                    <p>No tracks found.</p>
                                <?php else: ?>

                                <?php foreach ($album->getSongs() as $song): ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="track-info d-flex align-items-center">
                                            <button class="btn btn-sm play-button me-3">
                                                <i class="bi bi-play-circle"></i>
                                            </button>
                                            <div>
                                                <p class="mb-0"><?= $song->getName() ?></p></div>
                                        </div>
                                        <span class="text-muted"><?= $song->getLength() ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>


                        <div class="container" id="user-reviews-container" style="display: none">

                            <?php include PRIVATE_PATH . '/src/app/components/create_user_review_card.php'; ?>

                            <?php if (isset($userReviews) && is_array($userReviews)): ?>
                                <?php foreach ($userReviews as $userReview): ?>
                                    <?php include PRIVATE_PATH . '/src/app/components/review_card.php'; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No reviews available for this album</p>
                            <?php endif; ?>


                        </div>
                    </div>

                    <script>

                        const handleShowTracklist = () => {
                            localStorage.setItem("activeTab", "tracklist");
                            document.getElementById("tracklist").style.display = "block";
                            document.getElementById("user-reviews-container").style.display = "none";

                            document.getElementById("tracklistButton").classList.remove("btn-secondary");
                            document.getElementById("tracklistButton").classList.add("btn-primary");

                            document.getElementById("reviewButton").classList.remove("btn-primary");
                            document.getElementById("reviewButton").classList.add("btn-secondary");
                        }

                        const handleShowReviews = () => {
                            localStorage.setItem("activeTab", "reviews");
                            document.getElementById("tracklist").style.display = "none";
                            document.getElementById("user-reviews-container").style.display = "block";

                            document.getElementById("tracklistButton").classList.remove("btn-primary");
                            document.getElementById("tracklistButton").classList.add("btn-secondary");

                            document.getElementById("reviewButton").classList.remove("btn-secondary");
                            document.getElementById("reviewButton").classList.add("btn-primary");
                        }

                        document.addEventListener("DOMContentLoaded", function () {
                            localStorage.getItem("activeTab") === "reviews" ? handleShowReviews() : handleShowTracklist();
                        });

                        document.getElementById("tracklistButton").addEventListener("click", handleShowTracklist);

                        document.getElementById("reviewButton").addEventListener("click", handleShowReviews);
                    </script>


                </div>
            </div>
        </div>

    </main>

<?php else: ?>
    <p>404: Album not Found</p>
<?php endif; ?>


<?php include 'includes/footer.php'; ?>