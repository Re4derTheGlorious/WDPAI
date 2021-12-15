<?php

class Permissions
{
    private $upload;
    private $remove;
    private $fav;
    private $share;

    public function __construct($upload, $remove, $fav, $share)
    {
        $this->upload = $upload;
        $this->remove = $remove;
        $this->fav = $fav;
        $this->share = $share;
    }

    public function getPermString():string
    {
        return ($this->upload?'1':'0').($this->remove?'1':'0').($this->fav?'1':'0').($this->share?'1':'0');
    }

    public function setUpload($upload)
    {
        $this->upload = $upload;
    }

    public function setImage($remove)
    {
        $this->remove = $remove;
    }

    public function setFav($fav)
    {
        $this->fav = $fav;
    }

    public function setShare($share)
    {
        $this->share = $share;
    }

    public function getUpload(): bool
    {
        return $this->upload;
    }

    public function getRemove(): bool
    {
        return $this->remove;
    }

    public function getFav(): bool
    {
        return $this->fav;
    }

    public function getShare(): bool
    {
        return $this->share;
    }
}