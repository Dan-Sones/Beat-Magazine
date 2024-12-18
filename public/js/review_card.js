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
    const albumId = albumIdGlobal;

    return await fetch(`/api/albums/${albumId}/reviews/${reviewId}`, {
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