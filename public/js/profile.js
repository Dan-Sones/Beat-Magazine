const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')

const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

const container = document.getElementById('reviews-container');

container.addEventListener('click', (event) => {
    const card = event.target.closest('.album-review');
    if (card) {
        const artist = card.querySelector('#album-artist').textContent;
        const title = card.querySelector('#album-title').textContent;
        const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
        const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
        window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
    } else {
    }
});

const UrlForAlbum = (artist, title) => {
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    const encodedTitle = encodeURIComponent(title).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}/${encodedTitle}`;
}

const UrlForArtist = (event, artist) => {
    event.stopPropagation();
    const encodedArtist = encodeURIComponent(artist).replace(/%20/g, '+');
    window.location.href = `/artist/${encodedArtist}`;
}

const handleUpdateBio = () => {
    const reviewEditorModal = new bootstrap.Modal(document.getElementById('bioEditorModal'));
    reviewEditorModal.show();
};


// Show the file upload dialog when the profile picture is clicked - Because the file input is hidden
document.getElementById('profilePicture').addEventListener('click', function () {
    document.getElementById('profilePictureInput').click();
});

document.getElementById('profilePictureInput').addEventListener('change', function () {
    handleUpload();
});

const handleUpload = () => {
    const fileInput = document.getElementById('profilePictureInput');
    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('profile_picture', file);

    const response = fetch('/api/upload-profile-picture', {
        method: 'POST',
        body: formData
    });

    if (response.ok) {
        window.location.reload();
    } else {
        Swal.fire({
            title: 'An error occurred while uploading your profile picture',
            icon: 'error',
        });
    }
};