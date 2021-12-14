<?php

class Photo
{
    private $name;
    private $image;

    public function __construct($name, $image)
    {
        $this->name = $name;
        $this->image = $image;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}