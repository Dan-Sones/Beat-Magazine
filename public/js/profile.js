const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

const container = document.getElementById('reviews-container');


const navigateToAlbum = (artist, title) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
}

const UrlForAlbum = (artist, title) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
};

const UrlForArtist = (event, artist) => {
    event.stopPropagation();
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}`;
};

const handleUpdateBio = () => {
    const bioEditorModal = new bootstrap.Modal(document.getElementById('bioEditorModal'));
    bioEditorModal.show();
};

// Show the file upload dialog when the profile picture is clicked - Because the file input is hidden
document.getElementById('profilePicture').addEventListener('click', function () {
    document.getElementById('profilePictureInput').click();
});

document.getElementById('profilePictureInput').addEventListener('change', function () {
    handleUpload();
});

const handleUpload = async () => {
    const fileInput = document.getElementById('profilePictureInput');
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('profile_picture', file);

    try {
        const response = await fetch('/api/upload-profile-picture', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            Swal.fire({
                title: 'Profile picture uploaded successfully',
                icon: 'success',
                confirmButtonText: 'Got It',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                }
            }).then(() => {
                window.location.reload();
            })

        } else {
            Swal.fire({
                title: 'An error occurred while uploading your profile picture',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred while uploading your profile picture',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
        });
    }
};