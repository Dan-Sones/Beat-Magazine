<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Journalist;
use S246109\BeatMagazine\Models\JournalistReview;

class JournalistReviewFactory
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getMostRecentJournalistReviews(int $count): array
    {
        $query = '
    SELECT 
        journalist_reviews.id AS review_id,
        journalist_reviews.rating AS review_rating,
        journalist_reviews.abstract AS review_abstract,
        journalist_reviews.full_review AS review_text,
        journalist_reviews.album_id,
        users.first_name AS journalist_first_name,
        users.last_name AS journalist_last_name,
        users.profile_picture AS journalist_profile_picture,
        journalists.bio AS journalist_bio,
        journalists.id AS journalist_id,
        users.created_at,
        users.id AS user_id,
        users.username
    FROM journalist_reviews
    INNER JOIN journalists ON journalist_reviews.journalist_id = journalists.id
    INNER JOIN users ON users.id = journalists.user_id
    ORDER BY journalist_reviews.published_at DESC
    LIMIT :count
';

        $statement = $this->db->prepare($query);
        $statement->bindParam(':count', $count, PDO::PARAM_INT);
        $statement->execute();

        $journalistReviewData = $statement->fetchAll(PDO::FETCH_ASSOC);

        $journalistReviews = [];

        foreach ($journalistReviewData as $journalistReview) {
            $journalist = new Journalist(
                $journalistReview['journalist_first_name'],
                $journalistReview['journalist_last_name'],
                $journalistReview['journalist_bio'],
                $journalistReview['username'],
                $journalistReview['journalist_profile_picture'],
                $journalistReview['user_id'],
                $journalistReview['created_at']
            );

            $journalistReviews[] = new JournalistReview(
                $journalistReview['review_id'],
                $journalistReview['review_rating'],
                $journalistReview['review_abstract'],
                $journalistReview['review_text'],
                $journalist,
                $journalistReview['album_id']
            );
        }

        return $journalistReviews;

    }


    public function getJournalistReviewForAlbum(int $albumId): ?JournalistReview
    {

        $query = '
    SELECT 
        journalist_reviews.id AS review_id,
        journalist_reviews.rating AS review_rating,
        journalist_reviews.abstract AS review_abstract,
        journalist_reviews.full_review AS review_text,
        users.first_name AS journalist_first_name,
        users.last_name AS journalist_last_name,
        users.profile_picture AS journalist_profile_picture,
        journalists.bio AS journalist_bio,
         journalists.id AS journalist_id,
        users.created_at,
         users.id AS user_id,
         users.username
    FROM journalist_reviews
    INNER JOIN journalists ON journalist_reviews.journalist_id = journalists.id
    INNER JOIN users ON users.id = journalists.user_id
    WHERE journalist_reviews.album_id = :album_id LIMIT 1
';

        $statement = $this->db->prepare($query);
        $statement->bindParam(':album_id', $albumId, PDO::PARAM_INT);
        $statement->execute();

        $journalistReviewData = $statement->fetch(PDO::FETCH_ASSOC);


        if ($journalistReviewData === false) {
            return null;
        }

        $journalist = new Journalist(
            $journalistReviewData['journalist_first_name'],
            $journalistReviewData['journalist_last_name'],
            $journalistReviewData['journalist_bio'],
            $journalistReviewData['username'],
            $journalistReviewData['journalist_profile_picture'],
            $journalistReviewData['user_id'],
            $journalistReviewData['created_at']
        );


        return new JournalistReview(
            $journalistReviewData['review_id'],
            $journalistReviewData['review_rating'],
            $journalistReviewData['review_abstract'],
            $journalistReviewData['review_text'],
            $journalist,
            $albumId
        );
    }

    public function getAllJournalistReviewsForJournalist(int $journalistId): ?array
    {
        $query = '
        SELECT
            journalist_reviews.id AS review_id,
            journalist_reviews.rating AS review_rating,
            journalist_reviews.abstract AS review_abstract,
            journalist_reviews.full_review AS review_text,
            journalist_reviews.album_id,
            users.first_name AS journalist_first_name,
            users.last_name AS journalist_last_name,
            users.profile_picture AS journalist_profile_picture,
            journalists.bio AS journalist_bio,
            journalists.id AS journalist_id,
            users.created_at,
            users.id AS user_id,
            users.username FROM journalist_reviews INNER JOIN journalists ON journalist_reviews.journalist_id = journalists.id
             INNER JOIN users ON users.id = journalists.user_id
             WHERE users.id = :journalist_id
             ORDER BY journalist_reviews.published_at DESC';

        $statement = $this->db->prepare($query);
        $statement->bindParam(':journalist_id', $journalistId, PDO::PARAM_INT);
        $success = $statement->execute();

        if (!$success) {
            return null;
        }

        $journalistReviewData = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (empty($journalistReviewData)) {
            return null;
        }

        $journalistReviews = [];

        foreach ($journalistReviewData as $journalistReview) {
            $journalist = new Journalist(
                $journalistReview['journalist_first_name'],
                $journalistReview['journalist_last_name'],
                $journalistReview['journalist_bio'],
                $journalistReview['username'],
                $journalistReview['journalist_profile_picture'],
                $journalistReview['user_id'],
                $journalistReview['created_at']
            );

            $journalistReviews[] = new JournalistReview(
                $journalistReview['review_id'],
                $journalistReview['review_rating'],
                $journalistReview['review_abstract'],
                $journalistReview['review_text'],
                $journalist,
                $journalistReview['album_id']
            );
        }

        return $journalistReviews;


    }

}