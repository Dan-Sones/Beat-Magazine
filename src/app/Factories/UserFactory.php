<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Song;
use S246109\BeatMagazine\Models\User;

class UserFactory
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
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

}