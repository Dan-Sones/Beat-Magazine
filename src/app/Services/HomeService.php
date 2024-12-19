<?php

namespace S246109\BeatMagazine\Services;

use S246109\BeatMagazine\Factories\AlbumFactory;
use S246109\BeatMagazine\Factories\JournalistReviewFactory;

class HomeService
{
    private AlbumFactory $albumFactory;
    private JournalistReviewFactory $journalistReviewFactory;

    /**
     * @param AlbumFactory $albumFactory
     * @param JournalistReviewFactory $journalistReviewFactory
     */
    public function __construct(AlbumFactory $albumFactory, JournalistReviewFactory $journalistReviewFactory)
    {
        $this->albumFactory = $albumFactory;
        $this->journalistReviewFactory = $journalistReviewFactory;
    }

    public function getMostRecentJournalistReviewsForHome(int $reviewCount = 5): array
    {
        $reviews = $this->journalistReviewFactory->getMostRecentJournalistReviews($reviewCount);

        if (empty($reviews)) {
            return [];
        }

        $albumIds = array_map(fn($review) => $review->getAlbumId(), $reviews);
        $albums = $this->albumFactory->getAlbumsByIdsMappedByIds($albumIds);


        // Create a new array of reviews with the album data attached
        $reviewsWithAlbumData = [];
        foreach ($reviews as $review) {

            $reviewsWithAlbumData[] = [
                'review' => $review,
                'album' => $albums[$review->getAlbumId()]
            ];
        }
        return $reviewsWithAlbumData;

    }


}