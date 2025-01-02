const handleEditJournalistReview = () => {
    document.getElementById('modal-journalistReviewRating').value = document.getElementById('journalistReviewRating').textContent;
    document.getElementById('modal-journalistAbstractText').value = document.getElementById('journalistReviewAbstractText').textContent;
    document.getElementById('modal-journalistReviewText').value = document.getElementById('journalistReviewText').innerHTML;
    document.getElementById('preview').innerHTML = document.getElementById('journalistReviewText').innerHTML;
    document.getElementById('journalistReviewForm').onsubmit = editJournalistReview;

    const reviewEditorModal = new bootstrap.Modal(document.getElementById('reviewEditor'));
    reviewEditorModal.show();
}

const handleDeleteJournalistReview = async () => {
    try {
        const response = await fetch(`/api/albums/${albumIdGlobal}/journalist-reviews`, {
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
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                title: 'An error occurred while deleting your review',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary btn-lg',
                    loader: 'custom-loader'
                },
            });
        }
    } catch (error) {
        Swal.fire({
            title: `Network error occurred while deleting your review ${error}`,
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary btn-lg',
                loader: 'custom-loader'
            },
        });
    }
}

const URLForJournalist = (username) => {
    const encodedUsername = encodeURIComponent(username).replace(/%20/g, '+');
    window.location.href = `/user/${encodedUsername}`;
}

document.addEventListener('DOMContentLoaded', () => {
    const reviewCard = document.querySelector('.review-card');
    const readMoreBtn = reviewCard.querySelector('.read-more-btn');
    const fullReviewContainer = reviewCard.querySelector('.review-full-container');

    const animateHeight = (element, action) => {
        if (action === 'expand') {
            element.style.height = element.scrollHeight + 'px';

            element.addEventListener('transitionend', () => {
                element.style.height = 'auto';
            }, {once: true});
        } else if (action === 'collapse') {
            element.style.height = element.scrollHeight + 'px';

            element.offsetHeight;
            element.style.height = '0';
        }
    };

    if (readMoreBtn) {
        readMoreBtn.addEventListener('click', () => {
            if (fullReviewContainer.style.height === '0px' || fullReviewContainer.style.height === '') {
                animateHeight(fullReviewContainer, 'expand');
                readMoreBtn.textContent = 'Read Less';
            } else {
                animateHeight(fullReviewContainer, 'collapse');
                readMoreBtn.textContent = 'Read More';
            }
        });
    }


});