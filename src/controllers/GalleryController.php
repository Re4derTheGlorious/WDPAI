<?php

require_once "AppController.php";
require_once __DIR__."/../models/Photo.php";
require_once __DIR__."/../repository/PhotoRepository.php";


class GalleryController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024*1024; //ALSO limited by nginx config
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/res/photos/';

    private $message = [];
    private $rep;

    public function __construct()
    {
        parent::__construct();
        $this->rep = new PhotoRepository();
    }

    public function uploadPhoto()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

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

            $nextId = $this->rep->cyclePhotos($decoded['currPos'], $decoded['currAlb'], $decoded['dir']);
            $nextImage = $this->rep->getPhoto($nextId)->getImage();
            $response = "{\"path\": \"public/res/photos/$nextImage\"}";
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