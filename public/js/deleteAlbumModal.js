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
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                icon: 'error',
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'Network error occurred while deleting album',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            icon: 'error',
        });
    }
};