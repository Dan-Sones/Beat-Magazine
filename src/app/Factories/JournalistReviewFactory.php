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
            $journalist
        );
    }


}