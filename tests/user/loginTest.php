<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 30/12/2018
 * Time: 21:39
 */

namespace userTest;

use \user\Login;
use PHPUnit\Framework\TestCase;

class loginTest extends TestCase
{
    private $salt = "unitTest";
    private $password = "password";
    private $hashedPass;

    /**
     * The implementation should sha512 the submitted password before it leaves the DOM, so we need to simulate
     * that by hashing the test constant $password before the tests begin.
     */
    protected function setUp(){
        $this->hashedPass = hash('sha512', $this->password . $this->salt);
    }

    /**
     * @test
     * The Login class should return TRUE if the password is correct.
     */
    public function shouldLoginSuccessfully()
    {
        $return = array(4, "unit_test", $this->hashedPass, $this->salt);

        $mock = $this->mockClass( $return );

        $login = new Login( "test@test.com", "password", $mock );

        $this->assertTrue( $login->result[0] );
        $this->assertThat( $login->result[1], self::equalTo("success") );
    }

    /**
     * @test should fail login if password is incorrect
     * The Login class should return FALSE if the password is incorrect.
     */
    public function shouldFailLoginIfPasswordIncorrect()
    {
        $return = array(4, "unit_test", $this->hashedPass, $this->salt);

        $mock = $this->mockClass( $return );
        $mock->expects($this->any())
            ->method('query')
            ->will($this->returnValue( 1 ));
        $login = new Login( "test@test.com", "wrong_password", $mock );

        $this->assertFalse( $login->result[0] );
        $this->assertThat( $login->result[1], self::equalTo("incorrect pw") );
    }
    /**
     * @test
     * The Login class should return FALSE if the user lookup query returns no results
     */
    public function shouldFailLogin()
    {
        $valToReturn = array( null, null, null, null );

        $mock = $this->mockClass( $valToReturn );
        $mock->expects($this->any())
            ->method('row')
            ->will($this->returnValue( 1 ));
        $login = new Login( "test@test.com", "wrong_password", $mock );

        $this->assertFalse( $login->result[0] );
        $this->assertThat( $login->result[1], self::equalTo("user does not exist") );
    }

    /**
     * Mocks the \db\connect class' row method and adds a return value
     * @param $valToReturn|PHPUnit_Framework_MockObject_MockObject value the db\connect object should return
     * @return \PHPUnit\Framework\MockObject\MockObject returns constructed Mock
     */
    private function mockClass( $valToReturn ): \PHPUnit\Framework\MockObject\MockObject
    {
        $mock = $this->createMock('\db\Connect');
        $mock->expects($this->any())
            ->method('row')
            ->will($this->returnValue($valToReturn));
        return $mock;
    }
}
