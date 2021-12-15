<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('gallery', 'DefaultController');
Router::post('signIn', 'SecurityController');
Router::post('signUp', 'SecurityController');
Router::post('checkSession', 'SecurityController');
Router::post('uploadPhoto', 'GalleryController');
Router::post('fetchPhoto', 'GalleryController');
Router::post('likePhoto', 'GalleryController');


Router::run($path);