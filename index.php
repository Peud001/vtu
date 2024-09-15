<?php
use App\Core\Session;
require 'vendor/autoload.php';

// echo '<pre>';
// var_dump(App\Core\Request::uri());
// echo '</pre>';

$session = new Session;
$session->set('name', 'John Doe');
echo $session->get('name');