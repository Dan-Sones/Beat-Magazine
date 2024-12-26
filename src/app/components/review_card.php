<?php if (isset($userReview)): ?>

    <div class="col-12">
        <div class="card shadow-sm" id="userReview-<?= htmlspecialchars($userReview->getId()) ?>">
            <div class="container p-3 ps-4">
                <div class="row">
                    <!-- Mobile layout -->
                    <div class="col-12 d-flex align-items-center d-md-none order-1 pb-3">
                        <img src="<?= htmlspecialchars($userReview->getUser()->getProfilePictureUri()) ?>"
                             class="img-fluid rounded-circle"
                             style="width: 60px; height: 60px; object-fit: cover"
                             alt="profilePicture for <?= htmlspecialchars($userReview->getUser()->getUsername()) ?>">
                        <div class="ms-2">
                            <a href="/user/<?= htmlspecialchars($userReview->getUser()->getUsername()) ?>"
                               class="text-center pt-1"><?= htmlspecialchars($userReview->getUser()->getUsername()) ?></a>
                            <p class="mb-0"
                               style="font-size: 0.8rem;"><?= htmlspecialchars($userReview->getRating()) ?>
                                /10</p>
                        </div>
                    </div>
                    <!-- Desktop layout -->
                    <div class="col-12 col-md-3 d-none d-md-flex flex-column align-items-center order-md-1 d-flex justify-content-center">
                        <img src="<?= htmlspecialchars($userReview->getUser()->getProfilePictureUri()) ?>"
                             class="img-fluid rounded-circle"
                             style="width: 120px; height: 120px; object-fit: cover"
                             alt="profilePicture for <?= htmlspecialchars($userReview->getUser()->getUsername()) ?>">
                        <a href="/user/<?= htmlspecialchars($userReview->getUser()->getUsername()) ?>"
                           class="text-center pt-3"><?= htmlspecialchars($userReview->getUser()->getUsername()) ?></a>
                    </div>
                    <div class="col-md-2 align-items-center justify-content-center d-none d-md-flex order-2 order-md-2">
                        <h3><?= htmlspecialchars($userReview->getRating()) ?>/10</h3>
                    </div>
                    <div class="col-12 col-md-6 order-3 order-md-3 d-flex justify-content-center align-items-center mb-0">
                        <p class="mb-0"
                           id="userReviewText-<?= htmlspecialchars($userReview->getId()) ?>"><?= htmlspecialchars($userReview->getReview()) ?></p>
                        <?php if (isset($userID) && (int)$userID === (int)$userReview->getUser()->getId()): ?>
                            <form class="p-2 rounded w-100"
                                  id="editUserReview-<?= htmlspecialchars($userReview->getId()) ?>"
                                  style="display: none"
                                  onsubmit="handleSubmitEditReview(event, <?= htmlspecialchars($userReview->getId()) ?>)">
                                <div class="mb-3">
                                    <label for="updateReviewRating-<?= htmlspecialchars($userReview->getId()) ?>"
                                           class="form-label">Updated Rating</label>
                                    <select class="form-select"
                                            id="updateReviewRating-<?= htmlspecialchars($userReview->getId()) ?>">
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
                                    <label for="updatedReviewText-<?= htmlspecialchars($userReview->getId()) ?>"
                                           class="form-label">Updated Review</label>
                                    <textarea class="form-control"
                                              id="updatedReviewText-<?= htmlspecialchars($userReview->getId()) ?>"
                                              rows="5"><?= htmlspecialchars($userReview->getReview()) ?></textarea>
                                </div>
                                <div class="d-grid"
                                     id="submitUpdatedReviewWrapper-<?= htmlspecialchars($userReview->getId()) ?>"
                                     data-toggle="tooltip">
                                    <button id="submitUpdateReview-<?= htmlspecialchars($userReview->getId()) ?>"
                                            type="submit"
                                            class="btn btn-primary mb-1">Submit
                                        Review
                                    </button>

                                    <button type="button" class="btn btn-secondary"
                                            onclick="handleCancelEditReview(<?= htmlspecialchars($userReview->getId()) ?>)">
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
                                       onclick="handleDeleteReview(<?= htmlspecialchars($userReview->getId()) ?>)">Delete
                                        Review</a></li>
                                <li><a class="dropdown-item"
                                       onclick="handleEditReview(<?= htmlspecialchars($userReview->getId()) ?>)">Edit
                                        Review</a>
                                </li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="col-12 col-md-1 d-flex justify-content-center align-items-center order-5 order-md-5">

                        <p><?= htmlspecialchars($userReview->getLikeCount()) ?></p>

                        <?php if (isset($userID) && isset($authenticated) && $authenticated): ?>

                            <?php if (isset($likedReviewsForUser)): ?>
                                <?php if (in_array($userReview->getId(), $likedReviewsForUser)): ?>
                                    <i onclick="handleUnlikeReview('<?= htmlspecialchars($userReview->getId()) ?>')"
                                       class="bi bi-hand-thumbs-up-fill"></i>
                                <?php else: ?>
                                    <i onclick="handleLikeReview('<?= htmlspecialchars($userReview->getId()) ?>')"
                                       class="bi bi-hand-thumbs-up"></i>
                                <?php endif; ?>

                            <?php endif; ?>


                        <?php else: ?>
                            <i class="bi bi-hand-thumbs-up" data-bs-toggle="tooltip"
                               data-bs-title="You must be logged in to like reviews"></i>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--    <i class="bi bi-hand-thumbs-up-fill"></i>-->
    <!--    <i class="bi bi-hand-thumbs-up"></i>-->

<?php endif; ?>