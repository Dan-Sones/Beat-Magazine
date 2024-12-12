<?php

namespace S246109\BeatMagazine\Models;

class UserReview
{
    private string $id;
    private string $albumId;
    private PublicUserViewModel $User;
    private string $review;
    private string $rating;

    /**
     * @param string $id
     * @param string $albumId
     * @param PublicUserViewModel $User
     * @param string $review
     * @param string $rating
     */
    public function __construct(string $id, string $albumId, PublicUserViewModel $User, string $review, string $rating)
    {
        $this->id = $id;
        $this->albumId = $albumId;
        $this->User = $User;
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