<?php

namespace S246109\BeatMagazine\Services;

use PDO;

class JournalistReviewService
{

    private PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function hasJournalistReviewForAlbum(string $albumId): bool
    {
        $query = 'SELECT COUNT(*) FROM journalist_reviews WHERE album_id = :album_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn() > 0;

    }

    public function createJournalistReviewForAlbum(string $albumId, string $userId, string $review, string $rating): bool
    {
        $query = '
            INSERT INTO journalist_reviews (album_id, journalist_id, abstract, full_review, rating)
            VALUES (:album_id, :journalist_id, :abstract, :full_review, :rating)
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->bindValue(':journalist_id', $userId, PDO::PARAM_STR);
        $statement->bindValue(':abstract', $review, PDO::PARAM_STR);
        $statement->bindValue(':full_review', $review, PDO::PARAM_STR);
        $statement->bindValue(':rating', $rating, PDO::PARAM_STR);

        return $statement->execute();

    }


}