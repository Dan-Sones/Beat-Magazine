<?php

namespace S246109\BeatMagazine\Services;

use PDO;

class LikeService
{
    protected PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function likeReview(string $reviewId, string $userId): bool
    {
        $query = '
            INSERT INTO likes (review_id, user_id)
            VALUES (:review_id, :user_id)
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':review_id', $reviewId, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        return $statement->execute();
    }

    public function unlikeReview(string $reviewId, string $userId): bool
    {
        $query = '
            DELETE FROM likes
            WHERE review_id = :review_id
            AND user_id = :user_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':review_id', $reviewId, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        return $statement->execute();
    }

    public function hasUserLikedReview(string $reviewId, string $userId): bool
    {
        $query = '
            SELECT COUNT(*) as count
            FROM likes
            WHERE review_id = :review_id
            AND user_id = :user_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':review_id', $reviewId, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    public function getLikedReviewsPerAlbum(string $albumId, string $userId): array
    {
        $query = '
            SELECT review_id
            FROM likes
            JOIN user_reviews ON likes.review_id = user_reviews.id
            WHERE user_reviews.album_id = :album_id
            AND likes.user_id = :user_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $statement->execute();

        $likedReviews = [];

        while ($review = $statement->fetch(PDO::FETCH_ASSOC)) {
            $likedReviews[] = $review['review_id'];
        }

        return $likedReviews;
    }

}