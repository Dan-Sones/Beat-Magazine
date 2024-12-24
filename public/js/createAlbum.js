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
    // hide the remove button for the first row - Sadly quite a convoluted and bulky way to do this
    const rows = document.querySelectorAll('#songsList .row');
    rows.forEach((row, index) => {
        const removeButton = row.querySelector('.btn-danger');
        if (index === 0) {
            removeButton.style.display = 'none';
        } else {
            removeButton.style.display = 'block';
        }
    });
};

document.addEventListener('DOMContentLoaded', updateRemoveButtons);


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

const addSongRow = () => {
    const songsList = document.getElementById('songsList');
    const newRow = document.createElement('div');
    newRow.classList.add('row', 'mb-3');
    newRow.innerHTML = `
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <input type="text" class="form-control" name="songName[]" placeholder="Song Name" required>
        </div>
        <div class="col-12 col-md-5 mb-2 mb-md-0">
            <input type="text" class="form-control" name="songLength[]" placeholder="Song Length (e.g 3:45)" required>
        </div>
        <div class="col-12 col-md-2 d-flex align-items-center justify-content-center justify-content-md-start mt-2 mt-md-0 ">
            <button type="button" class="btn btn-danger w-100 w-md-auto" onclick="removeSongRow(this)">Remove</button>
        </div>
    `;
    songsList.appendChild(newRow);
    updateRemoveButtons();
};


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


        } else if (response.status === 409) {
            alert('An artist with that name already exists');
        } else {
            alert('Failed to create artist');
        }
    });

}


const getSongsArray = () => {
    const rows = document.querySelectorAll('#songsList .row');
    const songs = [];
    rows.forEach(row => {
        const songName = row.querySelector('input[name="songName[]"]').value;
        const songLength = row.querySelector('input[name="songLength[]"]').value;
        songs.push({
            name: songName,
            length: songLength
        });
    });
    return songs;
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
        } else if (response.status === 409) {
            alert('An album with that name already exists for this artist');
        } else {
            alert('Failed to create album');
        }
    });
}