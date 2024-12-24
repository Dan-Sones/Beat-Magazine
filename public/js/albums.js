document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    let debounceTimeout;

    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(() => {
            const query = searchInput.value.trim();
            if (query) {
                fetchAlbums(query);
            } else {
                fetchAlbums();
            }
        }, 300);
    });

    const container = document.querySelector('.albums-container .container-fluid');

    container.addEventListener('click', (event) => {
        navigateToAlbum(event);
    });

    container.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' || event.key === ' ') {
            navigateToAlbum(event);
        }
    });
});


const navigateToAlbum = (event) => {
    const card = event.target.closest('.album-card');
    if (card) {
        const artist = card.querySelector('.album-artist').textContent;
        const title = card.querySelector('.album-title').textContent;
        const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
        const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
        window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
    }
}

const fetchAlbums = (query = '') => {
    fetch(`/api/albums?search=${encodeURIComponent(query)}`)
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                return null;
            }
        })
        .then(albums => {
            updateAlbumsGrid(albums || []);
        })
        .catch(error => {
            updateAlbumsGrid([]);
        });
}

const updateAlbumsGrid = (albums) => {
    const albumsContainer = document.getElementById('albums-row');
    albumsContainer.innerHTML = albums.length > 0
        ? albums.map(album => `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" role="listitem">
                <div class="card shadow album-card" style="width: 100%;" tabindex="0">
                    <img src="/images/album-art/${album.albumArt}" class="card-img-top" alt="${album.albumName}">
                    <div class="card-body">
                        <h4 class="card-title album-title">${album.albumName}</h4>
                        <p class="card-text album-artist">${album.artistName}</p>
                    </div>
                </div>
            </div>
        `).join('')
        : getNoAlbumsText();
}

const getNoAlbumsText = () => {

    if (isJournalist) {
        return '<p class="text-center">No albums found for this search term. <a href="/create-album">Create an album</a></p>';
    }
    return '<p class="text-center">No albums found for this search term</p>';
}