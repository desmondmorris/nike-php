<?php

class NikeTest extends PHPUnit_Framework_TestCase
{

    public static $config = array(
        'access_token' => 'ABCDE-XXXXX'
    );

    public function setUp()
    {
        $stub = $this->getMock(
            'Request',
            array('call'),
            array(self::$config)
        );

        $response = new stdClass;

        $stub->expects($this->any())
            ->method('call')
            ->will($this->returnValue($response));
        $this->Nike = new Nike(self::$config, $stub);
    }

    /**
     * @expectedException Exception
     */
    public function testMissingConfigThrowsException()
    {
        $Nike = new Nike();
    }

    /**
     * @expectedException Exception
     */
    public function testMissingAccessTokenThrowsException()
    {
        $config = array();
        $Nike = new Nike($config);
    }

    private function _testCallResponse($method, $params = array())
    {
        return $this->assertTrue( is_object( $this->Nike->$method($params) ) );
    }

    public function testSportData()
    {
        $this->_testCallResponse('sport');
    }

    public function testListActivities()
    {
        $this->_testCallResponse('activities');
    }

    public function testActivityDetails()
    {
        $activity_id = self::$config['access_token'];
        $this->_testCallResponse('activities_get', compact('activity_id'));
    }

    /**
     * @expectedException Exception
     */
    public function testMissingIdActivityDetails()
    {
        $this->_testCallResponse('activities_get');
    }

    public function testActivityGPSDetails()
    {
        $activity_id = self::$config['access_token'];
        $this->_testCallResponse('activities_get_gps', compact('activity_id'));
    }

    /**
     * @expectedException Exception
     */
    public function testMissingIdActivityGPSDetails()
    {
        $this->_testCallResponse('activities_get_gps');
    }



}
