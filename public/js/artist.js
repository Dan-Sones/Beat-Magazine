const navigateToAlbum = (artist, title) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
}

const navigateToJournalist = (event, journalistUsername) => {
    event.stopPropagation()
    const encodedJournalist = encodeURIComponent(journalistUsername).replace(/%20/g, '+');
    window.location.href = `/user/${encodedJournalist}`;
}

const navigateToGenre = (genre) => {
    console.log("TOoo")
    const encodedGenre = encodeURIComponent(genre).replace(/%20/g, '+');
    window.location.href = `/albums?genre=${encodedGenre}`;
}