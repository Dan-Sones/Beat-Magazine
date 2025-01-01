document.addEventListener('DOMContentLoaded', () => {
    const reviewText = document.getElementById('journalistReviewText');
    const preview = document.getElementById('preview');

    reviewText.addEventListener('input', () => {
        preview.innerHTML = reviewText.value;
    });

    const reviewForm = document.getElementById('journalistReviewForm');
    reviewForm.onsubmit = submitJournalistReview;
});

const submitJournalistReview = async (event) => {
    event.preventDefault();

    const rating = document.getElementById('journalistReviewRating').value;
    const abstract = document.getElementById('journalistAbstractText').value;
    const review = document.getElementById('journalistReviewText').value;

    try {
        const response = await fetch(`/api/albums/${albumId}/journalist-reviews`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                rating: rating,
                abstract: abstract,
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
            title: 'An error occurred while submitting your review',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
            confirmButtonText: 'Got It'
        });
    }
};

const editJournalistReview = async (event) => {
    event.preventDefault();

    const rating = document.getElementById('journalistReviewRating').value;
    const abstract = document.getElementById('journalistAbstractText').value;
    const review = document.getElementById('journalistReviewText').value;

    try {
        const response = await fetch(`/api/albums/${albumId}/journalist-reviews`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                rating: rating,
                abstract: abstract,
                review: review
            })
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
                location.reload();
            });
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

    // reset the default onSubmit
    document.querySelector('form').onsubmit = submitJournalistReview;
};