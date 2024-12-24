document.addEventListener('DOMContentLoaded', () => {

    const submitReviewButton = document.getElementById('submitReview');
    const submitReviewWrapper = document.getElementById('submitReviewWrapper');

    if (!activeSession) {
        submitReviewButton.disabled = true;
        submitReviewWrapper.title = 'You must be logged in to submit a review';

    } else if (activeSession) {

        if (leftReview) {
            submitReviewButton.disabled = true;
            submitReviewWrapper.title = 'You have already left a review for this album';
        }

    }


});


const handleReviewSubmission = async (event) => {
    event.preventDefault();
    const rating = document.getElementById('reviewRating').value;
    const review = document.getElementById('reviewText').value;

    if (rating === 'Select a rating') {
        alert('Please select a valid rating.');
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
            alert('Review submitted successfully');
            location.reload();
        } else {
            alert('An error occurred while submitting your review');
        }
    });
};