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

    return await fetch(`/api/albums/${albumId}/journalist-reviews`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            rating: rating,
            abstract: abstract,
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
}

const editJournalistReview = async (event) => {
    event.preventDefault();

    const rating = document.getElementById('journalistReviewRating').value;
    const abstract = document.getElementById('journalistAbstractText').value;
    const review = document.getElementById('journalistReviewText').value;


    await fetch(`/api/albums/${albumId}/journalist-reviews`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            rating: rating,
            abstract: abstract,
            review: review
        })
    }).then(response => {
        if (response.status === 200) {
            alert('Review edited successfully');
            location.reload();
        } else {
            alert('An error occurred while editing your review');
        }
    });

    // reset the default onSubmit
    document.querySelector('form').onsubmit = submitJournalistReview;
}