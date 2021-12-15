<?php

require_once "Repository.php";
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../models/Permissions.php';

class UserRepository extends Repository
{
    public function insertUser(string $email, string $pass)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."Users"("Email", "Pass") VALUES(?, ?);
        ');
        $stmt->execute([
            $email,
            $pass
        ]);
    }

    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Users" WHERE "Email" = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if(!$user){
            return null;
        }
        else{
            return new User($user['Email'], $user['Pass']);
        }
    }

    public function getUserId(string $email): ?int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Users" WHERE "Email" = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);


        if(!$user){
            return null;
        }
        else{
            return $user['Id'];
        }
    }

    public function getUserPermissions(int $uid): ?Permissions
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public."Permissions" WHERE "UserId" = ?
        ');
        $stmt->execute([$uid]);

        $perm = $stmt->fetch(PDO::FETCH_ASSOC);


        if(!$perm){
            return null;
        }
        else{
            return new Permissions($perm['Upload'], $perm['Remove'], $perm['Fav'], $perm['Share']);
        }
    }

    public function getUserAlbumId(int $uid): ?int
    {
        $stmt = $this->database->connect()->prepare('
            SELECT "Id" FROM public."Albums" WHERE "OwnerId" = ?;
        ');
        $stmt->execute([$uid]);

        $aid = $stmt->fetch(PDO::FETCH_ASSOC);


        if(!$aid){
            return null;
        }
        else{
            return $aid['Id'];
        }
    }
}