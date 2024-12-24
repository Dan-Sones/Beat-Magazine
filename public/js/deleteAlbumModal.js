const deleteAlbum = (event, albumId) => {
    event.preventDefault();
    console.log(albumId);
    fetch(`/api/albums/${albumId}`, {
        method: 'DELETE',
    })
        .then(response => {
            if (response.ok) {
                window.location.href = '/albums';
            }
        });
}