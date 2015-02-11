<?php

namespace Andrei\Tests\App;

use Andrei\App\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    protected $configMock;
    protected $requestMock;
    
    protected function setUp()
    {
        $this->configMock = $this->getMockBuilder('\Andrei\App\Config')
            ->disableOriginalConstructor()
            ->getMock();
        $this->requestMock = $this->getMockBuilder('\Andrei\App\Http\Request')
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetConfig()
    {
        $application = new Application($this->configMock, $this->requestMock);
        
        $this->assertInstanceOf('\Andrei\App\Config', $application->getConfig());
    }
    
    public function testGetRequest()
    {
        $application = new Application($this->configMock, $this->requestMock);
        
        $this->assertInstanceOf('\Andrei\App\Http\Request', $application->getRequest());
    }
}