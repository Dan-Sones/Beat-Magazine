<?php include 'includes/header.php'; ?>

    <main class="album-wrapper">
        <div class="container-fluid">
            <div class="row justify-content-center">

                <?php if (isset($artist) && $artist): ?>

                <div class="col-lg-8 col-md-10 col-sm-12">
                    <h1>Yo</h1>
                </div>
            </div>
            <?php else: ?>
                <p>No artist available.</p>
            <?php endif; ?>


        </div>
        </div>

    </main>


<?php include 'includes/footer.php'; ?>