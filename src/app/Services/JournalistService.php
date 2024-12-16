<?php

namespace S246109\BeatMagazine\Services;

use PDO;
use S246109\BeatMagazine\Services\UserService;

class JournalistService extends UserService
{
    public function upgradeUser(string $username): void
    {
        $query = 'UPDATE users SET role = :role WHERE username = :username';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':role', 'journalist', PDO::PARAM_STR);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();
    }


    public function getJournalistIDByUserID(string $userID): string|null
    {
        $query = 'SELECT id FROM journalists WHERE user_id = :user_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userID, PDO::PARAM_STR);
        $statement->execute();

        if ($journalistID = $statement->fetchColumn()) {
            return $journalistID;
        }
        return null;

    }


    public function validateUpgradePassword(string $input): bool
    {
        $password = $_ENV['UPGRADE_PASSWORD'];
        if ($password === $input) {
            return true;
        }
        return false;

    }

}