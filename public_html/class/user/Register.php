<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 18:05
 */

namespace user;


use enum\Cons;
use enum\Query;
use utils\Utils;

class Register
{

    private $error_msg;
    private $username;
    private $first_name;
    private $last_name;
    private $password;

    private $email;

    public $result = [];

    protected $db;

    public function __construct( $values, $connect=null )
    {

        if( $connect )
        {
            echo "using test connection\n";
            $this->db = $connect;
        }
        else {
            try {
                $this->db = new \db\Connect();
            } catch (\Exception $e) {
                # exception
            }

        }
        $missing = Utils::array_keys_exist(Cons::EXPECTED_KEYS, $values );

        if( $missing[0] )
        {
            if ( isset($values[Cons::USER_PASS]) && strlen($values[Cons::USER_PASS]) != 128 ) {
                // The hashed pwd should be 128 characters long.
                // If it's not, something really odd has happened
                $this->error_msg .= '<p class="error">Invalid password configuration.</p>';
            }
            else {
                $this->username = Utils::clean($values[Cons::USERNAME], Cons::USERNAME);
                $this->first_name = Utils::clean($values[Cons::FIRST_NAME],'text');
                $this->last_name = Utils::clean($values[Cons::LAST_NAME],'text');
                $this->email = Utils::clean($values[Cons::EMAIL],'text');
                $this->password = $values[Cons::USER_PASS];

                $this->registerUser();
            }
        }
        else
        {
            $this->error_msg = "param ".$missing[1]." missing from values";

            $this->result = [ false, $this->error_msg ];
        }
        return $this->result;

    }

    private function registerUser() : void {

        if( $this->doesUserExist(Cons::EMAIL) > 0 ) {
            $this->error_msg .= '<p class="error">A user with this email address already exists.</p>';
        }
        else if ( $this->doesUserExist(Cons::USERNAME) > 0 ) {
            $this->result = [ false, "user already exists" ];
        }
        else {

            $random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE));
            $hashed_password = hash('sha512', $this->password . $random_salt);



            $values = array( Cons::USERNAME =>[$this->usernam,PDO::PARAM_STR],
                             Cons::FIRST_NAME=>[$this->first_name,PDO::PARAM_STR],
                             Cons::LAST_NAME=>[$this->last_name,PDO::PARAM_STR],
                             Cons::EMAIL =>[$this->email,PDO::PARAM_STR]);

            $this->db->bind_multiple( $values );
            $insertNewUser = $this->db->query(Query::INSERT_NEW_USER );

            if($insertNewUser){
                $values = array(
                    Cons::USER_ID =>[$this->db->lastInsertId(),PDO::PARAM_INT],
                    Cons::USER_PASS =>[$hashed_password,PDO::PARAM_STR],
                    Cons::USER_SALT=>[$random_salt,PDO::PARAM_STR]);

                $this->db->bind_multiple( $values );
                $insertNewUser = $this->db->query(Query::INSERT_NEW_AUTH );

            }


            if (!$insertNewUser) {
                echo "fail";
                $this->result = [ false, "insert failure" ];
            }
            else {
                echo "success";
                $this->result = [ true, "success" ];
            }
        }
    }

    private function doesUserExist( $check="na" )
    {
        $outcome = null;

        switch ( $check ) {
            case Cons::EMAIL:
                $this->db->bind( Cons::EMAIL, $this->email );
                $outcome = $this->db->single(Query::USER_EXIST_EMAIL);
                break;
            case Cons::USERNAME:
                $this->db->bind( Cons::USERNAME, $this->username );
                $outcome = $this->db->single(Query::USER_EXIST_USER);
                break;
            default:
                $this->result = [ false, "incorrect value in doesUserExist" ];
                break;
        }

        return $outcome;
    }


}