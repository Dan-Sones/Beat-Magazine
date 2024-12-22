<?php include 'includes/loadHeader.php'; ?>

    <main class="albums-container" role="main">
        <div class="container-fluid grid-container">
            <div class="row justify-content-center my-4 search-row">
                <div class="col-10 col-md-8 col-lg-6">
                    <form class="d-flex" role="search" aria-label="Search albums and artists">
                        <label for="search" class="visually-hidden">Search by album or artist name</label>
                        <input class="form-control me-2" type="search"
                               placeholder="Search by album or artist name"
                               aria-label="Search" id="search">
                    </form>
                </div>
            </div>

            <div class="row px-5 gy-5" id="albums-row" role="list">
                <?php if (isset($albums) && is_array($albums)): ?>
                    <?php foreach ($albums as $album): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2" role="listitem">
                            <div class="card shadow album-card" style="width: 100%;" tabindex="0">
                                <img src="<?= htmlspecialchars($album->getAlbumArt()) ?>" class="card-img-top"
                                     alt="<?= htmlspecialchars($album->getAlbumName()) ?>">
                                <div class="card-body">
                                    <h4 class="card-title album-title"><?= htmlspecialchars($album->getAlbumName()) ?></h4>
                                    <p class="card-text album-artist"><?= htmlspecialchars($album->getArtistName()) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No albums available.</p>
                <?php endif; ?>
            </div>
            <?php if (isset($isJournalist) && $isJournalist) : ?>

                <div class="row p-5">
                    <div class="col-12 text-center">
                        <button class="btn btn-primary" onclick="window.location.href = '/create-album'">Create an
                            album
                        </button>
                    </div>
                </div>
            <?php endif; ?>
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
                const isJournalist = <?= json_encode($isJournalist) ?>;
                if (isJournalist) {
                    return '<p class="text-center">No albums found for this search term. <a href="/create-album">Create an album</a></p>';
                }
                return '<p class="text-center">No albums found for this search term</p>';
            }
        </script>
    </main>

<?php include 'includes/footer.php'; ?>