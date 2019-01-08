<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 04/01/2019
 * Time: 23:05
 */

namespace enum;

use MyCLabs\Enum\Enum;

class Cons extends Enum
{
    const SHA = "sha512";
    const USER_PASS = "password";
    const USER_SALT = "salt";
    const USER_ID = "userId";
    const USERNAME = "username";
    const FIRST_NAME = "first_name";
    const LAST_NAME = "last_name";
    const EMAIL = "email";
    const TEST_EMAIL = "test@user.com";

    const LOGIN_STRING = "login_string";
    const EXPECTED_KEYS = array(Cons::USERNAME => "",
        Cons::FIRST_NAME => "",
        Cons::LAST_NAME => "",
        Cons::USER_PASS => "",
        Cons::EMAIL => "");
    const UTF_8 = "UTF-8";

    // Session
    const IP_ADDRESS = 'ipAddress';
    const USER_AGENT = 'userAgent';
    const OBSOLETE = 'OBSOLETE';
    const EXPIRES = 'EXPIRES';

    // User Table
    const USER_TBL_ID = "userid";
    const USER_TBL_TIME = "time";


    // Cleam

    const CLEAN_NUM = "number";
    const CLEAN_USER = "username";

}