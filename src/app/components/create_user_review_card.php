<?php if (isset($album)): ?>
    <div class="row gy-3">
    <div class="col-12">
        <!--                        If the user is logged in-->
        <div class="card shadow-sm">
            <form class="p-4 shadow-sm rounded" onsubmit="handleReviewSubmission(event)">
                <div class="mb-3">
                    <label for="reviewRating" class="form-label">Rating</label>
                    <select class="form-select" id="reviewRating" required>
                        <option value="">Select a rating</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="reviewText" class="form-label">Review</label>
                    <textarea class="form-control" id="reviewText" rows="5"
                              placeholder="Write your review here"></textarea>
                </div>
                <div class="d-grid" id="submitReviewWrapper" data-toggle="tooltip">
                    <button id="submitReview" type="submit"
                            class="btn btn-primary">Submit
                        Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', () => {
            const activeSession = <?= isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true ? 'true' : 'false' ?>;

            const submitReviewButton = document.getElementById('submitReview');
            const submitReviewWrapper = document.getElementById('submitReviewWrapper');

            if (!activeSession) {
                submitReviewButton.disabled = true;
                submitReviewWrapper.title = 'You must be logged in to submit a review';

            } else if (activeSession) {
                const leftReview = <?= isset($hasUserLeftReview) && $hasUserLeftReview ? 'true' : 'false' ?>;

                if (leftReview) {
                    submitReviewButton.disabled = true;
                    submitReviewWrapper.title = 'You have already left a review for this album';
                }

            }


        });


        // TODO: Check if the user has already submitted a review for this album before allowing them to submit another
        // This should also be checked on the backend in the event the user manually removes the disabled attribute

        const handleReviewSubmission = async (event) => {
            event.preventDefault();
            const rating = document.getElementById('reviewRating').value;
            const review = document.getElementById('reviewText').value;

            if (rating === 'Select a rating') {
                alert('Please select a valid rating.');
                return;
            }

            const albumId = <?= $album->getAlbumID() ?>;

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
    </script>
<?php endif; ?>