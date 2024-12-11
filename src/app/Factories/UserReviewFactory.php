<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Journalist;
use S246109\BeatMagazine\Models\JournalistReview;
use S246109\BeatMagazine\Models\Song;
use S246109\BeatMagazine\Models\UserReview;

class UserReviewFactory
{
    private PDO $db;

    private UserFactory $userFactory;

    /**
     * @param PDO $db
     * @param UserFactory $userFactory
     */
    public function __construct(PDO $db, UserFactory $userFactory)
    {
        $this->db = $db;
        $this->userFactory = $userFactory;
    }


    public function getAllUserReviewsForAlbum(string $albumId): array
    {
        $query = '
            SELECT 
                user_reviews.id, 
                user_reviews.album_id, 
                user_reviews.user_id, 
                user_reviews.review_text, 
                user_reviews.rating
            FROM user_reviews
            WHERE user_reviews.album_id = :album_id
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':album_id', $albumId, PDO::PARAM_STR);
        $statement->execute();

        $userReviews = [];

        while ($userReviewData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $user = $this->userFactory->getPublicUserByUserId($userReviewData['user_id']);
            $review = new UserReview($userReviewData['id'], $userReviewData['album_id'], $user, $userReviewData['review_text'], $userReviewData['rating']);
            $userReviews[] = $review;
        }

        return $userReviews;

    }

}