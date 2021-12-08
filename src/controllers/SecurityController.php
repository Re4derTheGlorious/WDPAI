<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';
require_once __DIR__ .'/../repository/UserRepository.php';

class SecurityController extends AppController {

    public function login()
    {
        $userRepository= new UserRepository();

        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['login_field'];
        $password = $_POST['pass_field'];

        $user = $userRepository->getUser($email);

        if(!$user){
            return $this->render('gallery', ['messages' => ['No such user!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('gallery', ['messages' => ['Wrong password!']]);
        }
    }
}