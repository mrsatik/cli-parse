<?php
declare(strict_types = 1);
namespace mrsatik\Console;

use mrsatik\Console\Exception\RouteException;

class Application
{

    /**
     * Apprication
     * config
     *
     * @var array
     */
    private $config = [];

    public function __construct(array $config = [])
    {
        if ($config !== []) {
            $this->config = $config;
        }
    }

    /**
     * Run
     * function
     *
     * @return mixed
     */
    public function run()
    {
        return $this->handleRequest();
    }

    /**
     * Handles
     * the
     * specified
     * request.
     */
    private function handleRequest()
    {
        list ($route, $action, $params) = (new Request())->resolve();
        $result = $this->runAction($route, $action, $params);

        return $result;
    }

    /**
     * Run
     * Action
     * in
     * controller
     *
     * @param string $route
     * @param string $action
     * @param array $params
     */
    private function runAction(string $route, string $action, array $params = [])
    {
        if (array_key_exists($route, $this->config['routing']) === false) {
            throw new RouteException('Route not exist');
        }

        $action = \sprintf('action%s', ucfirst($action));
        return (new $this->config['routing'][$route][0]($this->config))->$action($params);
    }
}
