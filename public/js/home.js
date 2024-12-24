const UrlForAlbum = (artist, title) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
}

const UrlForArtist = (artist) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}`;
}