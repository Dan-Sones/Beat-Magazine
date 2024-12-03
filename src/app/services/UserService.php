<?php

namespace S246109\BeatMagazine\services;

use PDO;

class UserService
{
    private PDO $db;

    /**
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function registerUser(string $email, string $username, string $password, string $firstName, string $lastName, string $google2fa_secret): void
    {
        $query = '
            INSERT INTO users (email, username, password, first_name, last_name, google2fa_secret)
            VALUES (:email, :username, :password, :first_name, :last_name, :google2fa_secret)
        ';

        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
        $statement->bindValue(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindValue(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindValue(':google2fa_secret', $google2fa_secret, PDO::PARAM_STR);
        $statement->execute();
    }

    public function isUsernameTaken(string $username): bool
    {
        $query = 'SELECT COUNT(*) FROM users WHERE username = :username';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

    public function isEmailTaken(string $email): bool
    {
        $query = 'SELECT COUNT(*) FROM users WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchColumn() > 0;
    }

}