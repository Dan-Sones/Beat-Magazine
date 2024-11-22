<?php

namespace S246109\BeatMagazine\Models;

class Song
{
    private $id;
    private $name;
    private $length;

    /**
     * @param $id
     * @param $name
     * @param $length
     */
    public function __construct($id, $name, $length)
    {
        $this->id = $id;
        $this->name = $name;
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }


}