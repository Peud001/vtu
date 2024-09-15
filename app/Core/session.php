<?php
namespace App\Core;

class Session 
{
    public function __construct()
    {
        //check if session is already initialized
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    //set session
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        return $_SESSION[$key];
    }
    //get session
    public function get($key)
    {
        return isset($_SESSION[$key])? $_SESSION[$key] : null;
    }
    //delete session
    public function delete($key)
    {
        if(isset($_SESSION[$key]))
        {
            unset($_session[$key]);
        }
    }
    //destroy session
    public function destroy()
    {
        session_destroy();
    }
}
