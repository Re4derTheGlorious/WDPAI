<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/../repository/UserRepository.php';
require_once __DIR__ .'/../repository/SessionRepository.php';

class SecurityController extends AppController {

    private $urep;
    private $srep;

    public function __construct()
    {
        parent::__construct();
        $this->urep = new UserRepository();
        $this->srep = new SessionRepository();
    }

    public function signUp(){
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if($contentType==='application/json'){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');

            $pass_hash = md5($decoded['pass']);
            $email = $decoded['email'];
            $perm = '0000';
            $message = '';

            if(!$email || !$decoded['pass'] || !$pass_hash){
                $message = "Invalid data received!";
                http_response_code(418);
            }
            else if($this->urep->getUser($email)){
                $message = "User already exists!";
                http_response_code(418);
            }
            else{
                //Insert new user
                $this->urep->insertUser($email, $pass_hash);

                //Insert new session
                $token = $this->genToken();

                $id = $this->urep->getUserId($email);
                $this->srep->insertSession($token, $id);

                $perm = $this->urep->getUserPermissions($id)->getPermString();
                $message=$token;
                http_response_code(200);
            }

            $response = "{\"message\": \"$message\", \"perm\": \"$perm\"}";
            echo $response;
        }
    }

    public function signIn()
    {
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if($contentType==='application/json'){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');

            $pass_hash = md5($decoded['pass']);
            $email = $decoded['email'];
            $user = $this->urep->getUser($email);
            $message = '';
            $perm = '0000';

            if(!$user){
                $message = "User does not exist";
                http_response_code(418);
            }
            else if ($user->getPassword() !== $pass_hash) {
                $message = "Password incorrect";
                http_response_code(418);
            }
            else{
                //find existing token
                $uid = $this->urep->getUserId($user->getEmail());
                $token = '';
                $token = $this->srep->findSession($uid);
                //or gen new
                if($token===''){
                    $token = genToken();
                }
                //assign permissions
                $perm = $this->urep->getUserPermissions($uid)->getPermString();

                $message=$token;
                http_response_code(200);
            }

            $response = "{\"message\": \"$message\", \"perm\": \"$perm\"}";
            echo $response;
        }
    }

    public function checkSession(){
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if($contentType==='application/json'){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');

            $token = $decoded['token'];
            $message = '';

            if($this->srep->checkToken($token)){
                $uid = $this->srep->getUserId($token);
                $perm = $this->urep->getUserPermissions($uid);
                $message = $perm->getPermString();
                http_response_code(200);
            }
            else{
                $message='Session not valid';
                http_response_code(418);
            }

            $response = "{\"message\": \"$message\"}";
            echo $response;
        }
    }

    private function genToken():string
    {
        try {
            $tries = 0;
            $maxTries = 100;
            $newToken = '';
            do {
                if($tries>$maxTries){
                    return '';
                }
                $newToken = bin2hex(random_bytes(20));
                $tries++;
            } while ($this->srep->checkToken($newToken));
        return $newToken;
        }
        catch(Exception $e){
            return '';
        }
    }
}