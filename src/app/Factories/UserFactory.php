<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\PublicUserViewModel;
use S246109\BeatMagazine\Models\Song;
use S246109\BeatMagazine\Models\User;

class UserFactory
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function getPublicUserByUsername(string $username): ?PublicUserViewModel
    {
        $query = 'SELECT profile_picture, id FROM users WHERE username = :username LIMIT 1';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();

        $userInfo = $statement->fetch();

        if ($userInfo === false) {
            return null;
        }

        return new PublicUserViewModel(
            $username,
            $userInfo['profile_picture'] ?? '',
            (int)$userInfo['id']
        );
    }

    public function getPublicUserByUserId(int $id): ?PublicUserViewModel
    {
        $query = 'SELECT profile_picture, username FROM users WHERE id = :id LIMIT 1';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();

        $userInfo = $statement->fetch();

        if ($userInfo === false) {
            return null;
        }

        return new PublicUserViewModel(
            $userInfo['username'],
            $userInfo['profile_picture'] ?? '',
            $id
        );

    }

    public function getUserByUsername(string $username): ?User
    {
        $query = 'SELECT * FROM users WHERE username = :username LIMIT 1';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();

        $userInfo = $statement->fetch();

        if ($userInfo === false) {
            return null;
        }

        return new User(
            $userInfo['id'],
            $userInfo['email'],
            $userInfo['username'],
            $userInfo['first_name'],
            $userInfo['last_name'],
            $userInfo['password']
        );
    }

    public function getUserByEmailAddress(string $email): ?User
    {
        $query = 'SELECT * FROM users WHERE email = :email LIMIT 1';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $userInfo = $statement->fetch();

        if ($userInfo === false) {
            return null;
        }

        return new User(
            $userInfo['id'],
            $userInfo['email'],
            $userInfo['username'],
            $userInfo['first_name'],
            $userInfo['last_name'],
            $userInfo['password']
        );
    }

}