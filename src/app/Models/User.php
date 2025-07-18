<?php

namespace S246109\BeatMagazine\Models;

use PDO;
use S246109\BeatMagazine\Services\UserService;

class User
{
    private int $id;
    private string $email;
    private string $username;
    private string $firstName;
    private string $lastName;
    private string $password;
    private string $role;

    /**
     * @param int $id
     * @param string $email
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param string $role
     */
    public function __construct(int $id, string $email, string $username, string $firstName, string $lastName, string $password, string $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->role = $role;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}