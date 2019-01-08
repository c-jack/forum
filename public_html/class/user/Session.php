<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 11:49
 */

namespace user;

use enum\Cons;

class Session
{



    static function start($name )
    {
        $secure = true;    // This stops JavaScript being able to access the session id.
        $httpOnly = true;    // Forces sessions to only use cookies.

        if (ini_set('session.use_only_cookies', 1) === FALSE) {
            header("Location: error.php?err=Could not initiate a safe session (ini_set)");
            exit();
        }
        // Gets current cookies params.
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httpOnly);
        session_name($name . '_Session');

        session_start();            // Start the PHP session

        // Make sure the session hasn't expired, and destroy it if it has
        if(self::validateSession())
        {
            // Check to see if the session is new or a hijacking attempt
            if(!self::preventHijacking())
            {
                // Reset session data and regenerate id
                $_SESSION = array();
                $_SESSION[Cons::IP_ADDRESS] = $_SERVER['REMOTE_ADDR'];
                $_SESSION[Cons::USER_AGENT] = $_SERVER['HTTP_USER_AGENT'];
                self::regenerateSession();

                // Give a 5% chance of the session id changing on any request
            }elseif(rand(1, 100) <= 5){
                self::regenerateSession();
            }
        }
        else
        {
            $_SESSION = array();
            session_destroy();
            session_start();
        }
    }

    static protected function preventHijacking()
    {
        $check = true;

        if(!isset($_SESSION[Cons::IP_ADDRESS]) || !isset($_SESSION[Cons::USER_AGENT]))
        {
            $check = false;
        }

        if ($_SESSION[Cons::IP_ADDRESS] != $_SERVER['REMOTE_ADDR'])
        {
            $check = false;
        }

        if( $_SESSION[Cons::USER_AGENT] != $_SERVER['HTTP_USER_AGENT'])
        {
            $check = false;
        }

        return $check;
    }

    static function regenerateSession()
    {
        // If this session is obsolete it means there already is a new id
        if(!isset($_SESSION[Cons::OBSOLETE]) || !$_SESSION[Cons::OBSOLETE])
        {


        // Set current session to expire in 10 seconds
        $_SESSION[Cons::OBSOLETE] = true;
        $_SESSION[Cons::EXPIRES] = time() + 10;

        // Create new session without destroying the old one
        session_regenerate_id(false);

        // Grab current session ID and close both sessions to allow other scripts to use them
        $newSession = session_id();
        session_write_close();

        // Set session ID to the new one, and start it back up again
        session_id($newSession);
        session_start();

        // Now we unset the obsolete and expiration values for the session we want to keep
        unset($_SESSION[Cons::OBSOLETE]);
        unset($_SESSION[Cons::EXPIRES]);
        }

    }

    static protected function validateSession():bool
    {
        $check = true;

        if( isset($_SESSION[Cons::OBSOLETE]) && !isset($_SESSION[Cons::EXPIRES]) )
        {
            $check =  false;
        }

        if(isset($_SESSION[Cons::EXPIRES]) && $_SESSION[Cons::EXPIRES] < time())
        {
            $check =  false;
        }

        return $check;
    }
}