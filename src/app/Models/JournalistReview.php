<?php

namespace S246109\BeatMagazine\Models;

class JournalistReview
{

    private int $rating;
    private string $review;
    private Journalist $journalist;

    /**
     * @param int $rating
     * @param string $review
     * @param Journalist $journalist
     */
    public function __construct(int $rating, string $review, Journalist $journalist)
    {
        $this->rating = $rating;
        $this->review = $review;
        $this->journalist = $journalist;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function getJournalist(): Journalist
    {
        return $this->journalist;
    }


}