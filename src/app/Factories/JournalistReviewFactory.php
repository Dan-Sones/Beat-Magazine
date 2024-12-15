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
        CONCAT(journalists.first_name, " ", journalists.last_name) AS journalist_full_name,
        journalists.profile_picture AS journalist_profile_picture,
        journalists.bio AS journalist_bio
    FROM journalist_reviews
    INNER JOIN journalists ON journalist_reviews.journalist_id = journalists.id
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
            $journalistReviewData['journalist_full_name'],
            $journalistReviewData['journalist_profile_picture'],
            $journalistReviewData['journalist_bio']
        );


        return new JournalistReview(
            $journalistReviewData['review_rating'],
            $journalistReviewData['review_abstract'],
            $journalistReviewData['review_text'],
            $journalist
        );
    }


}