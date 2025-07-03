<?php

namespace S246109\BeatMagazine\Models;

class Song
{
    private int $id;
    private string $name;
    private string $length;

    /**
     * @param int $id
     * @param string $name
     * @param string $length
     */
    public function __construct(int $id, string $name, string $length)
    {
        $this->id = $id;
        $this->name = $name;
        $this->length = $length;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLength(): string
    {
        return $this->length;
    }


}