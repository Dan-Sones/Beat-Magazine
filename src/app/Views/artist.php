<?php include 'includes/header.php'; ?>

    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <?php if (isset($artist) && $artist): ?>

                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                    <h2><?= $artist->getName() ?></h2>
                    <p><?= $artist->getBio() ?></p>

                </div>
            </div>
            <?php else: ?>
                <p>No artist available.</p>
            <?php endif; ?>

            <div class="text-center mb-3">
                <button id="reviewViewButton" class="btn btn-primary">Review View</button>
                <button id="albumGridViewButton" class="btn btn-secondary">Grid View</button>
            </div>

            <div id="albumGridView" style="display: none;">grid</div>
            <div id="reviewView" style="display: none;">reviews</div>

            <script>
                const handleShowReviewView = () => {
                    // Show the review view and hide the grid view
                    document.getElementById("reviewView").style.display = "block";
                    document.getElementById("albumGridView").style.display = "none";

                    // Update button styles
                    document.getElementById("reviewViewButton").classList.remove("btn-secondary");
                    document.getElementById("reviewViewButton").classList.add("btn-primary");

                    document.getElementById("albumGridViewButton").classList.remove("btn-primary");
                    document.getElementById("albumGridViewButton").classList.add("btn-secondary");
                };

                const handleShowAlbumGrid = () => {
                    // Show the grid view and hide the review view
                    document.getElementById("reviewView").style.display = "none";
                    document.getElementById("albumGridView").style.display = "block";

                    // Update button styles
                    document.getElementById("reviewViewButton").classList.remove("btn-primary");
                    document.getElementById("reviewViewButton").classList.add("btn-secondary");

                    document.getElementById("albumGridViewButton").classList.remove("btn-secondary");
                    document.getElementById("albumGridViewButton").classList.add("btn-primary");
                };

                // On load, show the review view
                document.addEventListener("DOMContentLoaded", function () {
                    handleShowReviewView();
                });

                // Add event listeners to the buttons
                document.getElementById("reviewViewButton").addEventListener("click", handleShowReviewView);
                document.getElementById("albumGridViewButton").addEventListener("click", handleShowAlbumGrid);
            </script>

        </div>


    </main>


<?php include 'includes/footer.php'; ?>