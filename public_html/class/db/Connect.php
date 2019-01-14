<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 14:18
 */

namespace db;


use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use \PDO;

/**
 * Class Connect
 * @package db
 */
class Connect
{
    /**
     * @var \PDO
     */
    private $pdo;
    /**
     * @var \PDOStatement
     */
    private $doQuery;
    /**
     * @var
     */
    private $settings;
    /**
     * @var string
     */
    private $settings_file = __DIR__ . "\..\..\..\config.ini";
    /**
     * @var array
     */
    public $parameters;

    /**
     * connect constructor.
     */
    public function __construct()
    {

        try {
            $this->connectToDb();
        } catch (\Exception $e) {
            # Exception Handling
        }
        $this->parameters = array();
    }

    /**
     *
     */
    private function connectToDb()
    {
        if ( !$this->settings = parse_ini_file( $this->settings_file ) ) {
            throw new FileNotFoundException('Unable to open ' . $this->settings_file . '.');
        }
        if (!defined('SCHEMA')) {
            define( "SCHEMA", $this->settings["schema"] );
        }
        if (!defined('HOST')) {
            define( "HOST", $this->settings["host"] );
        }
        if (!defined('USER')) {
            define( "USER", $this->settings["username"] );
        }
        if (!defined('PASS')) {
            define( "PASS", $this->settings["password"] );
        }

        try
        {
            $this->pdo = new PDO( 'mysql:dbname='.SCHEMA.';host='.HOST, USER, PASS,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        }
        catch ( \Exception $e )
        {
            # exception handling
            die();
        }
    }

    /**
     *
     */
    public function close()
    {
        $this->pdo = null;
    }

    /**
     *  1. If not connected, connect to the database.
     *	2. Prepares Query.
     *	3. Binds params
     *	4. Executes Query.
     * @param $query
     */
    private function startQuery($query )
    {
        # Connect to database
        $params = $this->parameters;
        if(!$this->getConnectionStatus()) { $this->connectToDb(); }
        try {
            # Prepare query
            $this->doQuery = $this->pdo->prepare( $query );

            if($params){
                # Bind parameters
                $this->bindParams( $params );
            }
            # Execute SQL
            $this->doQuery->execute();
        }
        catch(\PDOException $e)
        {
            # Exception
            echo "error " . $e;
        }
        # Reset the parameters array
        $this->parameters = array();
    }

    /**
     *	@void
     *
     *	Add the parameter to the parameter array
     *	@param string $value
     *  @param string $key
     */
    public function bind($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    /**
     *	@void
     *
     *	Add more parameters to the parameter array
     *	@param array $params
     */
    public function bind_multiple( $params ) : void
    {
        if(empty($this->parameters) && is_array($params)) {
            foreach ($params as $key => &$value) {
                $this->bind( $key, $value );
            }
        }
    }

    /**
     * @param $query
     * @return int
     */
    public function numRows( $query ) : int
    {
        $query = trim( $query );
        $this->startQuery( $query );

        return $this->doQuery->rowCount();
    }

    /**
     * @param $query
     * @param int $fetchMode
     * @return array|int|null
     */
    public function query($query, $fetchMode = PDO::FETCH_ASSOC)
    {

        $query = trim( $query );
        try {
            $this->startQuery($query);
        } catch (\Exception $e) {
            # exception
            echo "exception";
        }

        $rawStatement = explode(" ", $query);

        # Which SQL statement is used
        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->doQuery->fetchAll($fetchMode);
        }
        elseif ( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
            return $this->doQuery->rowCount();
        }
        else {
            return NULL;
        }
    }

    /**
     *  Returns the last inserted id.
     *  @return string
     */
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    /**
     * @param $query
     * @return array|null
     */
    public function column( $query )
    {
        $this->startQuery( $query );
        $Columns = $this->doQuery->fetchAll(PDO::FETCH_NUM);

        $column = null;
        foreach($Columns as $cells) {
            $column[] = $cells[0];
        }
        return $column;

    }

    /**
     * Returns an array which represents a row from the result set
     * @param $query
     * @param int $fetchMode
     * @return mixed
     */
    public function row($query, $fetchMode = PDO::FETCH_BOTH)
    {
        $this->startQuery( $query );
        return $this->doQuery->fetch( $fetchMode );
    }

    /**
     * @param $query
     * @return mixed
     */
    public function single( $query )
    {
        try {
            $this->startQuery($query);
        } catch (\Exception $e) {
            # exception
        }
        return $this->doQuery->fetchColumn();
    }

    /**
     * @return bool value of isConnected
     */
    public function getConnectionStatus()
    {
      if( is_null( $this->pdo )) {
          return false;
      }
      else {
        $status = $this->pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);

        if ( $status == "localhost via TCP/IP") {
            return true;
        }
        return $status;
        }
    }

    /**
     * @param array $params
     */
    private function bindParams(array $params): void
    {
        if (!empty( $params ) && is_array( $params )) {
            foreach ( $params as $key => &$value ) {
                $key = ":" . $key;
                $this->doQuery->bindParam( $key, $value[0], $value[1] );
            }
        }
    }
}