<?php

namespace S246109\BeatMagazine\Factories;

use PDO;
use S246109\BeatMagazine\Models\Album;
use S246109\BeatMagazine\Models\Song;

class UserFactory
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    
}