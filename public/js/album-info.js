const UrlForArtist = (artist) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}`;
}

const handleDeleteAlbumIntention = () => {
    const modal = new bootstrap.Modal(document.getElementById('deleteAlbumModal'));
    modal.show();
}