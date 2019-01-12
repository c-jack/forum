<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 04/01/2019
 * Time: 23:05
 */

namespace enum;


use MyCLabs\Enum\Enum;

class Query extends Enum
{
    /**
     * DB Queries
     */
    const LOGIN_ATTEMPTS = 'SELECT time FROM _login_attempts WHERE user_id = :userId AND time > :time';
    const RECORD_LOGIN_ATTEMPT = 'INSERT INTO _login_attempts( user_id ) VALUES ( :userId )';
    const GET_USER = 'SELECT userid, usern, passw, salt FROM users WHERE email = :email LIMIT 1';
    const LOGIN_CHECK = 'SELECT passw FROM users WHERE userid = :userId LIMIT 1';

    /**
     * Registration
     */
    const INSERT_NEW_USER = 'INSERT INTO users (usern, firstn, lastn, passw, email, salt) 
                      VALUES (:username, :firstName, :lastName, :password, :email, :salt)';
    const USER_EXIST_EMAIL = 'SELECT count( userid ) FROM users WHERE email = :email LIMIT 1';
    const USER_EXIST_USER = 'SELECT count( userid ) FROM users WHERE usern = :username LIMIT 1';

    /**
     * Test Queries
     */
    const TEST_INSERT_QUERY = 'INSERT INTO _tests( val ) VALUES ("testCase_")';
    const TEST_SELECT_QUERY = 'SELECT count( val ) FROM _tests WHERE val = "testCase_"';
    const TEST_DELETE_QUERY = 'DELETE FROM _tests WHERE val = "testCase_"';
}