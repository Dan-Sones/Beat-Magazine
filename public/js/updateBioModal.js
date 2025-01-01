document.addEventListener('DOMContentLoaded', () => {
    const placeholder = document.getElementById('newBioText');
    placeholder.value = getJournalistBio();
});

const getJournalistBio = () => {
    return journalistBio;
};

const updateBio = async (event, userId) => {
    event.preventDefault();
    const newBio = document.getElementById('newBioText').value;

    try {
        const response = await fetch(`/api/profile/${userId}/journalist/bio`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                bio: newBio
            })
        });

        if (response.ok) {
            Swal.fire({
                title: 'Bio updated successfully',
                icon: 'success',
                confirmButtonText: 'Got It'
            }).then(() => {
                window.location.reload();
            })
        } else {
            Swal.fire({
                title: 'An error occurred while updating your bio',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred while updating your bio',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            confirmButtonText: 'Got It'
        });
    }
};