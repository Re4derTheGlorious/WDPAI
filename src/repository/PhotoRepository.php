<?php

require_once "Repository.php";
require_once __DIR__.'/../models/Photo.php';

class PhotoRepository extends Repository
{
    public function isInFavs(int $uid, int $pid):bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*)>0 AS "Result" FROM "AlbumPhotos" ap
            JOIN "Albums" al ON al."Id"=ap."AlbumId"
            WHERE al."OwnerId"=? AND ap."PhotoId"=?;
        ');
        $stmt->execute([$uid, $pid]);

        return $stmt->fetch(PDO::FETCH_ASSOC)["Result"];
    }

    public function fav(int $uid, int $pid): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM favourite(?, ?);
        ');
        $stmt->execute([$uid, $pid]);

        return $stmt->fetch(PDO::FETCH_ASSOC)["favourite"];
    }

    public function cyclePhotos(int $position, int $albumId, int $direction): ?int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT "PhotoId"
            FROM public."AlbumPhotos"
            WHERE "AlbumId"=?
            OFFSET ?%(SELECT COUNT(*) FROM public."AlbumPhotos" WHERE "AlbumId"=?)
            LIMIT 1
        ');
        $stmt->execute([
            $albumId,
            abs($position+$direction),
            $albumId
        ]);

        $next = $stmt->fetch(PDO::FETCH_ASSOC);


        if(!$next){
            return null;
        }
        else{
            return $next['PhotoId'];
        }
    }

    public function getPhoto(int $id): ?Photo
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Photos" WHERE "Id"=?;
        ');
        $stmt->execute([$id]);

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