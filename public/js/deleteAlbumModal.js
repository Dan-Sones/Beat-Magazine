const deleteAlbum = async (event, albumId) => {
    event.preventDefault();
    try {
        const response = await fetch(`/api/albums/${albumId}`, {
            method: 'DELETE',
        });

        if (response.ok) {
            window.location.href = '/albums';
        } else {
            Swal.fire({
                title: 'Failed to delete album',
                icon: 'error',
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Network error occurred while deleting album',
            icon: 'error',
        });
    }
};