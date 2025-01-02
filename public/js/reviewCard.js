const handleEditReview = (reviewID) => {
    const editForm = document.getElementById('editUserReview-' + reviewID);
    const reviewText = document.getElementById('userReviewText-' + reviewID);

    reviewText.style.display = 'none';
    editForm.style.display = 'block';


    const updatedReviewText = document.getElementById('updatedReviewText-' + reviewID)
    const maxChars = 1000;

    const charCountDisplay = document.createElement('div');
    charCountDisplay.id = `charCount-${reviewID}`;
    charCountDisplay.setAttribute("class", "mt-3")
    updatedReviewText.parentNode.insertBefore(charCountDisplay, updatedReviewText.nextSibling);
    charCountDisplay.textContent = `${reviewText.textContent.length} / ${maxChars} characters`


    updatedReviewText.addEventListener('input', () => {
        const charCount = updatedReviewText.value.length;
        charCountDisplay.textContent = `${charCount} / ${maxChars} characters`;

        if (charCount > maxChars) {
            updatedReviewText.value = updatedReviewText.value.substring(0, maxChars);
            charCountDisplay.textContent = `${maxChars} / ${maxChars} characters`;
        }
    });

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
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                confirmButtonText: 'Got It'
            }).then(() => {
                updateReviewToHaveEditContents(reviewId, rating, review);
            })
        } else {
            Swal.fire({
                title: 'An error occurred while updating your review',
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
            title: 'An error occurred while updating your review',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
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
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                confirmButtonText: 'Got It'
            }).then(() => {
                dontShowDeletedReview(reviewId);
            });
        } else {
            Swal.fire({
                title: 'An error occurred while deleting your review',
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
            title: 'An error occurred while deleting your review',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
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
            updateCardToHaveShowLike(reviewId, true);
        } else {
            Swal.fire({
                title: 'An error occurred whilst liking the review',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                confirmButtonText: 'Ok'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred whilst liking the review',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
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
            updateCardToHaveShowLike(reviewId, false);
        } else {
            Swal.fire({
                title: 'An error occurred whilst unliking the review',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
                confirmButtonText: 'Ok'
            });
        }
    } catch (error) {
        Swal.fire({
            title: 'An error occurred whilst unliking the review',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            confirmButtonText: 'Ok'
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});

const updateCardToHaveShowLike = (reviewId, liked) => {

    if (typeof liked !== "boolean") {
        return;
    }

    const likeButton = document.getElementById(`likeReviewDiv-${reviewId}`);
    const likeCount = document.getElementById(`likeCount-${reviewId}`);

    if (liked) {
        likeCount.innerText = String(parseInt(likeCount.innerText) + 1);
        likeButton.innerHTML = `<i  onclick="handleUnlikeReview(${reviewId})" class="bi bi-hand-thumbs-up-fill text-primary like-cursor"></i>
   `;
    } else {
        likeCount.innerText = String(parseInt(likeCount.innerText) - 1);
        likeButton.innerHTML = `<i onclick="handleLikeReview(${reviewId})" class="bi bi-hand-thumbs-up like-cursor"></i>`;
    }
}

const updateReviewToHaveEditContents = (reviewID, rating, review) => {

    const userReviewText = document.getElementById('userReviewText-' + reviewID);
    const userReviewRating = document.getElementById('userReviewRating-' + reviewID);

    userReviewText.innerHTML = review;
    userReviewRating.innerHTML = `${rating}/10`;


    const reviewText = document.getElementById('userReviewText-' + reviewID);
    reviewText.style.display = 'block';

    const editForm = document.getElementById('editUserReview-' + reviewID);
    editForm.style.display = 'none';
}

const dontShowDeletedReview = (reviewID) => {
    const review = document.getElementById('userReview-' + reviewID);
    review.style.display = 'none';
}