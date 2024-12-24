<?php include 'includes/header.php'; ?>
<main class="album-wrapper d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                <div class="card shadow-lg p-3 m-4">
                    <div class="create-album-wrapper p-3">
                        <h1 class="text-center">Create Album</h1>
                        <form onsubmit="submitCreateAlbumForm(event)">
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
                                    <div class="mt-3 position-relative">
                                        <label for="artist" class="form-label">Artist</label>
                                        <input type="text" class="form-control" id="artist" name="artist" required
                                               autocomplete="off">
                                        <div id="artistSuggestions" class="list-group position-absolute w-100"
                                             style="z-index: 1000;"></div>
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
                            <div class="mb-3">
                                <label class="form-label mb-2">Songs</label>
                                <div id="songsList" class="mb-3">
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-5 mb-2 mb-md-0">
                                            <input type="text" class="form-control" name="songName[]"
                                                   placeholder="Song Name" required>
                                        </div>
                                        <div class="col-12 col-md-5 mb-2 mb-md-0">
                                            <input type="text" class="form-control" name="songLength[]"
                                                   placeholder="Song Length (e.g., 3:45)" required>
                                        </div>
                                        <div class="col-12 col-md-2 d-flex align-items-center justify-content-center justify-content-md-start mt-2 mt-md-0">
                                            <button type="button" class="btn btn-danger w-100 w-md-auto"
                                                    onclick="removeSongRow(this)">Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-outline-primary" onclick="addSongRow()">+ Add
                                        Song
                                    </button>
                                </div>
                            </div>
                            <hr/>
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

<div class="modal fade" id="createArtistModal" tabindex="-1" aria-labelledby="createArtistModal"
     aria-hidden="true">
    <form id="createArtistForm" onsubmit="submitCreateArtist(event)">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createArtistModalLabel">Create New Artist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newArtistName" class="form-label">Artist Name</label>
                        <input type="text" class="form-control" id="newArtistName" name="newArtistName" required>
                    </div>
                    <div class="mb-3">
                        <label for="newArtistBio" class="form-label">Artist Bio</label>
                        <textarea class="form-control" id="newArtistBio" name="newArtistBio" rows="3"
                                  required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="newArtistGenre" class="form-label">Artist Genre</label>
                        <input type="text" class="form-control" id="newArtistGenre" name="newArtistGenre" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button id="submitReview" type="submit"
                            class="btn btn-primary">Create Artist
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="/js/createAlbum.js">
</script>