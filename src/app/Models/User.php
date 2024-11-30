<?php

namespace S246109\BeatMagazine\Models;

use PDO;

class User
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

}