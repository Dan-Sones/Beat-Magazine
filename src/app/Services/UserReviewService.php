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


}