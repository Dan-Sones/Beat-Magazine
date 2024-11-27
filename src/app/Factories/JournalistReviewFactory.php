<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Journalist;
use S246109\BeatMagazine\Models\JournalistReview;
use S246109\BeatMagazine\Models\Song;

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
        journalist_reviews.review AS review_text,
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

        $journalistReviewData = $statement->fetchAll(PDO::FETCH_ASSOC);


        $journalist = new Journalist(
            $journalistReviewData[0]['journalist_full_name'],
            $journalistReviewData[0]['journalist_profile_picture'],
            $journalistReviewData[0]['journalist_bio']
        );


        return new JournalistReview(
            $journalistReviewData[0]['review_rating'],
            $journalistReviewData[0]['review_text'],
            $journalist
        );
    }


}