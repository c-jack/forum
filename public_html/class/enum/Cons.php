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
    const SESSION_NAME = "myForum";
    const SHA = "sha512";
    const USER_PASS = "password";
    const ID = "id";
    const USER_SALT = "salt";
    const USER_ID = "userId";
    const USERNAME = "username";
    const FIRST_NAME = "firstName";
    const LAST_NAME = "lastName";
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
    const HTTP_USER_AGENT = 'HTTP_USER_AGENT';
    const OBSOLETE = 'OBSOLETE';
    const EXPIRES = 'EXPIRES';

    // User Table
    const TBL_USER_ID = "id";
    const TBL_USER_USERNAME = "usern";
    const TBL_USER_FISTNAME = "firstn";
    const TBL_USER_LASTNAME = "lastn";
    const TBL_USER_EMAIL = "email";
    const TBL_AUTH_SALT = "salt";
    const TBL_AUTH_PASS = "passw";
    const TBL_AUTH_USERID = "userId";

    // Forum Table Structure
    const TBL_STATUS_ACTIVE = 1;
    const TBL_STATUS_HIDDEN = 2;
    const TBL_STATUS_PENDING = 3;
    const TBL_STATUS_DELETED = 4;

    const TBL_FORUM_ID = "id";
    const TBL_FORUM_VALUE = "value";
    const TBL_FORUM_TITLE_ID = "titleId";
    const TBL_FORUM_CAT_ID = "categoryId";
    const TBL_FORUM_DESC_ID = "descriptionId";
    const TBL_FORUM_STATUS_ID = "statusId";
    const TBL_FORUM_FORUM_ID = "forumId";
    const TBL_FORUM_THREAD_ID = "threadId";
    const TBL_FORUM_AUTH_ID = "authorId";
    const TBL_FORUM_SUB_FORUM_ID = "subForumId";
    const TBL_FORUM_CONTENT = "content";
    const TBL_FORUM_DATETIME = "dateTime";
    const TBL_FORUM_POST_ID = "postId";

    const QRY_MIN = "queryMin";
    const QRY_OFFSET = "queryOffset";

    // Login Attempts Table
    const TBL_ATTEMPT_TIME = "time";
    const TBL_ATTEMPT_USERID = "userId";


    // Cleam

    const CLEAN_NUM = "number";
    const CLEAN_USER = "username";

}