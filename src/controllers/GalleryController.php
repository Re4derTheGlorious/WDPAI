<?php

require_once "AppController.php";
require_once __DIR__."/../models/Photo.php";
require_once __DIR__."/../repository/PhotoRepository.php";
require_once __DIR__."/../repository/UserRepository.php";
require_once __DIR__."/../repository/SessionRepository.php";



class GalleryController extends AppController
{
    const MAX_FILE_SIZE = 8000000 ; //ALSO limited by nginx config
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/res/photos/';

    private $message = [];
    private $rep;
    private $srep;
    private $urep;

    public function __construct()
    {
        parent::__construct();
        $this->rep = new PhotoRepository();
        $this->srep = new SessionRepository();
        $this->urep = new UserRepository();
    }

    public function uploadPhoto()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            //auth user
            $token = $_POST['token_field'];
            if(!$token || strlen($token)==0){
                return $this->render('gallery', ['messages' => $this->message]);
            }
            else if(!($this->srep->checkToken($token))){
                return $this->render('gallery', ['messages' => $this->message]);
            }

            $perm = $this->urep->getUserPermissions($this->srep->getUserId($token));
            if(!$perm->getUpload()){
                return $this->render('gallery', ['messages' => $this->message]);
            }

            //Prepare unique image identifier
            $image = $_FILES['file']['name'];
            $dir = dirname(__DIR__).self::UPLOAD_DIRECTORY;
            while(file_exists($dir.$image)){
                $image = '_'.$image;
            }

            //Prepare image name
            $name =$_POST['name_field'];
            if(!$name)
            {
                $name = $_FILES['file']['name'];
            }
            $photo = new Photo($name, $image);

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                $dir.$image
            );

            //Insert into db
            $photo = new Photo($name, $image);
            $this->rep->addPhoto($photo);
        }
        return $this->render('gallery', ['messages' => $this->message]);
    }

    public function fetchPhoto(){
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if($contentType==='application/json'){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $uid = $this->srep->getUserId($decoded['token']);
            $nextId = $this->rep->cyclePhotos($decoded['currPos'], $decoded['currAlb'], $decoded['dir']);
            $nextImage = $this->rep->getPhoto($nextId)->getImage();
            $faved = ($this->rep->isInFavs($uid, $nextId))?1:0;
            $response = "{\"path\": \"public/res/photos/$nextImage\", \"faved\": $faved}";
            echo $response;
        }
    }

    public function likePhoto(){
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if($contentType==='application/json'){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $uid = $this->srep->getUserId($decoded['token']);
            $aid = $decoded['currAlb'];
            $pid = $this->rep->cyclePhotos($decoded['currPos'], $aid, 0);

            $res = $this->rep->fav($uid, $pid)>0?1:0;

            $pos = $decoded['currPos'];
            $response = "{\"message\": \"$res\", \"pos\": \"$pos\"}";
            echo $response;
        }
    }

    public function getAlbum(){
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if($contentType==='application/json'){
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $uid = $this->srep->getUserId($decoded['token']);
            $aid = $this->urep->getUserAlbumId($uid);

            $response = "{\"message\": \"$aid\"}";
            echo $response;
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File size is over the limit';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type not supported';
            return false;
        }
        return true;
    }
}