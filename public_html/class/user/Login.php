<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 14:31
 */

namespace user;
use enum\Cons;
use \enum\Query;
use PDO;
use \utils\Utils;

/**
 * Class Login
 * @package user
 */
class Login
{

    /**
     * @var array
     */
    public $result = [];

    /**
     * @var \db\Connect
     */
    protected $db;

    /**
     * Login constructor.
     * @param $email
     * @param $password
     * @param null $connect
     */
    public function __construct($email, $password, $connect=null )
    {

        if( $connect )
        {
            $this->db = $connect;
        }
        else {
            try {
                $this->db = new \db\Connect();
            } catch (\Exception $e) {
                # exception

            }

        }
        if( $email && $password ) {
            $this->prepareLogin( $email, $password );
        }
        else {
            $this->result = [false, "no email/pass"];
        }
    }


    /**
     * @param $email
     * @param $password
     */
    private function prepareLogin($email, $password ) : void
    {
        try {
            if ( $user = $this->checkUserExists( $email ) ) {
                if ( !$this->checkBrute( $user[Cons::USER_ID] ) ) {
                    $this->tryLogin( $user, $this->hashPassword( $password, $user ) );
                }
            } else {
                // Could not create a prepared statement
                $this->result = [false, "user does not exist"];

            }
        } catch (\Exception $e) {
            # exception handling
            $this->result = [false, "exception"];
        }
    }

    /**
     * @param $userId
     * @return bool|null
     */
    protected function checkBrute( $userId ) {

        // All login attempts are counted from the past 2 hours.
        $twoHoursAgo = time() - ( 2 * 60 * 60 );

        try {

            $params = array(Cons::ID=>[$userId,PDO::PARAM_INT],
                            Cons::TBL_ATTEMPT_TIME=>[$twoHoursAgo,PDO::PARAM_STR] );
            $this->db->bind_multiple( $params );

            $numOfRows = $this->db->numRows( Query::LOGIN_ATTEMPTS );
            if ($numOfRows > 5)
            {
                $this->result = [false, "brute attempt"];
                return true;
            }
            else
            {
                return false;
            }

        } catch (\Exception $e ) {
            // Could not create a prepared statement
            $this->result = [ false, "could not check login attempts" ];
        }
        return null;
    }

    /**
     * @param $email
     * @return array
     */
    private function checkUserExists( $email ): array
    {
        $this->db->parameters = array(Cons::EMAIL=>[$email,PDO::PARAM_STR]);

        if ($user = $this->db->row(Query::GET_USER ) ) {

            list($db_user_id, $db_username) = $user;

            $this->db->parameters = array(Cons::ID=>[$db_user_id,PDO::PARAM_INT]);

            if ($auth = $this->db->row(Query::GET_AUTH ) ) {
                list($db_password, $db_salt) = $auth;

                if ($db_user_id && $db_username && $db_password && $db_salt) {
                    $c_user_id = utils::clean($db_user_id, Cons::CLEAN_NUM);
                    $c_username = utils::clean($db_username, Cons::CLEAN_USER);

                    return array(
                        Cons::USER_ID => $c_user_id,
                        Cons::USERNAME => $c_username,
                        Cons::USER_PASS => $db_password,
                        Cons::USER_SALT => $db_salt);
                }
            }
        }
        $this->result = [false, "failed to execute checkUserExists query"];
        return array();
    }

    /**
     * @param array $user
     * @param string $hashedPass
     */
    private function tryLogin(array $user, string $hashedPass): void
    {
        if ($user[Cons::USER_PASS] == $hashedPass) {
            $userAgent = "";

            if( isset( $_SERVER[Cons::HTTP_USER_AGENT] ) ) {
                $userAgent = strtolower($_SERVER[Cons::HTTP_USER_AGENT]);
            }


            $_SESSION[Cons::USER_ID] = $user[Cons::USER_ID];
            $_SESSION[Cons::USERNAME] = $user[Cons::USERNAME];
            $_SESSION[Cons::LOGIN_STRING] = $this->hashLoginString($hashedPass, $userAgent);

            // Login successful.
            $this->result = [true, "success"];

        } else {

            $params = array(
                Cons::TBL_USER_ID => [$user[Cons::USER_ID],PDO::PARAM_INT]);
            $this->db->bind_multiple( $params );
            $query = $this->db->query(Query::RECORD_LOGIN_ATTEMPT);

            if (!$query) {
                $this->result = [false, "could not record incorrect login attempt"];
            } else {
                $this->result = [false, "incorrect pw"];
            }
        }
    }

    /**
     * @param $password
     * @param array $user
     * @return string
     */
    private function hashPassword($password, array $user): string
    {
        return hash(Cons::SHA, $password . $user[Cons::USER_SALT]);
    }

    /**
     * @param string $hashed_password
     * @param string $user_browser
     * @return string
     */
    private function hashLoginString(string $hashed_password, string $user_browser): string
    {
        return hash(Cons::SHA, $hashed_password . $user_browser);
    }

    /**
     * @return bool
     */
    public static function logOut():bool {
        session_destroy();
        unset($_SESSION[Cons::USER_ID]);
        unset($_SESSION[Cons::LOGIN_STRING]);
        unset($_SESSION[Cons::USERNAME]);
        unset($_SERVER[Cons::HTTP_USER_AGENT]);
        return isset($_SESSION[Cons::USER_ID]);
    }

    /**
     * @return bool
     */
    public static function validateLogin():bool {
        $result = false;
        if (isset($_SESSION[Cons::USER_ID], $_SESSION[Cons::USERNAME], $_SESSION[Cons::LOGIN_STRING])) {
            $db = null;


            try {
                $db = new \db\Connect();
            } catch (\Exception $e) {
                # exception
                echo "exception";
            }
            $user_id = $_SESSION[Cons::USER_ID];
            $login_string = $_SESSION[Cons::LOGIN_STRING];
            $username = $_SESSION[Cons::USERNAME];
            $userAgent = '';
            if( isset( $_SERVER[Cons::HTTP_USER_AGENT] ) ) {
                $userAgent = strtolower($_SERVER[Cons::HTTP_USER_AGENT]);
            }

            $params = array(Cons::TBL_USER_ID =>[$user_id,PDO::PARAM_INT]);
            $db->bind_multiple($params);
            $hashedPass = $db->single(Query::LOGIN_CHECK);

            if (!$hashedPass) {
                //user doesn't exist
                $result = false;
            } else {
                $login_string_check = hash('sha512', $hashedPass . $userAgent);

                if($login_string_check === $login_string)
                {
                    $result = true;
                }
                else {
                    $result = false;
                }
            }

        }
        return $result;
    }
}