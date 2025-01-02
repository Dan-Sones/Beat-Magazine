<?php if (isset($album)) : ?>
    <div class="modal fade" id="reviewEditor" tabindex="-1" aria-labelledby="reviewEditorModal" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-xl">
            <form id="journalistReviewForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Review Editor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body review-modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-6 justify-content-center align-items-center d-flex ps-0 ">
                                    <div class="mb-3 w-100">
                                        <label for="modal-journalistReviewRating" class="form-label">Rating</label>
                                        <select class="form-select" id="modal-journalistReviewRating" required>
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

                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="modal-journalistAbstractText" class="form-label">Abstract</label>
                                        <textarea class="form-control" id="modal-journalistAbstractText" rows="5"
                                                  placeholder="Write your abstract here" required></textarea>
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-6" id="editor">
                                        <div class="mb-3">
                                            <label for="modal-journalistReviewText" class="form-label">Review
                                                Text</label>
                                            <textarea class="form-control" id="modal-journalistReviewText" rows="15"
                                                      placeholder="Write your review here using HTML5 and see a live preview to the right"
                                                      required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6 review-modal-review-preview" id="preview">

                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button id="submitJournalistReview" type="submit"
                                class="btn btn-primary">Publish Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/js/reviewEditorModal.js"></script>

<?php endif; ?>