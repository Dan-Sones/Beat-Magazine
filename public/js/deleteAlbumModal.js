const deleteAlbum = (event, albumId) => {
    event.preventDefault();
    fetch(`/api/albums/${albumId}`, {
        method: 'DELETE',
    })
        .then(response => {
            if (response.ok) {
                window.location.href = '/albums';
            }
        });
}