<?php

require_once "Repository.php";
require_once __DIR__.'/../models/Photo.php';

class PhotoRepository extends Repository
{
    public function getPhoto(int $id): ?Photo
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Photos" WHERE "Id" = :id
        ');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $photo = $stmt->fetch(PDO::FETCH_ASSOC);


        if(!$photo){
            return null;
        }
        else{
            return new Photo($photo['Name'], $photo['Image']);
        }
    }

    public function addPhoto(Photo $photo): void
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."Photos"("Name", "Image") VALUES(?, ?)
        ');
        $stmt->execute([
            $photo->getName(),
            $photo->getImage()
        ]);
    }
}