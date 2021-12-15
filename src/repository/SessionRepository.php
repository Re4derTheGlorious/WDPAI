<?php

require_once "Repository.php";

class SessionRepository extends Repository
{
    public function checkToken(string $token): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT COUNT(*)>0 AS "Result" FROM public."Sessions" WHERE "Token"=?;
        ');
        $stmt->execute([$token]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC)["Result"];

        return !!$res;
    }

    public function findSession(int $userId): string
    {
        $stmt = $this->database->connect()->prepare('
            SELECT "Token" FROM public."Sessions" WHERE "UserId"=?;
        ');
        $stmt->execute([$userId]);

        $token = $stmt->fetch(PDO::FETCH_ASSOC)["Token"];

        if(!$token){
            return '';
        }
        else{
            return $token;
        }
    }

    public function insertSession(string $token, int $userId)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."Sessions"("Token", "UserId") VALUES(?, ?);
        ');
        $stmt->execute([
            $token,
            $userId
        ]);
    }

    public function getUserId(string $token){
        $stmt = $this->database->connect()->prepare('
            SELECT "UserId" FROM public."Sessions" WHERE "Token"=?;
        ');
        $stmt->execute([$token]);

        $uid = $stmt->fetch(PDO::FETCH_ASSOC)["UserId"];

        if(!$uid){
            return '';
        }
        else{
            return $uid;
        }
    }
}