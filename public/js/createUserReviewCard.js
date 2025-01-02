document.addEventListener('DOMContentLoaded', () => {
    const submitReviewButton = document.getElementById('submitReview');
    const submitReviewWrapper = document.getElementById('submitReviewWrapper');

    const reviewText = document.getElementById('reviewText');
    const maxChars = 1000;
    const charCountDisplay = document.createElement('div');
    charCountDisplay.id = 'charCount';
    reviewText.parentNode.insertBefore(charCountDisplay, reviewText.nextSibling);
    charCountDisplay.setAttribute("class", "mt-3")
    charCountDisplay.textContent = `0 / ${maxChars} characters`


    if (!activeSession) {
        submitReviewWrapper.setAttribute("data-bs-title", 'You must be logged in to submit a review');
        submitReviewButton.disabled = true;
    } else if (activeSession) {
        if (leftReview) {
            submitReviewWrapper.setAttribute("data-bs-title", 'You have already left a review for this album');
            submitReviewButton.disabled = true;
        }
    }

    reviewText.addEventListener('input', () => {
        const charCount = reviewText.value.length;
        charCountDisplay.textContent = `${charCount} / ${maxChars} characters`;

        if (charCount > maxChars) {
            reviewText.value = reviewText.value.substring(0, maxChars);
            charCountDisplay.textContent = `${maxChars} / ${maxChars} characters`;
        }
    });
});

const handleReviewSubmission = async (event) => {
    event.preventDefault();
    const rating = document.getElementById('reviewRating').value;
    const review = document.getElementById('reviewText').value;

    if (rating === 'Select a rating') {
        Swal.fire({
            title: 'Please select a rating',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            confirmButtonText: 'Got It'
        });
        return;
    }

    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/reviews`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                rating: rating,
                review: review
            })
        });

        if (response.status === 201) {
            Swal.fire({
                title: 'Review submitted successfully',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                confirmButtonText: 'Ok!'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'An error occurred while submitting your review',
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
            title: 'Network error occurred while submitting your review',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            confirmButtonText: 'Got It'
        });
    }
};