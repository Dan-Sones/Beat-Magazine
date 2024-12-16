<?php include 'includes/header.php'; ?>
<main class="album-wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                <div class="card shadow-sm">
                    <div class="create-album-wrapper p-3">
                        <h1 class="text-center">Create Album</h1>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="albumCover" class="form-label">Album Cover</label>
                                    <div class="border p-3">
                                        <input type="file" class="form-control" id="albumCover" name="albumCover"
                                               accept="image/*" required>
                                        <div class="mt-3 d-flex justify-content-center align-items-center">
                                            <img id="albumCoverPreview" src="#" alt="Album Cover Preview"
                                                 class="img-fluid" style="display: none;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 d-flex flex-column justify-content-center">
                                    <div>
                                        <label for="albumTitle" class="form-label">Album Title</label>
                                        <input type="text" class="form-control" id="albumTitle" name="albumTitle"
                                               required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="artist" class="form-label">Artist</label>
                                        <input type="text" class="form-control" id="artist" name="artist" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="releaseDate" class="form-label">Release Date</label>
                                <input type="date" class="form-control" id="releaseDate" name="releaseDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="genre" class="form-label">Genre</label>
                                <input type="text" class="form-control" id="genre" name="genre" required>
                            </div>
                            <div class="mb-3">
                                <label for="label" class="form-label">Label</label>
                                <input type="text" class="form-control" id="label" name="label" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Upload Album</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>

<script>
    document.getElementById('albumCover').addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('albumCoverPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>