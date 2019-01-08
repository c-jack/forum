<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 03/01/2019
 * Time: 19:27
 */

namespace db;

use enum\Query;
use PHPUnit\Framework\TestCase;

class ConnectTest extends TestCase
{


    /**
     * @test
     * Check the connection can be set and destroyed
     * @throws \Exception
     */
    public function checkConnection()
    {
        $connection = new Connect();

        $this->AssertTrue( $connection->getConnectionStatus() );
        $connection->close();
        $this->AssertFalse( $connection->getConnectionStatus() );
    }

    /**
     * @test
     * Inserting a single entry to the DB
     * @throws \Exception
     */
    public function checkInsertToDB()
    {
        $connection = new Connect();

        $insert = $connection->query(Query::TEST_INSERT_QUERY);
        $this->AssertThat( $insert, self::equalTo( 1 ) );
        $connection->close();
    }

    /**
     * @test
     * Retrieve a single entry from the DB
     * @throws \Exception
     */
    public function checkSelectSingleFromDB()
    {
        $connection = new Connect();

        $insert = $connection->single( Query::TEST_SELECT_QUERY);
        $this->AssertThat( $insert, self::equalTo( 1 ) );
        $connection->close();
    }

    /**
     * @test
     * Delete a single entry from the DB
     * @throws \Exception
     */
    public function checkDeleteSingleFromDB()
    {
        $connection = new Connect();

        $insert = $connection->query(Query::TEST_DELETE_QUERY);
        $this->AssertThat( $insert, self::equalTo( 1 ) );
        $connection->close();
    }

}
