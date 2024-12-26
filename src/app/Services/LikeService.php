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

    public function getLikesForReview(string $reviewId): int
    {
        $query = '
            SELECT COUNT(*) as count
            FROM likes
            WHERE review_id = :review_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':review_id', $reviewId, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['count'];
    }

}