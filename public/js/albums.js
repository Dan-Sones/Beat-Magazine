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

    if (isGenrePage()) {


        document.getElementById("search-form").style.display = 'none';
        document.getElementById("create-album-container").style.display = 'none';


        const urlParams = new URLSearchParams(window.location.search);
        const genre = urlParams.get('genre');

        // Auto capitalize the genre name
        document.getElementById('genre-title').innerHTML = genre.charAt(0).toUpperCase() + genre.slice(1);
        document.getElementById('genre-container').style.display = 'block';


    }


    const container = document.querySelector('.albums-container .container-fluid');
});

const navigateToAlbum = (event, artistName, albumName) => {
    if (artistName && albumName) {
        const encodedArtist = encodeURIComponent(artistName).replace(/%20/g, '+');
        const encodedTitle = encodeURIComponent(albumName).replace(/%20/g, '+');
        window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
    }
}

const navigateToArtist = (event, artistName) => {
    event.stopPropagation();
    if (artistName) {
        const encodedArtist = encodeURIComponent(artistName).replace(/%20/g, '+');
        window.location.href = `/artist/${encodedArtist}`;
    }
}

const fetchAlbums = async (query = '') => {
    try {
        const response = await fetch(`/api/albums?search=${encodeURIComponent(query)}`);
        if (response.ok) {
            const albums = await response.json();
            updateAlbumsGrid(albums);
        } else {
            updateAlbumsGrid([]);
        }
    } catch (error) {
        updateAlbumsGrid([]);
    }
}

const updateAlbumsGrid = (albums) => {
    const albumsContainer = document.getElementById('albums-row');
    albumsContainer.innerHTML = albums.length > 0
        ? albums.map(album => `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" role="listitem" onclick="navigateToAlbum(event, '${album.artistName}', '${album.albumName}')">
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

const isGenrePage = () => {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.has('genre');
}
