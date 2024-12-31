const UrlForArtist = (artist) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}`;
}

const handleDeleteAlbumIntention = () => {
    const modal = new bootstrap.Modal(document.getElementById('deleteAlbumModal'));
    modal.show();
}

const UrlForGenre = (genre) => {
    console.log("TOoo")
    const encodedGenre = encodeURIComponent(genre).replace(/%20/g, '+');
    window.location.href = `/albums?genre=${encodedGenre}`;
}