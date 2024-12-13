<?php include 'includes/loadHeader.php'; ?>

    <main class="albums-container">
        <div class="container-fluid grid-container">
            <div class="row justify-content-center my-4 search-row">
                <div class="col-10 col-md-8 col-lg-6">

                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search"
                               placeholder="Search by album or artist name"
                               aria-label="Search" id="search">
                    </form>
                </div>
            </div>

            <div class="row px-5 gy-5" id="albums-row">
                <?php if (isset($albums) && is_array($albums)): ?>
                    <?php foreach ($albums as $album): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                            <div class="card shadow album-card" style="width: 100%;">
                                <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>" class="card-img-top"
                                     alt="<?= $album->getAlbumName() ?>">
                                <div class="card-body">
                                    <h4 class="card-title album-title"><?= $album->getAlbumName() ?></h4>
                                    <p class="card-text album-artist"><?= $album->getArtistName() ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No albums available.</p>
                <?php endif; ?>
            </div>
        </div>

        <script>

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
                    const card = event.target.closest('.album-card');
                    if (card) {
                        const artist = card.querySelector('.album-artist').textContent;
                        const title = card.querySelector('.album-title').textContent;
                        const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
                        const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
                        window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
                    }
                });
            });

            const fetchAlbums = (query = '') => {
                fetch(`/api/albums?search=${encodeURIComponent(query)}`)
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            console.error('Failed to fetch albums');
                        }
                    })
                    .then(albums => {
                        if (albums) {
                            updateAlbumsGrid(albums);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            const updateAlbumsGrid = (albums) => {
                const albumsContainer = document.getElementById('albums-row');
                albumsContainer.innerHTML = albums.length > 0
                    ? albums.map(album => `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card shadow album-card" style="width: 100%;">
                    <img src="${album.albumArt}" class="card-img-top" alt="${album.albumName}">
                    <div class="card-body">
                        <h4 class="card-title album-title">${album.albumName}</h4>
                        <p class="card-text album-artist">${album.artistName}</p>
                    </div>
                </div>
            </div>
        `).join('')
                    : '<p>No albums found for this search term.</p>';
            }


        </script>
    </main>

<?php include 'includes/footer.php'; ?>