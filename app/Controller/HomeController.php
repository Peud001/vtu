<?php

namespace App\Controller;

use App\Core\Request;

class HomeController
{
    public static function index(Request $request)
    {
        echo "Home Page";
    }
    public static function about(Request $request)
    {
        echo "About page";
    }
    //contact
    public static function contact(Request $request)
    {
        echo "Contact page";
    }
    //blog
    public static function blog(Request $request, $args)
    {
        echo "blog";
    }
}