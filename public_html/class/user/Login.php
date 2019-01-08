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
use \utils\Utils;

class Login
{

    public $result = [];

    protected $db;

    public function __construct( $email, $password, $connect=null )
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
    }


    private function prepareLogin( $email, $password ) : void
    {

        $params = array(Cons::EMAIL=>$email);

        try {
            if ( $user = $this->checkUserExists($params) ) {

                if ( !$this->checkBrute( $user[Cons::USER_ID] ) ) {
                    $this->tryLogin( $user, $this->hashPassword( $password, $user ) );
                }
            } else {
                // Could not create a prepared statement
                $this->result = [false, "user does not exist"];

            }
        } catch (\Exception $e) {
            # exception handling
        }
    }

    protected function checkBrute( $userId ) {

        // All login attempts are counted from the past 2 hours.
        $twoHoursAgo = time() - ( 2 * 60 * 60 );

        try {

            $params = array(Cons::USER_TBL_ID=>$userId,
                            Cons::USER_TBL_TIME=>$twoHoursAgo );
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
     * @param $params
     * @return array
     */
    private function checkUserExists($params ): array
    {
        if ($user = $this->db->row(Query::GET_USER, $params ) ) {

            list($db_user_id, $db_username, $db_password, $db_salt) = $user;

            if( $db_user_id && $db_username && $db_password && $db_salt )
            {
                $c_user_id = utils::clean($db_user_id, Cons::CLEAN_NUM);
                $c_username = utils::clean($db_username, Cons::CLEAN_USER);

                return array(
                    Cons::USER_ID=>$c_user_id,
                    Cons::USERNAME=>$c_username,
                    Cons::USER_PASS=>$db_password,
                    Cons::USER_SALT=>$db_salt );
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

            if( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
                $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
            }

            $_SESSION[Cons::USER_ID] = $user[Cons::USER_ID];
            $_SESSION[Cons::USERNAME] = $user[Cons::USERNAME];
            $_SESSION[Cons::LOGIN_STRING] = $this->hashLoginString($hashedPass, $userAgent);

            // Login successful.
            $this->result = [true, "success"];

        } else {
            $params = array(
                Cons::USER_TBL_ID => $user[Cons::USER_ID],
                Cons::USER_TBL_TIME => time() );

            $query = $this->db->query(Query::RECORD_LOGIN_ATTEMPT, $params);
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
}