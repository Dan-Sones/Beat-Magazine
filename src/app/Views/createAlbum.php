<?php include 'includes/header.php'; ?>
<main class="album-wrapper d-flex justify-content-center align-items-center">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-8 col-lg-10 col-md-10 col-sm-12">
                <div class="card shadow-lg">
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

<script>

    let artistID = "";

    document.getElementById('albumCover').addEventListener('change', function (event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('albumCoverPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });

    let debounceTimeout;
    document.getElementById('artist').addEventListener('input', function (event) {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const query = event.target.value;
            if (query.length > 2) {
                fetch(`/api/artists?search=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        const suggestions = document.getElementById('artistSuggestions');
                        suggestions.innerHTML = '';
                        for (const [artistName, artistId] of Object.entries(data)) {
                            const item = document.createElement('a');
                            item.classList.add('list-group-item', 'list-group-item-action');
                            item.textContent = artistName;
                            item.addEventListener('click', () => {
                                document.getElementById('artist').value = artistName;
                                suggestions.innerHTML = '';
                                artistID = artistId;
                            });
                            suggestions.appendChild(item);

                        }
                        const createNewItem = document.createElement('a');
                        createNewItem.classList.add('list-group-item', 'list-group-item-action', 'text-primary');
                        createNewItem.textContent = 'Create new artist';
                        createNewItem.addEventListener('click', () => {
                            const artistNameInput = document.getElementById('newArtistName');
                            artistNameInput.value = query;

                            const createArtistModal = new bootstrap.Modal(document.getElementById('createArtistModal'));
                            createArtistModal.show();
                        });
                        suggestions.appendChild(createNewItem);
                    });
            }
        }, 300);
    })


    const submitCreateArtist = async (event) => {
        console.log('submitCreateArtist');
        event.preventDefault();

        const artistName = document.getElementById('newArtistName').value;
        const artistBio = document.getElementById('newArtistBio').value;
        const artistGenre = document.getElementById('newArtistGenre').value;

        await fetch('/api/artists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                artistName,
                artistBio,
                artistGenre
            })
        }).then(response => {
            if (response.status === 201) {
                alert('Artist created successfully');
                const artistInput = document.getElementById('artist');
                artistInput.value = artistName;
                artistID = response.json().id;

                // hide all bootstrap modals
                document.querySelectorAll('.modal').forEach(modal => {
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    modalInstance.hide();
                });


                // set the artist form input to the created artist
                artistInput.value = artistName;

                // clear the artist suggestions
                document.getElementById('artistSuggestions').innerHTML = '';


            } else {
                alert('Failed to create artist');
            }
        });

    }


    const submitCreateAlbumForm = async (event) => {
        event.preventDefault();
        const albumCover = document.getElementById('albumCover').files[0];
        const albumTitle = document.getElementById('albumTitle').value;
        const releaseDate = document.getElementById('releaseDate').value;
        const genre = document.getElementById('genre').value;
        const label = document.getElementById('label').value;
        const artist = document.getElementById('artist').value;

        const formData = new FormData();
        formData.append('albumArt', albumCover);
        formData.append('albumName', albumTitle);
        formData.append('releaseDate', releaseDate);
        formData.append('genre', genre);
        formData.append('label', label);
        formData.append('artistID', artistID);

        await fetch('/api/albums', {
            method: 'POST',
            contentType: 'multipart/form-data',
            body: formData
        }).then(response => {
            if (response.ok) {
                alert('Album created successfully');
                const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
                const encodedTitle = encodeURIComponent(albumTitle).replace(/%20/g, '+');
                window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
            } else {
                alert('Failed to create album');
            }
        });
    }

</script>