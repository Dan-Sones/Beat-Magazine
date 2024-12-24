<?php

namespace S246109\BeatMagazine\Services;

use PDO;
use S246109\BeatMagazine\Services\UserService;

class JournalistService extends UserService
{
    public function upgradeUser(string $userId): void
    {
        $query = 'UPDATE users SET role = :role WHERE id = :user_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':role', 'journalist', PDO::PARAM_STR);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
        $statement->execute();

        $query = 'INSERT INTO journalists (user_id) VALUES (:user_id)';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':user_id', $userId, PDO::PARAM_STR);
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

    public function getJournalistBio(string $userId): string|null
    {
        $query = 'SELECT bio FROM journalists WHERE user_id = :journalist_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':journalist_id', $userId, PDO::PARAM_STR);
        $statement->execute();

        if ($bio = $statement->fetchColumn()) {
            return $bio;
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

    public function updateBio(string $journalistID, string $bio): bool
    {
        $query = 'UPDATE journalists SET bio = :bio WHERE id = :journalist_id';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':bio', $bio, PDO::PARAM_STR);
        $statement->bindValue(':journalist_id', $journalistID, PDO::PARAM_STR);
        return $statement->execute();
    }

}