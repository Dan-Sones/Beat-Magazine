document.addEventListener('DOMContentLoaded', () => {

    const submitReviewButton = document.getElementById('submitReview');
    const submitReviewWrapper = document.getElementById('submitReviewWrapper');

    if (!activeSession) {
        submitReviewWrapper.setAttribute("data-bs-title", 'You must be logged in to submit a review');
        submitReviewButton.disabled = true;
    } else if (activeSession) {
        if (leftReview) {
            submitReviewWrapper.setAttribute("data-bs-title", 'You have already left a review for this album');
            submitReviewButton.disabled = true;
        }
    }
});


const handleReviewSubmission = async (event) => {
    event.preventDefault();
    const rating = document.getElementById('reviewRating').value;
    const review = document.getElementById('reviewText').value;

    if (rating === 'Select a rating') {
        Swal.fire({
            title: 'Please select a rating',
            icon: 'error',
            confirmButtonText: 'Got It'
        });
        return;
    }


    return await fetch(`/api/albums/${albumId}/reviews`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            rating: rating,
            review: review
        })
    }).then(response => {
        if (response.status === 201) {
            Swal.fire({
                title: 'Review submitted successfully',
                icon: 'success',
                confirmButtonText: 'Ok!'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'An error occurred while submitting your review',
                icon: 'error',
                confirmButtonText: 'Got It'
            });
        }
    });
};
