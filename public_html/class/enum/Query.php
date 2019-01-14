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
    /**************************************************************************************************************
     * Login Attempts
     *************************************************************************************************************/
    const LOGIN_ATTEMPTS = 'SELECT '
                            .Cons::TBL_ATTEMPT_TIME.' FROM _login_attempts WHERE '
                            .Cons::TBL_ATTEMPT_USERID.' = :'.Cons::ID.' 
                            AND time > :'.Cons::TBL_ATTEMPT_TIME.'';
    const RECORD_LOGIN_ATTEMPT = 'INSERT INTO _login_attempts( '
                            .Cons::TBL_ATTEMPT_USERID.' ) VALUES ( :userId )';

    /**************************************************************************************************************
     * User Table
     *************************************************************************************************************/
    const GET_USER = 'SELECT '
                            .Cons::TBL_USER_ID.', '
                            .Cons::TBL_USER_USERNAME.' FROM users WHERE '
                            .Cons::TBL_USER_EMAIL.' = :'.Cons::EMAIL.' LIMIT 1';
    const GET_AUTH = 'SELECT '
                            .Cons::TBL_AUTH_PASS.', '
                            .Cons::TBL_AUTH_SALT.' FROM _users_auth WHERE '
                            .Cons::TBL_AUTH_USERID.' = :'.Cons::ID.' LIMIT 1';
    const LOGIN_CHECK = 'SELECT '
                            .Cons::TBL_AUTH_PASS.' FROM _users_auth WHERE '
                            .Cons::TBL_USER_ID.' = :'.Cons::ID.' LIMIT 1';

    const INSERT_NEW_USER = 'INSERT INTO users ('
                            .Cons::TBL_USER_USERNAME.', '
                            .Cons::TBL_USER_FISTNAME.', '
                            .Cons::TBL_USER_LASTNAME.', '
                            .Cons::TBL_USER_EMAIL.')
                            VALUES 
                            (:'.Cons::USERNAME.', :'.Cons::FIRST_NAME.', :'.Cons::LAST_NAME.', :'.Cons::EMAIL.')';
    const INSERT_NEW_AUTH = 'INSERT INTO _users_auth ('
                            .Cons::TBL_AUTH_USERID.', '
                            .Cons::TBL_AUTH_PASS.', '
                            .Cons::TBL_AUTH_SALT.')
                            VALUES 
                            (:'.Cons::USER_ID.', :'.Cons::USER_PASS.', :'.Cons::USER_SALT.')';
    const USER_EXIST_EMAIL = 'SELECT count( '
                            .Cons::TBL_USER_ID.' ) FROM users WHERE '
                            .Cons::TBL_USER_EMAIL.'= :email LIMIT 1';
    const USER_EXIST_USER = 'SELECT count( '
                            .Cons::TBL_USER_ID.' ) FROM users WHERE '
                            .Cons::TBL_USER_USERNAME.' = :username LIMIT 1';

    /**************************************************************************************************************
     * Forum Display Queries
     *************************************************************************************************************/
    const GET_FORUM_LIST = 'SELECT 
                                fi.'.Cons::TBL_FORUM_ID.', 
                                fc.'.Cons::TBL_FORUM_VALUE.' "category", 
                                ft.'.Cons::TBL_FORUM_VALUE.' "name", 
                                fd.'.Cons::TBL_FORUM_VALUE.' "description", 
                                count(fth.'.Cons::TBL_FORUM_ID.') "threads", 
                                count(ftp.'.Cons::TBL_FORUM_ID.') "posts"  
                            FROM forum_items fi
                                INNER JOIN forum_titles ft on 
                                        fi.'.Cons::TBL_FORUM_TITLE_ID.' = ft.'.Cons::TBL_FORUM_ID.'
                                LEFT JOIN forum_categories fc on 
                                        fi.'.Cons::TBL_FORUM_CAT_ID.' = fc.'.Cons::TBL_FORUM_ID.'
                                INNER JOIN forum_descriptions fd 
                                        on fi.'.Cons::TBL_FORUM_DESC_ID.' = fd.'.Cons::TBL_FORUM_ID.'
                                LEFT JOIN forum_threads fth 
                                        on fi.'.Cons::TBL_FORUM_ID.' = fth.'.Cons::TBL_FORUM_FORUM_ID.' 
                                            and fth.'.Cons::TBL_FORUM_STATUS_ID.' = '.Cons::TBL_STATUS_ACTIVE.'
                                LEFT JOIN forum_thread_posts ftp 
                                        on fth.'.Cons::TBL_FORUM_ID.' = ftp.'.Cons::TBL_FORUM_THREAD_ID.' 
                                            and ftp.'.Cons::TBL_FORUM_STATUS_ID.' = '.Cons::TBL_STATUS_ACTIVE.'
                             WHERE fi.'.Cons::TBL_FORUM_STATUS_ID.' = '.Cons::TBL_STATUS_ACTIVE.'
                             GROUP BY fi.'.Cons::TBL_FORUM_ID;
    const GET_FORUM_TOPICS = 'SELECT 
                                 fi.'.Cons::TBL_FORUM_ID.' "forumId", 
                                 ft.'.Cons::TBL_FORUM_VALUE.' "name", 
                                 fd.'.Cons::TBL_FORUM_VALUE.' "description", 
                                 fth.'.Cons::TBL_FORUM_ID.' "threadId", 
                                 ft2.'.Cons::TBL_FORUM_VALUE.' "threadTitle", 
                                 u.'.Cons::TBL_USER_USERNAME.' "author", 
                                 count(ftp.'.Cons::TBL_FORUM_ID.') "posts", 
                                 max(ftpc.'.Cons::TBL_FORUM_DATETIME.') "lastPost", 
                                 u2.'.Cons::TBL_USER_USERNAME.' "lastPostBy"
                             FROM forum_items fi
                                 INNER JOIN forum_threads fth 
                                    on fi.'.Cons::TBL_FORUM_ID.' = fth.'.Cons::TBL_FORUM_FORUM_ID.' 
                                    and fth.'.Cons::TBL_FORUM_STATUS_ID.' = '.Cons::TBL_STATUS_ACTIVE.'
                                 INNER JOIN forum_titles ft 
                                    on fi.'.Cons::TBL_FORUM_TITLE_ID.' = ft.'.Cons::TBL_FORUM_ID.'
                                 INNER JOIN forum_titles ft2 
                                    on fth.'.Cons::TBL_FORUM_TITLE_ID.' = ft2.'.Cons::TBL_FORUM_ID.'
                                 INNER JOIN forum_descriptions fd 
                                    on fi.'.Cons::TBL_FORUM_DESC_ID.' = fd.'.Cons::TBL_FORUM_ID.'
                                 INNER JOIN users u 
                                    on fth.'.Cons::TBL_FORUM_AUTH_ID.' = u.'.Cons::TBL_FORUM_ID.'
                                 LEFT JOIN forum_thread_posts ftp 
                                    on fth.'.Cons::TBL_FORUM_ID.' = ftp.'.Cons::TBL_FORUM_THREAD_ID.' 
                                    and ftp.'.Cons::TBL_FORUM_STATUS_ID.' = '.Cons::TBL_STATUS_ACTIVE.'
                                 LEFT JOIN users u2 
                                    on ftp.'.Cons::TBL_FORUM_AUTH_ID.' = u2.'.Cons::TBL_FORUM_ID.'
                                 LEFT JOIN forum_thread_post_content ftpc 
                                    on ftp.'.Cons::TBL_FORUM_ID.' = ftpc.'.Cons::TBL_FORUM_POST_ID.' 
                                    and ftpc.'.Cons::TBL_FORUM_STATUS_ID.' = '.Cons::TBL_STATUS_ACTIVE.'
                             WHERE fi.'.Cons::TBL_FORUM_STATUS_ID.' = '.Cons::TBL_STATUS_ACTIVE.' 
                                and fi.'.Cons::TBL_FORUM_ID.' = :'.Cons::TBL_FORUM_FORUM_ID.'
                             GROUP BY fth.'.Cons::TBL_FORUM_ID.'
                             LIMIT :'.Cons::QRY_MIN.', :'.Cons::QRY_OFFSET;
    /**************************************************************************************************************
     * Unit Test Queries
     *************************************************************************************************************/
    const TEST_INSERT_QUERY = 'INSERT INTO _tests( val ) VALUES ("testCase_")';
    const TEST_SELECT_QUERY = 'SELECT count( val ) FROM _tests WHERE val = "testCase_"';
    const TEST_DELETE_QUERY = 'DELETE FROM _tests WHERE val = "testCase_"';
}