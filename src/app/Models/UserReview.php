<?php

namespace S246109\BeatMagazine\Models;

class UserReview
{
    private string $id;
    private string $albumId;
    private string $userId;
    private string $review;
    private string $rating;

    /**
     * @param string $id
     * @param string $albumId
     * @param string $userId
     * @param string $review
     * @param string $rating
     */
    public function __construct(string $id, string $albumId, string $userId, string $review, string $rating)
    {
        $this->id = $id;
        $this->albumId = $albumId;
        $this->userId = $userId;
        $this->review = $review;
        $this->rating = $rating;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function getRating(): string
    {
        return $this->rating;
    }

}