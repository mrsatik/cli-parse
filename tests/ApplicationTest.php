<?php
declare(strict_types = 1);
namespace mrsatik\ConsoleTest;

use PHPUnit\Framework\TestCase;
use mrsatik\Console\Application;
use mrsatik\Console\Exception\RouteException;

class ApplicationTest extends TestCase
{

    public function testSetConfig()
    {
        $appl = new Application();
        $reclectionObject = new \ReflectionObject($appl);
        $var = $reclectionObject->getProperty('config');
        $var->setAccessible(true);
        $data = $var->getValue($appl);
        $this->assertEquals($data, []);

        $testArray = [
            'test' => 'test'
        ];
        $appl = new Application($testArray);
        $reclectionObject = new \ReflectionObject($appl);
        $var = $reclectionObject->getProperty('config');
        $var->setAccessible(true);
        $data = $var->getValue($appl);
        $this->assertEquals($data, $testArray);
    }

    public function testRunActionsExeption()
    {
        $appl = new Application([
            'routing' => [
                'test' => [
                    '\mrsatik\ConsoleTest\Fake\TestController'
                ],
                'testnew' => [
                    '\mrsatik\ConsoleTest\Fake\TestNewController'
                ]
            ]
        ]);

        $this->expectException(RouteException::class);
        $result = $appl->run();
    }

    public function testRunActionRoteNotExist()
    {
        $_SERVER['argv'] = [
            'cli',
            'test1',
            'action'
        ];

        $appl = new Application([
            'routing' => [
                'test' => [
                    '\mrsatik\ConsoleTest\Fake\TestController'
                ],
                'testnew' => [
                    '\mrsatik\ConsoleTest\Fake\TestNewController'
                ]
            ]
        ]);

        $this->expectExceptionMessage('Route not exist');
        $result = $appl->run();
    }

    public function testRunAction()
    {
        $_SERVER['argv'] = [
            'cli',
            'test:add',
            'param'
        ];

        $appl = new Application([
            'routing' => [
                'test' => [
                    '\mrsatik\ConsoleTest\Fake\TestController'
                ],
            ]
        ]);

        $result = $appl->run();
        $this->assertEquals($result, 'success');
    }
}