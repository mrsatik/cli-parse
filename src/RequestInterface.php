<?php
declare(strict_types = 1);
namespace mrsatik\Console;

interface RequestInterface
{
    /**
     * Parse cli command and build name of route, action and params
     * @throws RouteException
     * @return [string, string, array[]]
     */
    public function resolve(): array;
}
