<?php
declare(strict_types = 1);
namespace mrsatik\ConsoleTest;

use PHPUnit\Framework\TestCase;
use mrsatik\Console\Request;
use mrsatik\Console\Exception\RouteException;

class RequestTest extends TestCase
{
    public function testResolveEmptyRoute()
    {
        $_SERVER['argv'] = [];
        $request = new Request();
        $this->expectException(RouteException::class);
        $request->resolve();
    }

    public function testResolveComand()
    {
        $request = new Request();
        $_SERVER['argv'] = [
            'cli',
            'test1',
            'action',
            'param'
        ];
        $result = $request->resolve();
        $this->assertEquals($result[0], 'test1');
        $this->assertEquals($result[1], 'action');
        $this->assertEquals($result[2], ['param']);

        $_SERVER['argv'] = [
            'cli',
            'test2:action2',
            'param3'
        ];
        $reclectionObject = new \ReflectionObject($request);
        $var = $reclectionObject->getProperty('_params');
        $var->setAccessible(true);
        $var->setValue($request, null);
        $result = $request->resolve();
        $this->assertEquals($result[0], 'test2');
        $this->assertEquals($result[1], 'action2');
        $this->assertEquals($result[2], ['param3']);
    }
}