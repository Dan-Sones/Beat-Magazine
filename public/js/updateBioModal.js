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
        window.location.reload();
    } else {
        Swal.fire({
            title: 'An error occurred while updating your bio',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
};