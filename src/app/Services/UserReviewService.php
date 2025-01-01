<?php

namespace S246109\BeatMagazine\Services;

use PDO;

class UserReviewService
{
    private PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    
    public function CreateReviewForAlbum(string $albumId, string $userId, string $review, string $rating): bool
    {
        $query = '
            INSERT INTO user_reviews (album_id, user_id, review_text, rating)
            VALUES (:album_id, :user_id, :review, :rating)
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $statement->bindValue(':review', $review, PDO::PARAM_STR);
        $statement->bindValue(':rating', $rating, PDO::PARAM_STR);

        return $statement->execute();

    }

    public function HasUserLeftReviewForAlbum(string $albumId, $userId): bool
    {
        $query = '
            SELECT COUNT(*) FROM user_reviews WHERE album_id = :album_id AND user_id = :user_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn() > 0;
    }

    public function updateReviewForAlbum(string $albumId, string $userId, string $review, string $rating): bool
    {
        $query = '
            UPDATE user_reviews
            SET review_text = :review, rating = :rating
            WHERE album_id = :album_id AND user_id = :user_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $statement->bindValue(':review', $review, PDO::PARAM_STR);
        $statement->bindValue(':rating', $rating, PDO::PARAM_STR);

        return $statement->execute();
    }


    public function doesUserOwnReview(int $reviewId, string $userId, string $albumId): bool
    {
        $query = '
        SELECT COUNT(*) FROM user_reviews WHERE id = :review_id AND user_id = :user_id AND album_id = :album_id
    ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':review_id', $reviewId, PDO::PARAM_INT);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchColumn();

        return $result > 0;
    }

    public function DeleteReviewForAlbum(int $reviewId): bool
    {
        $query = '
            DELETE FROM user_reviews WHERE id = :review_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':review_id', $reviewId, PDO::PARAM_INT);

        return $statement->execute();
    }

    public function getAverageUserRatingForAlbum($albumId): int|null
    {
        $query = '
            SELECT CAST(AVG(rating) AS UNSIGNED) FROM user_reviews WHERE album_id = :album_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn();
    }
}