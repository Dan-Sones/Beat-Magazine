const handleEditReview = (reviewID) => {
    const reviewText = document.getElementById('userReviewText-' + reviewID);
    reviewText.style.display = 'none';

    const editForm = document.getElementById('editUserReview-' + reviewID);
    editForm.style.display = 'block';
};

const handleCancelEditReview = (reviewID) => {
    const reviewText = document.getElementById('userReviewText-' + reviewID);
    reviewText.style.display = 'block';

    const editForm = document.getElementById('editUserReview-' + reviewID);
    editForm.style.display = 'none';
};

const handleSubmitEditReview = async (event, reviewId) => {
    event.preventDefault();
    const rating = document.getElementById(`updateReviewRating-${reviewId}`).value;
    const review = document.getElementById(`updatedReviewText-${reviewId}`).value;

    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/reviews/${reviewId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({rating, review})
        });

        if (response.status === 200) {
            Swal.fire({
                title: 'Review updated successfully',
                icon: 'success',
                confirmButtonText: 'Got It'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'An error occurred while updating your review',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred while updating your review',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
};

const handleDeleteReview = async (reviewId) => {
    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/reviews/${reviewId}`, {
            method: 'DELETE'
        });

        if (response.status === 200) {
            Swal.fire({
                title: 'Review deleted successfully',
                icon: 'success',
                confirmButtonText: 'Got It'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'An error occurred while deleting your review',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred while deleting your review',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
    }
};

const handleLikeReview = async (reviewId) => {
    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/reviews/${reviewId}/like`, {
            method: 'POST'
        });

        if (response.status === 200) {
            location.reload();
        } else {
            Swal.fire({
                title: 'An error occurred whilst liking the review',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred whilst liking the review',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    }
};

const handleUnlikeReview = async (reviewId) => {
    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/reviews/${reviewId}/unlike`, {
            method: 'DELETE'
        });

        if (response.status === 200) {
            location.reload();
        } else {
            Swal.fire({
                title: 'An error occurred whilst unliking the review',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred whilst unliking the review',
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});