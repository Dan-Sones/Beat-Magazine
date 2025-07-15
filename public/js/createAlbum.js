let artistID = "";

document.getElementById('albumCover').addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
        const preview = document.getElementById('albumCoverPreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});

const removeSongRow = (button) => {
    const row = button.parentElement.parentElement;
    row.remove();
    updateRemoveButtons();
};

const updateRemoveButtons = () => {
    const rows = document.querySelectorAll('#songsList .row');
    rows.forEach((row, index) => {
        const removeButton = row.querySelector('.btn-danger');
        removeButton.style.display = index === 0 ? 'none' : 'block';
    });
};

document.addEventListener('DOMContentLoaded', updateRemoveButtons);

let debounceTimeout

document.getElementById('artist').addEventListener('input', (event) => {
    handleArtistInput(event)
})

const handleArtistInput = (event) => {
    clearTimeout(debounceTimeout)
    debounceTimeout = setTimeout(() => {
        const query = event.target.value
        if (query.length > 2) {
            fetchArtists(query)
        }
    }, 300)
}

const fetchArtists = async (query) => {
    const response = await fetch(`/api/artists?search=${query}`)
    if (response.status === 200) {
        const data = await response.json()
        populateSuggestions(query, data)
    }
}

const populateSuggestions = (query, data) => {
    const suggestions = document.getElementById('artistSuggestions')
    suggestions.innerHTML = ''

    for (const [artistName, artistId] of Object.entries(data)) {
        const item = createArtistSuggestionItem(artistName, artistId)
        suggestions.appendChild(item)
    }

    const createNewItem = createNewArtistOption(query)
    suggestions.appendChild(createNewItem)
}

const createArtistSuggestionItem = (artistName, artistId) => {
    const item = document.createElement('a')
    item.classList.add('list-group-item', 'list-group-item-action')
    item.textContent = artistName
    item.addEventListener('click', () => {
        document.getElementById('artist').value = artistName
        document.getElementById('artistSuggestions').innerHTML = ''
        artistID = artistId
    })
    return item
}

const createNewArtistOption = (query) => {
    const createNewItem = document.createElement('a')
    createNewItem.classList.add(
        'list-group-item',
        'list-group-item-action',
        'text-primary'
    )
    createNewItem.textContent = 'Create new artist'
    createNewItem.addEventListener('click', () => {
        showCreateArtistModal(query)
    })
    return createNewItem
}

const showCreateArtistModal = (query) => {
    const artistNameInput = document.getElementById('newArtistName')
    artistNameInput.value = query
    const createArtistModal = new bootstrap.Modal(
        document.getElementById('createArtistModal')
    )
    createArtistModal.show()
}

const addSongRow = () => {
    const songsList = document.getElementById('songsList');
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-3');
    newRow.innerHTML = `
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <input type="text" class="form-control" name="songName[]" placeholder="Song Name" required>
        </div>
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <input type="text" class="form-control" name="songLength[]" pattern="^\\d{2}:\\d{2}$" placeholder="Song Length (e.g 03:45)" required>
        </div>
        <div class="col-12 col-md-2 d-flex align-items-center justify-content-center justify-content-md-start mt-2 mt-md-0">
            <button type="button" class="btn btn-danger w-100 w-md-auto" onclick="removeSongRow(this)">Remove</button>
        </div>
    `;
    songsList.appendChild(newRow);
    updateRemoveButtons();
};

const submitCreateArtist = async (event) => {
    event.preventDefault();

    const artistName = document.getElementById('newArtistName').value;
    const artistBio = document.getElementById('newArtistBio').value;
    const artistGenre = document.getElementById('newArtistGenre').value;

    try {
        const response = await fetch('/api/artists', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                artistName,
                artistBio,
                artistGenre
            })
        });

        if (response.status === 201) {
            const responseData = await response.json();
            Swal.fire({
                title: 'Artist created successfully',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
            });
            const artistInput = document.getElementById('artist');
            artistInput.value = artistName;
            artistID = responseData.id;

            document.querySelectorAll('.modal').forEach(modal => {
                const modalInstance = bootstrap.Modal.getInstance(modal);
                modalInstance.hide();
            });

            document.getElementById('artistSuggestions').innerHTML = '';
        } else if (response.status === 409) {
            Swal.fire({
                title: 'An artist with that name already exists',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
            });
        } else {
            Swal.fire({
                title: 'Failed to create artist',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Network error occurred while creating artist',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
        });
    }
};

const getSongsArray = () => {
    const rows = document.querySelectorAll('#songsList .row');
    return Array.from(rows).map(row => ({
        name: row.querySelector('input[name="songName[]"]').value,
        length: row.querySelector('input[name="songLength[]"]').value
    }));
};

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
    formData.append('songs', JSON.stringify(getSongsArray()));

    try {
        const response = await fetch('/api/albums', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            Swal.fire({
                title: 'Album created successfully',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'success',
                showConfirmButton: 'Ok!'
            }).then(() => {
                const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
                const encodedTitle = encodeURIComponent(albumTitle).replace(/%20/g, '+');
                window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
            });
        } else if (response.status === 409) {
            Swal.fire({
                title: 'An album with that name already exists',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
            });
        } else {
            Swal.fire({
                title: 'Failed to create album',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Network error occurred while creating album',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
        });
    }
};