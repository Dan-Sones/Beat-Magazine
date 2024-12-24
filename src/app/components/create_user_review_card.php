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
        const leftReview = <?= isset($hasUserLeftReview) && $hasUserLeftReview ? 'true' : 'false' ?>;
        const activeSession = <?= isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true ? 'true' : 'false' ?>;
        const albumId = <?= $album->getAlbumID() ?>;
    </script>

    <script src="/js/create-user-review-card.js"></script>
<?php endif; ?>