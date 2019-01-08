<?php
/**
 * Created by PhpStorm.
 * User: chris
 * Date: 03/01/2019
 * Time: 19:16
 */

namespace user;

use \enum\Cons;
use PHPUnit\{Framework\TestCase};

class RegisterTest extends TestCase
{


    private $hashedPass;
    private $values = [];

    /**
     * The implementation should sha512 the submitted password before it leaves the DOM,
     * so we need to simulate that by hashing the test constant $password before the tests begin.
     */
    protected function setUp(){
        $this->hashedPass = hash('sha512', Cons::USER_PASS );
    }

    /**
     * @test
     * Checks that the initiation of a new class returns a success
     * when successful outcomes are returned from the queries
     */
    public function checkThatRegisterIsSuccessful()
    {
        $this->values[Cons::USERNAME] = Cons::USERNAME;
        $this->values[Cons::FIRST_NAME] = Cons::FIRST_NAME;
        $this->values[Cons::LAST_NAME] = Cons::LAST_NAME;
        $this->values[Cons::USER_PASS] = $this->hashedPass;
        $this->values[Cons::EMAIL] = Cons::TEST_EMAIL;

        $mock = $this->mockClass( array( 0, true ) );


        $register = new Register( $this->values, $mock );

        $this->assertTrue( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("success") );

    }

    /**
     * @test
     * Checks that the initiation of a new class returns a failure with message
     * "insert failure" when an unsuccessful outcome is returned from the insert query
     */
    public function checkThatRegisterFails()
    {
        $this->values[Cons::USERNAME] = Cons::USERNAME;
        $this->values[Cons::FIRST_NAME] = Cons::FIRST_NAME;
        $this->values[Cons::LAST_NAME] = Cons::LAST_NAME;
        $this->values[Cons::USER_PASS] = $this->hashedPass;
        $this->values[Cons::EMAIL] = Cons::TEST_EMAIL;

        $mock = $this->mockClass( array( 0, false ) );


        $register = new Register( $this->values, $mock );

        $this->assertFalse( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("insert failure") );

    }

    /**
     * @test
     * Checks that the initiation of a new class returns a failure with message
     * "insert failure" when an unsuccessful outcome is returned from the insert query
     */
    public function checkThatRegisterFailsWhenFieldsNotSet()
    {
        // Check when username not set

        $register = new Register( $this->values );
        $this->assertFalse( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("param username missing from values") );

        // Check when first_name not set
        $this->values[Cons::USERNAME] = Cons::USERNAME;
        $register = new Register( $this->values );

        $this->assertFalse( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("param first_name missing from values") );

        // Check when last_name not set
        $this->values[Cons::FIRST_NAME] = Cons::FIRST_NAME;
        $register = new Register( $this->values );

        $this->assertFalse( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("param last_name missing from values") );

        // Check when password not set
        $this->values[Cons::LAST_NAME] = Cons::LAST_NAME;
        $register = new Register( $this->values );

        $this->assertFalse( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("param password missing from values") );

        // Check when email not set
        $this->values[Cons::USER_PASS] = $this->hashedPass;
        $register = new Register( $this->values );

        $this->assertFalse( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("param email missing from values") );

        // Check when all are set
        $this->values[Cons::EMAIL] = Cons::TEST_EMAIL;

        $mock = $this->mockClass( array( 0, true ) );
        $register = new Register( $this->values, $mock );

        $this->assertTrue( $register->result[0] );
        $this->assertThat( $register->result[1], self::equalTo("success") );

    }


    /**
     * Mocks the \db\connect class' row method and adds a return value
     * @param $return
     * @return \PHPUnit\Framework\MockObject\MockObject returns constructed Mock
     */
    private function mockClass( $return ): \PHPUnit\Framework\MockObject\MockObject
    {
        $mock = $this->createMock('\db\Connect');
        $mock->expects($this->exactly( 2 ))
            ->method('single')
            ->will($this->returnValue( $return[0] ));
        $mock->expects($this->once())
            ->method('bind_multiple');
        $mock->expects($this->once())
            ->method('query')
            ->will($this->returnValue( $return[1] ));

        return $mock;
    }
}
