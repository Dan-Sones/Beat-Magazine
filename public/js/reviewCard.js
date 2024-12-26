const handleEditReview = (reviewID) => {
    const reviewText = document.getElementById('userReviewText-' + reviewID);
    reviewText.style.display = 'none';

    const editForm = document.getElementById('editUserReview-' + reviewID);
    editForm.style.display = 'block';
}

const handleCancelEditReview = (reviewID) => {
    const reviewText = document.getElementById('userReviewText-' + reviewID);
    reviewText.style.display = 'block';

    const editForm = document.getElementById('editUserReview-' + reviewID);
    editForm.style.display = 'none';
}

const handleSubmitEditReview = async (event, reviewId) => {
    event.preventDefault();
    const rating = document.getElementById(`updateReviewRating-${reviewId}`).value;
    const review = document.getElementById(`updatedReviewText-${reviewId}`).value;

    console.log(rating, review);

    const albumId = albumIdGlobal;

    return await fetch(`/api/albums/${albumId}/reviews/${reviewId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            rating: rating,
            review: review,
        })
    }).then(response => {
        if (response.status === 200) {
            alert('Review Edited successfully');
            location.reload();
        } else {
            alert('An error occurred whilst updating your review');
        }
    });
};

const handleDeleteReview = async (reviewId) => {
    return await fetch(`/api/albums/${albumIdGlobal}/reviews/${reviewId}`, {
        method: 'DELETE'
    }).then(response => {
        if (response.status === 200) {
            alert('Review successfully deleted.');
            location.reload();
        } else {
            alert('An error occurred whilst deleting your review');
        }
    });

};

const handleLikeReview = async (reviewId) => {
    return await fetch(`/api/albums/${albumIdGlobal}/reviews/${reviewId}/like`, {
        method: 'POST'
    }).then(response => {
        if (response.status === 200) {
            location.reload();
        } else {
            alert('An error occurred whilst liking the review');
        }
    });

};

const handleUnlikeReview = async (reviewId) => {
    return await fetch(`/api/albums/${albumIdGlobal}/reviews/${reviewId}/unlike`, {
        method: 'DELETE'
    }).then(response => {
        if (response.status === 200) {
            location.reload();
        } else {
            alert('An error occurred whilst unliking the review');
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
});

