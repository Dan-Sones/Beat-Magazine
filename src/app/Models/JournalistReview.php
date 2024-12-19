<?php

namespace S246109\BeatMagazine\Models;

class JournalistReview
{

    private string $id;
    private int $rating;
    private string $abstract;
    private string $review;
    private Journalist $journalist;
    private string $albumId;

    /**
     * @param string $id
     * @param int $rating
     * @param string $abstract
     * @param string $review
     * @param Journalist $journalist
     * @param string $albumId
     */
    public function __construct(string $id, int $rating, string $abstract, string $review, Journalist $journalist, string $albumId)
    {
        $this->id = $id;
        $this->rating = $rating;
        $this->abstract = $abstract;
        $this->review = $review;
        $this->journalist = $journalist;
        $this->albumId = $albumId;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
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