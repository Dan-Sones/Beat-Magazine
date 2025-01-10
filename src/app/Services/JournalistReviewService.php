<?php

namespace S246109\BeatMagazine\Services;

use PDO;

class JournalistReviewService
{

    private PDO $db;

    private JournalistService $journalistService;

    /**
     * @param PDO $db
     * @param JournalistService $journalistService
     */
    public function __construct(PDO $db, JournalistService $journalistService)
    {
        $this->db = $db;
        $this->journalistService = $journalistService;
    }


    public function getJournalistUserIdForReview(string $albumId): string
    {

        $query = 'SELECT users.id FROM journalist_reviews INNER JOIN journalists ON journalist_reviews.journalist_id = journalists.id INNER JOIN users ON journalists.user_id = users.id WHERE album_id = :album_id ';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->execute();


        return $statement->fetchColumn();
    }

    public function hasJournalistReviewForAlbum(string $albumId): bool
    {
        $query = 'SELECT COUNT(*) FROM journalist_reviews WHERE album_id = :album_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchColumn() > 0;

    }

    public function createJournalistReviewForAlbum(string $albumId, string $userId, string $review, string $rating, string $abstract): bool
    {

        $journalistId = $this->journalistService->getJournalistIDByUserID($userId);

        $query = 'INSERT INTO journalist_reviews (album_id, journalist_id, abstract, full_review, rating) VALUES (:album_id, :journalist_id, :abstract, :full_review, :rating)';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->bindValue(':journalist_id', $journalistId, PDO::PARAM_STR);
        $statement->bindValue(':abstract', $abstract, PDO::PARAM_STR);
        $statement->bindValue(':full_review', $review, PDO::PARAM_STR);
        $statement->bindValue(':rating', $rating, PDO::PARAM_STR);

        return $statement->execute();

    }

    public function deleteJournalistReviewForAlbum(string $albumId): bool
    {
        $query = 'DELETE FROM journalist_reviews WHERE album_id = :album_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        return $statement->execute();
    }

    public function updateJournalistReviewForAlbum(string $albumId, string $review, string $rating, string $abstract): bool
    {
        $query = 'UPDATE journalist_reviews SET abstract = :abstract, full_review = :full_review, rating = :rating WHERE album_id = :album_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->bindValue(':abstract', $abstract, PDO::PARAM_STR);
        $statement->bindValue(':full_review', $review, PDO::PARAM_STR);
        $statement->bindValue(':rating', $rating, PDO::PARAM_STR);
        return $statement->execute();
    }


}