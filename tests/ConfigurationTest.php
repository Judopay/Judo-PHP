<?php

namespace Tests;

use PHPUnit_Framework_TestCase;
use Tests\Helpers\ConfigHelper;

class ConfigurationTest extends PHPUnit_Framework_TestCase
{
    protected $data = array();

    public function setUp()
    {
        $this->data = array(
            array('', "MYTOKEN", "MYSECRET"),
            array(null, "MYTOKEN", "MYSECRET"),
            array('MYJUDOID', '', "MYSECRET"),
            array('MYJUDOID', null, "MYSECRET"),
            array('MYJUDOID', "MYTOKEN", ''),
            array('MYJUDOID', "MYTOKEN", null),
        );
    }

    public function testInvalidConfiguration()
    {
        foreach ($this->data as $data) {
            $config = ConfigHelper::getConfigFromList($data);

            try {
                $config->validate();
            } catch (\Exception $e) {
                $this->assertInstanceOf('\Judopay\Exception\ValidationError', $e);
                $this->assertEquals($e->getMessage(), 'SDK configuration variables missing');

                continue;
            }

            $this->fail('An expected ValidationError has not been raised.');
        }
    }

    public function testValidConfiguration()
    {
        $config = ConfigHelper::getConfigFromList(array('MYJUDOID', "MYTOKEN", 'MYSECRET'));
        $this->assertTrue($config->validate());
    }
}
