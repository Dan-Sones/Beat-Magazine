<?php

namespace S246109\BeatMagazine\Models;

class UserReview
{
    private string $id;
    private string $albumId;
    private PublicUserViewModel $User;
    private string $review;
    private string $rating;
    private string $likesCount;

    /**
     * @param string $id
     * @param string $albumId
     * @param PublicUserViewModel $User
     * @param string $review
     * @param string $rating
     * @param string $likes
     */
    public function __construct(string $id, string $albumId, PublicUserViewModel $User, string $review, string $rating, string $likesCount)
    {
        $this->id = $id;
        $this->albumId = $albumId;
        $this->User = $User;
        $this->review = $review;
        $this->rating = $rating;
        $this->likesCount = $likesCount;
    }

    public function getLikeCount(): string
    {
        return $this->likesCount;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }

    public function getUser(): PublicUserViewModel
    {
        return $this->User;
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