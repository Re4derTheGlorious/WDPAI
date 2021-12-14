<?php

require_once "AppController.php";

class UploadController extends AppController
{
    const MAX_FILE_SIZE = 1024*1024; //ALSO limited by nginx config
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/res/photos/';

    private $message = [];

    public function uploadPhoto()
    {
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__).self::UPLOAD_DIRECTORY.$_FILES['file']['name']
            );

            // TODO create new project object and save it in database
            //$project = new Project($_POST['title'], $_POST['description'], $_FILES['file']['name']);
        }
        return $this->render('gallery', ['messages' => $this->message]);
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