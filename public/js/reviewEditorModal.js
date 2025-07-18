document.addEventListener('DOMContentLoaded', () => {
    const reviewText = document.getElementById('modal-journalistReviewText');
    const preview = document.getElementById('preview');

    reviewText.addEventListener('input', () => {
        preview.innerHTML = reviewText.value;
    });

    const reviewForm = document.getElementById('journalistReviewForm');
    reviewForm.onsubmit = submitJournalistReview;
});

const submitJournalistReview = async (event) => {
    event.preventDefault();

    const rating = document.getElementById('modal-journalistReviewRating').value;
    const abstract = document.getElementById('modal-journalistAbstractText').value;
    const review = document.getElementById('modal-journalistReviewText').value;

    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/journalist-reviews`, {
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

    const rating = document.getElementById('modal-journalistReviewRating').value;
    const abstract = document.getElementById('modal-journalistAbstractText').value;
    const review = document.getElementById('modal-journalistReviewText').value;

    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/journalist-reviews`, {
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
                hideReviewModal()
                updateJournalistReviewContents(rating, abstract, review);
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
            title: `An error occurred ${error}`,
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

const hideReviewModal = () => {
    const reviewEditorModal = bootstrap.Modal.getInstance(document.getElementById('reviewEditor'));
    reviewEditorModal.hide();
}

const updateJournalistReviewContents = (reviewRating, reviewAbstract, reviewText) => {
    document.getElementById('journalistReviewRating').innerHTML = `${reviewRating}/10`;
    document.getElementById('journalistReviewAbstractText').innerHTML = reviewAbstract;
    document.getElementById('journalistReviewText').innerHTML = reviewText;
}