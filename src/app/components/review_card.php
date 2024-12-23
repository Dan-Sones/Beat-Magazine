<?php if (isset($userReview)): ?>

    <div class="col-12">
        <div class="card shadow-sm" id="userReview-<?= $userReview->getId() ?>">
            <div class="container p-3 ps-4">
                <div class="row">
                    <!--                                                Mobile layout-->
                    <div class="col-12 d-flex align-items-center d-md-none order-1 pb-3">
                        <img src="<?= $userReview->getUser()->getProfilePictureUri() ?>"
                             class="img-fluid rounded-circle"
                             style="width: 60px; height: 60px; object-fit: cover"
                             alt="profilePicture for <?= $userReview->getUser()->getUsername() ?>">
                        <div class="ms-2">
                            <a href="/user/<?= $userReview->getUser()->getUsername() ?>"
                               class="text-center pt-1"><?= $userReview->getUser()->getUsername() ?></a>
                            <p class="mb-0"
                               style="font-size: 0.8rem;"><?= $userReview->getRating() ?>
                                /10</p>
                        </div>
                    </div>
                    <!--                                                desktop layout-->
                    <div class="col-12 col-md-3 d-none d-md-flex flex-column align-items-center order-md-1 d-flex justify-content-center">
                        <img src="<?= $userReview->getUser()->getProfilePictureUri() ?>"
                             class="img-fluid rounded-circle"
                             style="width: 120px; height: 120px; object-fit: cover"
                             alt="profilePicture
                                                             for <?= $userReview->getUser()->getUsername() ?>">
                        <a href="/user/<?= $userReview->getUser()->getUsername() ?>"
                           class="text-center pt-3"><?= $userReview->getUser()->getUsername() ?></a>
                    </div>
                    <div class="col-md-2 align-items-center justify-content-center d-none d-md-flex order-2 order-md-2">
                        <h3><?= $userReview->getRating() ?>/10</h3>
                    </div>
                    <div class="col-12 col-md-6 order-3 order-md-3 d-flex justify-content-center align-items-center mb-0">
                        <p class="mb-0"
                           id="userReviewText-<?= $userReview->getId() ?>"><?= $userReview->getReview() ?></p>
                        <?php if (isset($userID) && (int)$userID === (int)$userReview->getUser()->getId()): ?>
                            <form class="p-2 rounded w-100"
                                  id="editUserReview-<?= $userReview->getId() ?>"
                                  style="display: none"
                                  onsubmit="handleSubmitEditReview(event, <?= $userReview->getId() ?>)">
                                <div class="mb-3">
                                    <label for="updateReviewRating-<?= $userReview->getId() ?>"
                                           class="form-label">Updated Rating</label>
                                    <select class="form-select"
                                            id="updateReviewRating-<?= $userReview->getId() ?>">
                                        <option value="1" <?= $userReview->getRating() == 1 ? 'selected' : '' ?>>
                                            1
                                        </option>
                                        <option value="2" <?= $userReview->getRating() == 2 ? 'selected' : '' ?>>
                                            2
                                        </option>
                                        <option value="3" <?= $userReview->getRating() == 3 ? 'selected' : '' ?>>
                                            3
                                        </option>
                                        <option value="4" <?= $userReview->getRating() == 4 ? 'selected' : '' ?>>
                                            4
                                        </option>
                                        <option value="5" <?= $userReview->getRating() == 5 ? 'selected' : '' ?>>
                                            5
                                        </option>
                                        <option value="6" <?= $userReview->getRating() == 6 ? 'selected' : '' ?>>
                                            6
                                        </option>
                                        <option value="7" <?= $userReview->getRating() == 7 ? 'selected' : '' ?>>
                                            7
                                        </option>
                                        <option value="8" <?= $userReview->getRating() == 8 ? 'selected' : '' ?>>
                                            8
                                        </option>
                                        <option value="9" <?= $userReview->getRating() == 9 ? 'selected' : '' ?>>
                                            9
                                        </option>
                                        <option value="10" <?= $userReview->getRating() == 10 ? 'selected' : '' ?>>
                                            10
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="updatedReviewText"
                                           class="form-label">Updated Review</label>
                                    <textarea class="form-control"
                                              id="updatedReviewText-<?= $userReview->getId() ?>"
                                              rows="5"><?= $userReview->getReview() ?></textarea>
                                </div>
                                <div class="d-grid"
                                     id="submitUpdatedReviewWrapper-<?= $userReview->getId() ?>"
                                     data-toggle="tooltip">
                                    <button id="submitUpdateReview-<?= $userReview->getId() ?>"
                                            type="submit"
                                            class="btn btn-primary mb-1">Submit
                                        Review
                                    </button>

                                    <button type="button" class="btn btn-secondary"
                                            onclick="handleCancelEditReview(<?= $userReview->getId() ?>)">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($userID) && (int)$userID === (int)$userReview->getUser()->getId()): ?>
                        <div class="col-1 d-flex justify-content-center align-items-center order-4 order-md-4">
                            <button class="btn btn-link text-muted mb-0"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-danger"
                                       onclick="handleDeleteReview(<?= $userReview->getId() ?>)">Delete
                                        Review</a></li>
                                <li><a class="dropdown-item"
                                       onclick="handleEditReview(<?= $userReview->getId() ?>)">Edit
                                        Review</a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

<?php endif; ?>